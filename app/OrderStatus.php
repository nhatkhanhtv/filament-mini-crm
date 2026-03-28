<?php

namespace App;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum OrderStatus : int implements HasLabel, HasColor
{
    case new = 0;
    case processing = 1;
    case completed = 2;
    case cancelled = 3;

    public function getLabel(): string
    {
        return match ($this) {
            self::new => __('order.order_status.new'),
            self::processing => __('order.order_status.processing'),
            self::completed => __('order.order_status.completed'),
            self::cancelled => __('order.order_status.cancelled'),
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::new => 'info',
            self::processing => 'warning',
            self::completed => 'success',
            self::cancelled => 'danger',
        };
    }

}
