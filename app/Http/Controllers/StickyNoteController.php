<?php

namespace App\Http\Controllers;

use App\Models\StickyNote;
use Illuminate\Http\Request;

class StickyNoteController extends Controller
{
    public function index(Request $request)
    {
        $query = StickyNote::query();
        
        // Filter by color
        if ($request->has('color') && $request->color != 'all') {
            $query->where('color', $request->color);
        }
        
        // Sort notes
        if ($request->has('sort')) {
            [$column, $direction] = explode('-', $request->sort);
            if (in_array($column, ['created_at', 'title']) && in_array($direction, ['asc', 'desc'])) {
                $query->orderBy($column, $direction);
            }
        } else {
            $query->orderBy('created_at', 'desc'); // Default sort
        }
        
        $notes = $query->get();
        return view('sticky-notes.index', compact('notes'));
    }

    public function create()
    {
        $colors = StickyNote::availableColors();
        return view('sticky-notes.create', compact('colors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'color' => 'required|max:7'
        ]);

        StickyNote::create([
            'title' => $request->title,
            'content' => $request->content,
            'color' => $request->color
        ]);

        return redirect()->route('sticky-notes.index')->with('success', 'Catatan berhasil disimpan!');
    }
    
    public function show(StickyNote $stickyNote)
    {
        return view('sticky-notes.show', compact('stickyNote'));
    }

    public function edit(StickyNote $stickyNote)
    {
        $colors = StickyNote::availableColors();
        return view('sticky-notes.edit', compact('stickyNote', 'colors'));
    }

    public function update(Request $request, StickyNote $stickyNote)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'color' => 'required|max:7'
        ]);

        $stickyNote->update([
            'title' => $request->title,
            'content' => $request->content,
            'color' => $request->color
        ]);

        return redirect()->route('sticky-notes.index')->with('success', 'Catatan berhasil diupdate!');
    }

    public function destroy(StickyNote $stickyNote)
    {
        $stickyNote->delete();
        return redirect()->route('sticky-notes.index')->with('success', 'Catatan berhasil dihapus!');
    }
}