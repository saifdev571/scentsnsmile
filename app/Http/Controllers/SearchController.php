<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Gender;
use App\Models\HighlightNote;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $genderFilter = $request->get('gender', 'all');
        $noteSlug = null;
        $selectedNote = null;
        
        // Get all active genders for filter tabs
        $genders = Gender::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();
        
        // Build product query
        $productsQuery = Product::with(['genders', 'tagsList', 'sizes', 'highlightNotes'])
            ->where('status', 'active');
        
        // Apply search query (enhanced text search across multiple fields and relationships)
        if ($query) {
            $productsQuery->where(function($q) use ($query) {
                // Search in product fields
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('short_description', 'like', '%' . $query . '%')
                  ->orWhere('description', 'like', '%' . $query . '%')
                  ->orWhere('inspired_by', 'like', '%' . $query . '%')
                  ->orWhere('ingredients', 'like', '%' . $query . '%')
                  
                  // Search in genders
                  ->orWhereHas('genders', function($gq) use ($query) {
                      $gq->where('name', 'like', '%' . $query . '%');
                  })
                  
                  // Search in categories
                  ->orWhereHas('category', function($cq) use ($query) {
                      $cq->where('name', 'like', '%' . $query . '%');
                  })
                  
                  // Search in scent families
                  ->orWhereHas('scentFamilies', function($sq) use ($query) {
                      $sq->where('name', 'like', '%' . $query . '%')
                        ->orWhere('description', 'like', '%' . $query . '%');
                  })
                  
                  // Search in highlight notes
                  ->orWhereHas('highlightNotes', function($hq) use ($query) {
                      $hq->where('name', 'like', '%' . $query . '%')
                        ->orWhere('description', 'like', '%' . $query . '%');
                  })
                  
                  // Search in tags
                  ->orWhereHas('tagsList', function($tq) use ($query) {
                      $tq->where('name', 'like', '%' . $query . '%')
                        ->orWhere('description', 'like', '%' . $query . '%');
                  })
                  
                  // Search in collections
                  ->orWhereHas('collectionsList', function($clq) use ($query) {
                      $clq->where('name', 'like', '%' . $query . '%')
                         ->orWhere('description', 'like', '%' . $query . '%');
                  })
                  
                  // Search in brand
                  ->orWhereHas('brand', function($bq) use ($query) {
                      $bq->where('name', 'like', '%' . $query . '%');
                  });
            });
        }
        
        // Apply gender filter
        if ($genderFilter && $genderFilter !== 'all') {
            $productsQuery->whereHas('genders', function($q) use ($genderFilter) {
                $q->where('genders.id', $genderFilter);
            });
        }
        
        // Get products
        $products = $productsQuery->orderBy('created_at', 'desc')->paginate(12);
        
        // Get counts per gender for filter tabs
        $genderCounts = [];
        $totalCount = 0;
        
        // Base query for counting (enhanced search)
        $baseCountQuery = function() use ($query) {
            $q = Product::where('status', 'active');
            
            if ($query) {
                $q->where(function($sq) use ($query) {
                    $sq->where('name', 'like', '%' . $query . '%')
                      ->orWhere('short_description', 'like', '%' . $query . '%')
                      ->orWhere('description', 'like', '%' . $query . '%')
                      ->orWhere('inspired_by', 'like', '%' . $query . '%')
                      ->orWhere('ingredients', 'like', '%' . $query . '%')
                      ->orWhereHas('genders', function($gq) use ($query) {
                          $gq->where('name', 'like', '%' . $query . '%');
                      })
                      ->orWhereHas('category', function($cq) use ($query) {
                          $cq->where('name', 'like', '%' . $query . '%');
                      })
                      ->orWhereHas('scentFamilies', function($sfq) use ($query) {
                          $sfq->where('name', 'like', '%' . $query . '%');
                      })
                      ->orWhereHas('highlightNotes', function($hq) use ($query) {
                          $hq->where('name', 'like', '%' . $query . '%');
                      })
                      ->orWhereHas('tagsList', function($tq) use ($query) {
                          $tq->where('name', 'like', '%' . $query . '%');
                      })
                      ->orWhereHas('collectionsList', function($clq) use ($query) {
                          $clq->where('name', 'like', '%' . $query . '%');
                      })
                      ->orWhereHas('brand', function($bq) use ($query) {
                          $bq->where('name', 'like', '%' . $query . '%');
                      });
                });
            }
            
            return $q;
        };
        
        // Total count
        $totalCount = $baseCountQuery()->count();
        
        // Count per gender
        foreach ($genders as $gender) {
            $genderCounts[$gender->id] = $baseCountQuery()
                ->whereHas('genders', function($q) use ($gender) {
                    $q->where('genders.id', $gender->id);
                })
                ->count();
        }
        
        return view('search', compact(
            'query',
            'genderFilter',
            'noteSlug',
            'selectedNote',
            'genders',
            'products',
            'genderCounts',
            'totalCount'
        ));
    }

    /**
     * Filter products by scent note (highlight note)
     * URL: /scent-notes/{slug}
     */
    public function byNote(Request $request, $slug)
    {
        $genderFilter = $request->get('gender', 'all');
        
        // Find the highlight note by slug
        $selectedNote = HighlightNote::where('slug', $slug)
            ->where('is_active', true)
            ->first();
        
        if (!$selectedNote) {
            abort(404, 'Scent note not found');
        }
        
        $noteSlug = $slug;
        $query = ''; // No text search for note filter
        
        // Get all active genders for filter tabs
        $genders = Gender::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();
        
        // Build product query - filter by highlight note
        $productsQuery = Product::with(['genders', 'tagsList', 'sizes', 'highlightNotes'])
            ->where('status', 'active')
            ->whereHas('highlightNotes', function($q) use ($selectedNote) {
                $q->where('highlight_notes.id', $selectedNote->id);
            });
        
        // Apply gender filter
        if ($genderFilter && $genderFilter !== 'all') {
            $productsQuery->whereHas('genders', function($q) use ($genderFilter) {
                $q->where('genders.id', $genderFilter);
            });
        }
        
        // Get products
        $products = $productsQuery->orderBy('created_at', 'desc')->paginate(12);
        
        // Get counts per gender
        $genderCounts = [];
        
        $baseCountQuery = function() use ($selectedNote) {
            return Product::where('status', 'active')
                ->whereHas('highlightNotes', function($q) use ($selectedNote) {
                    $q->where('highlight_notes.id', $selectedNote->id);
                });
        };
        
        $totalCount = $baseCountQuery()->count();
        
        foreach ($genders as $gender) {
            $genderCounts[$gender->id] = $baseCountQuery()
                ->whereHas('genders', function($q) use ($gender) {
                    $q->where('genders.id', $gender->id);
                })
                ->count();
        }
        
        return view('search', compact(
            'query',
            'genderFilter',
            'noteSlug',
            'selectedNote',
            'genders',
            'products',
            'genderCounts',
            'totalCount'
        ));
    }
}
