<?php

namespace App\Filament\Resources\NutritionNeedsByAgeResource\Pages;

use App\Filament\Resources\NutritionNeedsByAgeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNutritionNeedsByAge extends EditRecord
{
    protected static string $resource = NutritionNeedsByAgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
