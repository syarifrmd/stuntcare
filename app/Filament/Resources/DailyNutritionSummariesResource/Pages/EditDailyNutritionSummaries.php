<?php

namespace App\Filament\Resources\DailyNutritionSummariesResource\Pages;

use App\Filament\Resources\DailyNutritionSummariesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDailyNutritionSummaries extends EditRecord
{
    protected static string $resource = DailyNutritionSummariesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
