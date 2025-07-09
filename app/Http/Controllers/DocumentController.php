<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Category;
use App\Models\Tag;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Document::class, 'document');
    }

    public function index()
    {
        $documents = Document::with(['category', 'tags', 'user'])
            ->when(!auth()->user()->hasRole('admin'), function ($query) {
                return $query->where('user_id', auth()->id());
            })
            ->latest()
            ->paginate(10);

        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        $categories = Category::defaultOrder()->get();
        $tags = Tag::all();

        return view('documents.create', compact('categories', 'tags'));
    }

    public function store(StoreDocumentRequest $request)
    {
        $document = new Document($request->validated());
        $document->user_id = auth()->id();

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $document->file_type = $file->getClientMimeType();
            $document->file_size = $file->getSize();
            
            // Store document
            $document->addMediaFromRequest('document')
                ->toMediaCollection('documents');

            // Generate thumbnail for preview if it's a PDF
            if ($file->getClientMimeType() === 'application/pdf') {
                $thumbnail = Image::make($file->getFirstPage())
                    ->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->encode('jpg');
                
                $document->addMediaFromString($thumbnail->__toString())
                    ->toMediaCollection('thumbnails');
            }
        }

        $document->save();

        if ($request->has('tags')) {
            $document->tags()->sync($request->tags);
        }

        return redirect()->route('documents.show', $document)
            ->with('success', 'Dokumen berhasil diunggah.');
    }

    public function show(Document $document)
    {
        $document->load(['category', 'tags', 'user']);
        return view('documents.show', compact('document'));
    }

    public function edit(Document $document)
    {
        $categories = Category::defaultOrder()->get();
        $tags = Tag::all();

        return view('documents.edit', compact('document', 'categories', 'tags'));
    }

    public function update(UpdateDocumentRequest $request, Document $document)
    {
        $document->update($request->validated());

        if ($request->hasFile('document')) {
            // Delete old document and thumbnail
            $document->clearMediaCollection('documents');
            $document->clearMediaCollection('thumbnails');

            $file = $request->file('document');
            $document->file_type = $file->getClientMimeType();
            $document->file_size = $file->getSize();
            
            // Store new document
            $document->addMediaFromRequest('document')
                ->toMediaCollection('documents');

            // Generate new thumbnail for preview if it's a PDF
            if ($file->getClientMimeType() === 'application/pdf') {
                $thumbnail = Image::make($file->getFirstPage())
                    ->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->encode('jpg');
                
                $document->addMediaFromString($thumbnail->__toString())
                    ->toMediaCollection('thumbnails');
            }
        }

        if ($request->has('tags')) {
            $document->tags()->sync($request->tags);
        }

        return redirect()->route('documents.show', $document)
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Document $document)
    {
        $document->delete();

        return redirect()->route('documents.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }
}
