<?php

namespace App\Filament\Resources\NutritionNeedsByAgeResource\Pages;

use App\Filament\Resources\NutritionNeedsByAgeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNutritionNeedsByAge extends CreateRecord
{
    protected static string $resource = NutritionNeedsByAgeResource::class;
}
