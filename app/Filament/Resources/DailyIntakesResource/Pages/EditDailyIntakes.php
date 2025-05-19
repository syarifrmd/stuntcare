<?php

namespace App\Filament\Resources\DailyIntakesResource\Pages;

use App\Filament\Resources\DailyIntakesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDailyIntakes extends EditRecord
{
    protected static string $resource = DailyIntakesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
