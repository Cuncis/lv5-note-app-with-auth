@extends('layouts.app')

@section('title', 'Edit Note')

@section('content')

    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('notes.index') }}" class="text-sm text-yellow-600 hover:underline">← Back</a>
        <h1 class="text-2xl font-bold">Edit Note</h1>
    </div>

    <div class="bg-white border border-yellow-100 rounded-2xl shadow-sm p-6">
        <form action="{{ route('notes.update', $note) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Title <span class="text-red-400">*</span>
                </label>
                <input type="text" name="title"
                       value="{{ old('title', $note->title) }}"
                       class="w-full border rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400
                              {{ $errors->has('title') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Body</label>
                <textarea name="body" rows="10"
                          class="w-full border rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400
                                 {{ $errors->has('body') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">{{ old('body', $note->body) }}</textarea>
                @error('body')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-bold px-6 py-2.5 rounded-lg transition">
                    Save Changes
                </button>
                <a href="{{ route('notes.index') }}"
                   class="text-gray-500 hover:text-gray-700 px-4 py-2.5 rounded-lg border border-gray-300 text-sm transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    {{-- Danger zone --}}
    <div class="mt-6 bg-red-50 border border-red-100 rounded-2xl p-5">
        <p class="text-sm font-semibold text-red-600 mb-3">Danger Zone</p>
        <form action="{{ route('notes.destroy', $note) }}" method="POST"
              onsubmit="return confirm('Delete this note?')">
            @csrf @method('DELETE')
            <button class="text-sm text-red-500 hover:underline">🗑 Delete this note</button>
        </form>
    </div>

@endsection