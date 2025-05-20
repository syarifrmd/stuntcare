<?php

namespace App\Filament\Resources\DailyIntakaesResource\Pages;

use App\Filament\Resources\DailyIntakaesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDailyIntakaes extends ListRecords
{
    protected static string $resource = DailyIntakaesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
