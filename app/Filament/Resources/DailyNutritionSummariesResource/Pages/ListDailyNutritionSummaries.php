<?php

namespace App\Filament\Resources\DailyNutritionSummariesResource\Pages;

use App\Filament\Resources\DailyNutritionSummariesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDailyNutritionSummaries extends ListRecords
{
    protected static string $resource = DailyNutritionSummariesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
