<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documents;
use App\Models\Category;
use App\Models\Department;
use Barryvdh\DomPDF\PDF;

class LaporanController extends Controller
{
    public function index()
    {
        $query = Documents::query();

        if (request()->start && request()->end) {
            $query->whereBetween('created_at', [request()->start, request()->end]);
        }

        $filteredDocs = $query->get();

        return view('laporan.index', [
            'totalDocuments' => $filteredDocs->count(),
            'totalDownloads' => $filteredDocs->sum('download_count'),
            'documentsPerCategory' => Category::withCount(['documents' => function ($q) {
                if (request()->start && request()->end) {
                    $q->whereBetween('created_at', [request()->start, request()->end]);
                }
            }])->get(),
            'documentsPerDepartment' => Department::withCount(['documents' => function ($q) {
                if (request()->start && request()->end) {
                    $q->whereBetween('created_at', [request()->start, request()->end]);
                }
            }])->get(),
            'mostDownloaded' => $filteredDocs->sortByDesc('download_count')->take(5),
            'latestDocuments' => $filteredDocs->sortByDesc('created_at')->take(5),
        ]);
    }

    public function getCategoryDocumentsChartData()
    {
        // Fetch your data, similar to how you're doing it in the Blade file
        $query = Category::withCount(['documents' => function ($q) {
            if (request()->start && request()->end) {
                $q->whereBetween('created_at', [request()->start, request()->end]);
            }
        }])->get();

        return response()->json([
            'labels' => $query->pluck('name'),
            'data' => $query->pluck('documents_count')
        ]);
    }

    public function chartDepartment()
    {
        $query = Department::withCount(['documents' => function ($q) {
            if (request()->start && request()->end) {
                $q->whereBetween('created_at', [request()->start, request()->end]);
            }
        }])->get();

        return response()->json([
            'labels' => $query->pluck('name'),
            'data' => $query->pluck('documents_count')
        ]);
    }

    public function exportPdf(Request $request)
    {
        $query = Documents::query();

        if ($request->start && $request->end) {
            $query->whereBetween('created_at', [$request->start, $request->end]);
        }

        $filteredDocs = $query->get();

        $data = [
            'totalDocuments' => $filteredDocs->count(),
            'totalDownloads' => $filteredDocs->sum('download_count'),
            'documentsPerCategory' => Category::withCount(['documents' => function ($q) use ($request) {
                if ($request->start && $request->end) {
                    $q->whereBetween('created_at', [$request->start, $request->end]);
                }
            }])->get(),
            'documentsPerDepartment' => Department::withCount(['documents' => function ($q) use ($request) {
                if ($request->start && $request->end) {
                    $q->whereBetween('created_at', [$request->start, $request->end]);
                }
            }])->get(),
        ];

        $pdf = app('dompdf.wrapper')->loadView('laporan.pdf', $data);
        return $pdf->download('laporan-statistik.pdf');
    }
}
