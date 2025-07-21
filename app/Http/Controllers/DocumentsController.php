<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Models\Documents;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class DocumentsController extends Controller
{
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'title' => 'required',
            'category_id' => 'required|exists:categories,id',
            // 'access_level' => 'required|in:Public,Internal,Confidential',
            'file' => 'required|file|max:51200|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png',
        ]);

        // Simpan file
        $file = $request->file('file');
        $path = $file->store('arsip', 'public');

        // Simpan ke DB
        Documents::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'sub_category' => $request->sub_category,
            // 'access_level' => $request->access_level,
            'description' => $request->description,
            'tags' => $request->tags,
            'filename' => $path,
            'original_filename' => $file->getClientOriginalName(),
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
        ]);

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diunggah!');
    }

    public function create()
    {
        $categories = Category::all();
        return view('upload.upload', compact('categories'));
    }

    public function index(Request $request)
    {
        $query = Documents::with(['category']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('tags', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $documents = $query->latest()->paginate(6);
        $categories = Category::all();

        return view('documents.index', compact('documents', 'categories'));
    }

    public function getFile($filename, Request $request)
    {
        $document = Documents::where('filename', $filename)->firstOrFail();
        $path = storage_path('app/public/' . $filename);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        $disposition = $request->query('disposition', 'inline');

        return response()->file($path, [
            'Content-Type' => mime_content_type($path),
            'Content-Disposition' => $disposition . '; filename="' . $document->original_filename . '"',
        ]);
    }

    public function edit($id)
    {
        $document = Documents::findOrFail($id);
        $categories = Category::all();

        return view('documents.edit', compact('document', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $document = Documents::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'category_id' => 'required|exists:categories,id',
            // 'access_level' => 'required|in:Public,Internal,Confidential',
        ]);

        $document->update($request->only([
            'title',
            'category_id',
            'sub_category',
            // 'access_level',
            'tags',
            'description',
        ]));

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function download($id)
    {
        $document = Documents::findOrFail($id);
        $document->increment('download_count');

        return response()->download(storage_path("app/public/" . $document->filename), $document->original_filename);
    }

    public function previewExcel($filename)
    {
        $filePath = storage_path('app/public/' . $filename);

        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        return view('documents.preview-excel', compact('data'));
    }

    public function boot()
    {
        Paginator::useBootstrapFive(); // Atau useBootstrapFour sesuai versi
    }
}
