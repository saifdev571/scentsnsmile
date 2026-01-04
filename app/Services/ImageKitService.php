<?php

namespace App\Services;

use ImageKit\ImageKit;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImageKitService
{
    private $imagekit;
    private $urlEndpoint;

    public function __construct()
    {
        $this->initializeImageKit();
    }

    private function initializeImageKit()
    {
        try {
            // Try to get credentials from database first
            $publicKey = DB::table('settings')->where('key', 'imagekit_public_key')->value('value');
            $privateKey = DB::table('settings')->where('key', 'imagekit_private_key')->value('value');
            $this->urlEndpoint = DB::table('settings')->where('key', 'imagekit_url_endpoint')->value('value');

            // Fallback to .env if not found in database
            if (!$publicKey || !$privateKey || !$this->urlEndpoint) {
                $publicKey = env('IMAGEKIT_PUBLIC_KEY');
                $privateKey = env('IMAGEKIT_PRIVATE_KEY');
                $this->urlEndpoint = env('IMAGEKIT_URL_ENDPOINT');
            }

            if (!$publicKey || !$privateKey || !$this->urlEndpoint) {
                throw new \Exception('ImageKit credentials not found in database or .env file');
            }

            $this->imagekit = new ImageKit(
                $publicKey,
                $privateKey,
                $this->urlEndpoint
            );

        } catch (\Exception $e) {
            Log::error('ImageKit initialization failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function uploadCategoryImage(UploadedFile $file, string $folder = 'categories', string $fileName = null): ?array
    {
        try {

            if (!$file->isValid()) {
                throw new \Exception('Invalid file uploaded');
            }

            $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            if (!in_array($file->getMimeType(), $allowedMimes)) {
                throw new \Exception('Only JPEG, PNG and WebP images are allowed');
            }

            if (!$fileName) {
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            }

            $originalData = file_get_contents($file->getPathname());
            $originalSize = strlen($originalData);
            
            // Check if GD extension is available
            if (extension_loaded('gd')) {
                $compressedImage = $this->compressOnly($file, 75);
                $compressedSize = strlen($compressedImage['data']);
                
                if ($compressedSize < $originalSize) {
                    $fileContent = base64_encode($compressedImage['data']);
                    $imageWidth = $compressedImage['width'];
                    $imageHeight = $compressedImage['height'];
                    $actualSize = $compressedSize;
                } else {
                    $fileContent = base64_encode($originalData);
                    $image = imagecreatefromstring($originalData);
                    $imageWidth = imagesx($image);
                    $imageHeight = imagesy($image);
                    imagedestroy($image);
                    $actualSize = $originalSize;
                }
            } else {
                // GD not available, upload original file
                $fileContent = base64_encode($originalData);
                $actualSize = $originalSize;
                
                // Try to get dimensions using getimagesize
                $imageInfo = @getimagesize($file->getPathname());
                $imageWidth = $imageInfo[0] ?? 0;
                $imageHeight = $imageInfo[1] ?? 0;
            }

            $uploadParams = [
                'file' => $fileContent,
                'fileName' => $fileName,
                'folder' => $folder,
                'useUniqueFileName' => false,
                'tags' => ['category', 'ecommerce']
            ];

            Log::info('Uploading to ImageKit with params', [
                'fileName' => $fileName,
                'folder' => $folder,
                'fileSize' => $file->getSize(),
                'mimeType' => $file->getMimeType()
            ]);

            $response = $this->imagekit->upload($uploadParams);

            Log::info('ImageKit upload response', ['response' => $response]);

            if (isset($response->result) && $response->result && ($response->error === null || !isset($response->error))) {

                return [
                    'success' => true,
                    'file_id' => $response->result->fileId,
                    'name' => $response->result->name,
                    'url' => $response->result->url,
                    'thumbnail_url' => $response->result->thumbnailUrl,
                    'file_path' => $response->result->filePath,
                    'size' => $actualSize,
                    'original_size' => $file->getSize(),
                    'width' => $imageWidth,
                    'height' => $imageHeight,
                    'format' => $response->result->fileType ?? $file->getClientOriginalExtension()
                ];
            } else {
                Log::error('ImageKit upload failed', ['response' => $response]);
                return null;
            }

        } catch (\Exception $e) {
            Log::error('ImageKit upload error: ' . $e->getMessage(), [
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType()
            ]);
            return null;
        }
    }

    public function deleteImage(string $fileId): bool
    {
        try {
            $response = $this->imagekit->deleteFile($fileId);

            return isset($response->responseMetadata->statusCode) && $response->responseMetadata->statusCode == 204;
        } catch (\Exception $e) {
            Log::error('ImageKit delete error: ' . $e->getMessage(), ['file_id' => $fileId]);
            return false;
        }
    }

    public function getOptimizedUrl(string $filePath, int $width = 540, int $height = 689, int $quality = 80): string
    {
        try {
            $transformations = [
                [
                    'width' => $width,
                    'height' => $height,
                    'crop' => 'maintain_ratio',
                    'quality' => $quality,
                    'format' => 'auto'
                ]
            ];

            return $this->imagekit->url([
                'path' => $filePath,
                'transformation' => $transformations
            ]);
        } catch (\Exception $e) {
            Log::error('ImageKit URL generation error: ' . $e->getMessage());
            return $this->urlEndpoint . $filePath;
        }
    }

    public function uploadProductImage(UploadedFile $file, string $folder = 'products', string $fileName = null): ?array
    {
        try {

            if (!$file->isValid()) {
                throw new \Exception('Invalid file uploaded');
            }

            $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            if (!in_array($file->getMimeType(), $allowedMimes)) {
                throw new \Exception('Only JPEG, PNG and WebP images are allowed');
            }

            if (!$fileName) {
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            }

            // Upload original image without compression/resize
            $originalData = file_get_contents($file->getPathname());
            $fileContent = base64_encode($originalData);
            $actualSize = strlen($originalData);
            
            // Get original dimensions
            $imageInfo = @getimagesize($file->getPathname());
            $imageWidth = $imageInfo[0] ?? 0;
            $imageHeight = $imageInfo[1] ?? 0;

            $uploadParams = [
                'file' => $fileContent,
                'fileName' => $fileName,
                'folder' => $folder,
                'useUniqueFileName' => false,
                'tags' => ['product', 'ecommerce']
            ];

            Log::info('Uploading product image to ImageKit (original, no compression)', [
                'fileName' => $fileName,
                'folder' => $folder,
                'fileSize' => $file->getSize(),
                'mimeType' => $file->getMimeType()
            ]);

            $response = $this->imagekit->upload($uploadParams);

            Log::info('ImageKit product upload response', ['response' => $response]);

            if (isset($response->result) && $response->result && ($response->error === null || !isset($response->error))) {

                return [
                    'success' => true,
                    'file_id' => $response->result->fileId,
                    'name' => $response->result->name,
                    'url' => $response->result->url,
                    'thumbnail_url' => $response->result->thumbnailUrl,
                    'file_path' => $response->result->filePath,
                    'size' => $actualSize,
                    'original_size' => $file->getSize(),
                    'width' => $imageWidth,
                    'height' => $imageHeight,
                    'format' => $response->result->fileType ?? $file->getClientOriginalExtension()
                ];
            } else {
                Log::error('ImageKit product upload failed', ['response' => $response]);
                return null;
            }

        } catch (\Exception $e) {
            Log::error('ImageKit product upload error: ' . $e->getMessage(), [
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType()
            ]);
            return null;
        }
    }

    public function getThumbnailUrl(string $filePath): string
    {
        return $this->getOptimizedUrl($filePath, 150, 150, 70);
    }

    /**
     * Upload image without any compression or resize (for highlight notes, icons, etc.)
     */
    public function uploadRawImage(UploadedFile $file, string $folder = 'highlight-notes', string $fileName = null): ?array
    {
        try {
            if (!$file->isValid()) {
                throw new \Exception('Invalid file uploaded');
            }

            $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/gif', 'image/svg+xml'];
            if (!in_array($file->getMimeType(), $allowedMimes)) {
                throw new \Exception('Only JPEG, PNG, WebP, GIF and SVG images are allowed');
            }

            if (!$fileName) {
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            }

            // Upload original image WITHOUT any compression or resize
            $originalData = file_get_contents($file->getPathname());
            $fileContent = base64_encode($originalData);
            $actualSize = strlen($originalData);
            
            // Get original dimensions
            $imageInfo = @getimagesize($file->getPathname());
            $imageWidth = $imageInfo[0] ?? 0;
            $imageHeight = $imageInfo[1] ?? 0;

            $uploadParams = [
                'file' => $fileContent,
                'fileName' => $fileName,
                'folder' => $folder,
                'useUniqueFileName' => false,
                'tags' => ['highlight-note', 'icon', 'raw']
            ];

            Log::info('Uploading raw image to ImageKit (no compression/resize)', [
                'fileName' => $fileName,
                'folder' => $folder,
                'fileSize' => $file->getSize(),
                'mimeType' => $file->getMimeType()
            ]);

            $response = $this->imagekit->upload($uploadParams);

            if (isset($response->result) && $response->result && ($response->error === null || !isset($response->error))) {
                return [
                    'success' => true,
                    'file_id' => $response->result->fileId,
                    'name' => $response->result->name,
                    'url' => $response->result->url,
                    'thumbnail_url' => $response->result->thumbnailUrl,
                    'file_path' => $response->result->filePath,
                    'size' => $actualSize,
                    'original_size' => $file->getSize(),
                    'width' => $imageWidth,
                    'height' => $imageHeight,
                    'format' => $response->result->fileType ?? $file->getClientOriginalExtension()
                ];
            } else {
                Log::error('ImageKit raw upload failed', ['response' => $response]);
                return null;
            }

        } catch (\Exception $e) {
            Log::error('ImageKit raw upload error: ' . $e->getMessage(), [
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType()
            ]);
            return null;
        }
    }

    public function getListUrl(string $filePath): string
    {
        return $this->getOptimizedUrl($filePath, 200, 200, 75);
    }

    private function compressOnly(UploadedFile $file, int $quality): array
    {
        $imageData = file_get_contents($file->getPathname());
        $image = imagecreatefromstring($imageData);
        
        if ($image === false) {
            throw new \Exception('Failed to create image from file');
        }

        $width = imagesx($image);
        $height = imagesy($image);

        ob_start();
        imagejpeg($image, null, $quality);
        $compressedData = ob_get_clean();

        imagedestroy($image);

        return [
            'data' => $compressedData,
            'width' => $width,
            'height' => $height
        ];
    }
}
