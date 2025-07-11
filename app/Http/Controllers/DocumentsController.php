<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documents;
use App\Models\Department;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class DocumentsController extends Controller
{
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'title' => 'required',
            'category_id' => 'required|exists:categories,id',
            'department_id' => 'required|exists:departments,id',
            'access_level' => 'required|in:Public,Internal,Confidential',
            'file' => 'required|file|max:51200|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx',
        ]);

        // Simpan file
        $file = $request->file('file');
        $path = $file->store('arsip', 'public');

        // Simpan ke DB
        Documents::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'sub_category' => $request->sub_category,
            'department_id' => $request->department_id,
            'access_level' => $request->access_level,
            'description' => $request->description,
            'tags' => $request->tags,
            'filename' => $path,
            'original_filename' => $file->getClientOriginalName(),
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
        ]);

        return redirect()->back()->with('success', 'Dokumen berhasil diupload.');
    }

    public function create()
    {
        $departments = Department::all();
        $categories = Category::all();

        return view('upload.upload', compact('departments', 'categories'));
    }

    public function index()
    {
        $documents = Documents::with(['category', 'department'])->latest()->get();
        return view('documents.documents', compact('documents'));
    }

    public function getFile($filename, Request $request)
    {
        $filePath = 'public/' . $filename;

        if (!Storage::exists($filePath)) {
            abort(404, 'File not found: ' . $filename);
        }

        $disposition = $request->query('disposition', 'inline'); // default to inline

        try {
            return Storage::response($filePath, null, ['Content-Disposition' => $disposition]);
        } catch (\Exception $e) {
            abort(500, 'Error serving file: ' . $e->getMessage());
        }
    }
}
