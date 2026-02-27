<?php

namespace App\Enums;

enum NoteCategory: string
{
    case Personal = 'personal';
    case Work     = 'work';
    case Ideas    = 'ideas';

    public function label(): string
    {
        return match ($this) {
            self::Personal => 'Personal',
            self::Work     => 'Work',
            self::Ideas    => 'Ideas',
        };
    }

    public function emoji(): string
    {
        return match ($this) {
            self::Personal => '🏠',
            self::Work     => '💼',
            self::Ideas    => '💡',
        };
    }

    public function badgeColor(): string
    {
        return match ($this) {
            self::Personal => 'bg-blue-100 text-blue-700',
            self::Work     => 'bg-purple-100 text-purple-700',
            self::Ideas    => 'bg-green-100 text-green-700',
        };
    }
}
