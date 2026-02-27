@extends('layouts.app')

@section('title', 'My Notes')

@section('content')

    <div class="mb-6 flex items-end justify-between">
        <div>
            <h1 class="text-2xl font-bold">My Notes</h1>
            <p class="text-gray-500 text-sm mt-1">
                {{ $pinned->count() + $unpinned->count() }} note(s)
            </p>
        </div>
        <a href="{{ route('notes.create') }}"
            class="bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-bold px-4 py-2 rounded-lg text-sm transition">
            + New Note
        </a>
    </div>

    {{-- ===== CATEGORY FILTER TABS ===== --}}
    <div class="flex flex-wrap gap-2 mb-8">
        <a href="{{ route('notes.index') }}" class="px-4 py-1.5 rounded-full text-sm font-medium transition
                      {{ !$category ? 'bg-yellow-400 text-yellow-900' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            All
        </a>
        @foreach ($categories as $cat)
            <a href="{{ route('notes.index', ['category' => $cat->value]) }}"
                class="px-4 py-1.5 rounded-full text-sm font-medium transition
                              {{ $category === $cat->value ? $cat->badgeColor() . ' ring-2 ring-offset-1 ring-current' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                {{ $cat->emoji() }} {{ $cat->label() }}
            </a>
        @endforeach
    </div>

    {{-- ===== PINNED ===== --}}
    @if ($pinned->count())
        <div class="mb-8">
            <h2 class="text-xs font-bold text-yellow-600 uppercase tracking-widest mb-3">
                📌 Pinned
            </h2>
            <div class="grid gap-3">
                @foreach ($pinned as $note)
                    @include('notes._card', ['note' => $note])
                @endforeach
            </div>
        </div>
    @endif

    {{-- ===== OTHER NOTES ===== --}}
    <div>
        @if ($pinned->count())
            <h2 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Others</h2>
        @endif

        @forelse ($unpinned as $note)
            @include('notes._card', ['note' => $note])
        @empty
            @if (!$pinned->count())
                <div class="text-center py-20 text-gray-400">
                    <p class="text-5xl mb-4">📭</p>
                    <p class="font-medium text-gray-500">No notes yet</p>
                    <a href="{{ route('notes.create') }}"
                        class="inline-block mt-4 bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-bold px-6 py-2 rounded-lg text-sm transition">
                        Write your first note
                    </a>
                </div>
            @endif
        @endforelse
    </div>

@endsection