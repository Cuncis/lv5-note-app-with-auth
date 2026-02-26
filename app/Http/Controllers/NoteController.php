<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $pinned = $user->notes()->pinned()->get();
        $unpinned = $user->notes()->unpinned()->get();

        return view('notes.index', compact('pinned', 'unpinned'));
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
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
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
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
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
