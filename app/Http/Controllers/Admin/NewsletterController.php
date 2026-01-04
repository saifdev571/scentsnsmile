<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function index(Request $request)
    {
        $query = NewsletterSubscriber::query();

        // Search
        if ($request->filled('search')) {
            $query->where('email', 'like', '%' . $request->search . '%');
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $subscribers = $query->orderBy('created_at', 'desc')->paginate(20);

        $stats = [
            'total' => NewsletterSubscriber::count(),
            'active' => NewsletterSubscriber::where('is_active', true)->count(),
            'unsubscribed' => NewsletterSubscriber::where('is_active', false)->count(),
        ];

        return view('admin.newsletter.index', compact('subscribers', 'stats'));
    }

    public function destroy($id)
    {
        $subscriber = NewsletterSubscriber::findOrFail($id);
        $subscriber->delete();

        return response()->json([
            'success' => true,
            'message' => 'Subscriber deleted successfully'
        ]);
    }

    public function toggle($id)
    {
        $subscriber = NewsletterSubscriber::findOrFail($id);
        $subscriber->is_active = !$subscriber->is_active;
        
        if (!$subscriber->is_active) {
            $subscriber->unsubscribed_at = now();
        } else {
            $subscriber->unsubscribed_at = null;
            $subscriber->subscribed_at = now();
        }
        
        $subscriber->save();

        return response()->json([
            'success' => true,
            'message' => $subscriber->is_active ? 'Subscriber activated' : 'Subscriber deactivated',
            'is_active' => $subscriber->is_active
        ]);
    }

    public function export()
    {
        $subscribers = NewsletterSubscriber::where('is_active', true)
            ->orderBy('email')
            ->get(['email', 'subscribed_at']);

        $filename = 'newsletter_subscribers_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($subscribers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Email', 'Subscribed At']);
            
            foreach ($subscribers as $subscriber) {
                fputcsv($file, [
                    $subscriber->email,
                    $subscriber->subscribed_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        
        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'No subscribers selected'
            ], 400);
        }

        NewsletterSubscriber::whereIn('id', $ids)->delete();

        return response()->json([
            'success' => true,
            'message' => count($ids) . ' subscribers deleted successfully'
        ]);
    }
}
