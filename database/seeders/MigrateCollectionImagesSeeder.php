<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigrateCollectionImagesSeeder extends Seeder
{
    public function run(): void
    {
        // Copy image URLs to imagekit_url
        DB::table('collections')
            ->whereNotNull('image')
            ->where('image', '!=', '')
            ->update([
                'imagekit_url' => DB::raw('image')
            ]);

        echo "Collection images migrated successfully!\n";
    }
}
