<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Models\Documents;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Traits\LogsAudit;

class DocumentsController extends Controller
{
    use LogsAudit;

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
        $document = Documents::create([
            'title' => $request->title,
            'nomor_surat' => $request->nomor_surat,
            'category_id' => $request->category_id,
            'sub_category' => $request->sub_category,
            'description' => $request->description,
            'tags' => $request->tags,
            'filename' => $path,
            'original_filename' => $file->getClientOriginalName(),
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
            'uploaded_by' => Auth::user()->name,
        ]);

        $this->logAudit('Document Upload', $document->title, Auth::user()->name . ' mengupload ' . $document->title);
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
                    ->orWhere('tags', 'like', '%' . $request->search . '%')
                    ->orWhere('nomor_surat', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Sorting - TAMBAHKAN INI
        switch ($request->get('sort')) {
            case 'created_at_desc':
                $query->orderBy('created_at', 'desc');
                break;
            case 'created_at_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc'); // Default sorting
                break;
        }

        $documents = $query->latest()->paginate(12);
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
            'nomor_surat',
            'category_id',
            'sub_category',
            // 'access_level',
            'tags',
            'description',
        ]));

        $this->logAudit('Document Edit', $document->title, Auth::user()->name . ' mengedit ' . $document->title);

        // Ganti return back() dengan redirect ke documents.index
        return redirect()->route('documents.index')
            ->with('success', 'Dokumen berhasil diubah.');
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

    public function destroy(Documents $document)
    {
        // Hapus file fisik dari storage jika ada
        if (Storage::exists($document->filename)) {
            Storage::delete($document->filename);
        }

        // Hapus record dari database
        $this->logAudit('Document Delete', $document->title, Auth::user()->name . ' menghapus ' . $document->title);
        $document->delete();

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil dihapus');
    }

    public function boot()
    {
        Paginator::useBootstrapFive(); // Atau useBootstrapFour sesuai versi
    }
}
