{{--
Partial: notes/_card.blade.php
Usage: @include('notes._card', ['note' => $note])
--}}

<div class="bg-white border border-yellow-100 rounded-2xl shadow-sm px-5 py-4 mb-3 hover:shadow-md transition">

    <div class="flex items-start justify-between gap-3">
        <div class="min-w-0 flex-1">
            <div class="flex items-center gap-2 mb-1">
                <h3 class="font-semibold text-gray-900 truncate">{{ $note->title }}</h3>
                @if ($note->category)
                    <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $note->category->badgeColor() }}">
                        {{ $note->category->emoji() }} {{ $note->category->label() }}
                    </span>
                @endif
            </div>
            @if ($note->body)
                <p class="text-gray-500 text-sm mt-1 line-clamp-2">{{ $note->body }}</p>
            @endif
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-3 flex-shrink-0 text-sm">

            {{-- Pin toggle --}}
            <form action="{{ route('notes.toggle-pin', $note) }}" method="POST">
                @csrf @method('PATCH')
                <button class="hover:scale-110 transition text-lg leading-none"
                    title="{{ $note->pinned ? 'Unpin' : 'Pin' }}">
                    {{ $note->pinned ? '📌' : '🔘' }}
                </button>
            </form>

            <a href="{{ route('notes.edit', $note) }}" class="text-yellow-600 hover:underline">Edit</a>

            <form action="{{ route('notes.destroy', $note) }}" method="POST"
                onsubmit="return confirm('Delete this note?')">
                @csrf @method('DELETE')
                <button class="text-red-400 hover:text-red-600 transition">Delete</button>
            </form>
        </div>
    </div>

    <p class="text-xs text-gray-400 mt-3">{{ $note->updated_at->diffForHumans() }}</p>

</div>