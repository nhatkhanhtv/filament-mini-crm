<?php

namespace App\Providers;

use Filament\Infolists\Components\TextEntry;
use Filament\Support\Enums\FontWeight;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        TextEntry::macro('formatCurrency',function() {
            return $this
                ->formatStateUsing(fn($state) => number_format($state,0,'.',',')." ");
        });
        TextEntry::macro('formatOrderCurrency',function() {
            return $this
                ->formatCurrency()
                ->inlineLabel()
                ->weight(FontWeight::Bold)
                ->suffix(__('general.currency_unit'));
        });
    }
}
