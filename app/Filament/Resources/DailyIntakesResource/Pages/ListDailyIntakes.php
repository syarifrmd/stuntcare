<?php

namespace App\Filament\Resources\DailyIntakesResource\Pages;

use App\Filament\Resources\DailyIntakesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDailyIntakes extends ListRecords
{
    protected static string $resource = DailyIntakesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
