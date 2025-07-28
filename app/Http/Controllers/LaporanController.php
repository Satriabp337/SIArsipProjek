<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documents;
use App\Models\Category;
use App\Models\Department;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class LaporanController extends Controller
{
    public function index()
    {
        $query = Documents::query();

        if (request()->filled(['start', 'end'])) {
            $query->whereBetween('created_at', [request('start'), request('end')]);
        }

        $filteredDocs = $query->get();

        return view('laporan.index', [
            'totalDocuments' => $filteredDocs->count(),
            'totalDownloads' => $filteredDocs->sum('download_count'),
            'documentsPerCategory' => Category::withCount([
                'documents' => function ($q) {
                    if (request()->filled(['start', 'end'])) {
                        $q->whereBetween('created_at', [request('start'), request('end')]);
                    }
                }
            ])->get(),
            'mostDownloaded' => $filteredDocs->sortByDesc('download_count')->take(5),
            'latestDocuments' => $filteredDocs->sortByDesc('created_at')->take(5),
        ]);
    }


    public function getCategoryDocumentsChartData()
    {
        try {
            $query = Category::withCount([
                'documents' => function ($q) {
                    // Check if both start and end parameters exist
                    if (request()->filled('start') && request()->filled('end')) {
                        $q->whereBetween('created_at', [request('start'), request('end')]);
                    }
                }
            ])->get();

            // Debug logging
            \Log::info('Category query result:', [
                'count' => $query->count(),
                'filters' => [
                    'start' => request('start'),
                    'end' => request('end')
                ],
                'data' => $query->toArray()
            ]);
            
            if ($query->isEmpty()) {
                return response()->json([
                    'labels' => [],
                    'data' => [],
                    'message' => 'No category data found'
                ]);
            }

            return response()->json([
                'labels' => $query->pluck('name')->toArray(),
                'data' => $query->pluck('documents_count')->toArray(),
                'success' => true
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in getCategoryDocumentsChartData: ' . $e->getMessage());

            return response()->json([
                'labels' => [],
                'data' => [],
                'error' => 'Failed to load chart data',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Di Controller sebelum generate PDF
    public function generateChartImage($data)
    {
        // Menggunakan puppeteer atau library serupa
        // untuk convert chart ke image
        $chartUrl = route('chart.render', ['data' => $data]);
        $imagePath = public_path('temp/chart.png');

        // Generate image dari chart
        // Kemudian gunakan di PDF
        return $imagePath;
    }

    public function exportPdf(Request $request)
    {
        $query = Documents::query();

        if ($request->has(['start', 'end'])) {
            $query->whereBetween('created_at', [$request->input('start'), $request->input('end')]);
        }


        $filteredDocs = $query->get();

        $data = [
            'totalDocuments' => $filteredDocs->count(),
            'totalDownloads' => $filteredDocs->sum('download_count'),
            'documentsPerCategory' => Category::withCount([
                'documents' => function ($q) use ($request) {
                    if ($request->has(['start', 'end'])) {
                        $q->whereBetween('created_at', [$request->input('start'), $request->input('end')]);
                    }

                }
            ])->get(),
        ];

        $pdf = app('dompdf.wrapper')->loadView('laporan.pdf', $data);
        return $pdf->download('laporan-statistik.pdf');
    }
}