<?php

namespace App;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum CustomerStatus : int implements HasLabel, HasColor
{
    case New = 0;
    case Meeting = 1;
    case Won = 2;
    case Lost = 3;

    public function getLabel(): string
    {
        return match ($this) {
            self::New => 'Mới',
            self::Meeting => 'Hẹn gặp',
            self::Won => 'Chốt',
            self::Lost => 'Tạm dừng',
        };
    }

    public function getColor() : string | array | null{
        return match($this) {
            self::New => 'info',
            self::Meeting => 'primary',
            self::Won => 'success',
            self::Lost => 'danger',
        };
    }
}
