<?php

namespace App\Filament\Resources\NutritionNeedsByAgeResource\Pages;

use App\Filament\Resources\NutritionNeedsByAgeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNutritionNeedsByAges extends ListRecords
{
    protected static string $resource = NutritionNeedsByAgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
