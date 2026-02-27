<?php

namespace App\Http\Controllers;

use App\Enums\NoteCategory;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user     = auth()->user();
        $category = $request->query('category');
        $q        = trim($request->query('q', ''));

        $query = $user->notes();

        if ($category && NoteCategory::tryFrom($category)) {
            $query->where('category', $category);
        }

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('body', 'like', "%{$q}%");
            });
        }

        $pinned   = (clone $query)->pinned()->get();
        $unpinned = (clone $query)->unpinned()->get();

        $categories = NoteCategory::cases();

        return view('notes.index', compact('pinned', 'unpinned', 'categories', 'category', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'    => 'required|string|max:255',
            'body'     => 'nullable|string',
            'category' => 'required|in:personal,work,ideas',
        ]);

        auth()->user()->notes()->create($validated);

        return redirect()->route('notes.index')->with('success', '📝 Note created!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        $this->authorize('update', $note);

        return view('notes.edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        $this->authorize('update', $note);

        $validated = $request->validate([
            'title'    => 'required|string|max:255',
            'body'     => 'nullable|string',
            'category' => 'required|in:personal,work,ideas',
        ]);

        $note->update($validated);

        return redirect()->route('notes.index')->with('success', '✏️ Note updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        $this->authorize('delete', $note);

        $note->delete();

        return redirect()->route('notes.index')->with('success', '🗑️ Note deleted!');
    }

    public function togglePin(Note $note)
    {
        $this->authorize('update', $note);

        $note->update(['is_pinned' => !$note->is_pinned]);

        return redirect()->route('notes.index')->with('success', $note->is_pinned ? '📌 Note pinned!' : '📍 Note unpinned!');
    }
}
