<?php

namespace App\Filament\Resources\ChildrenResource\Pages;

use App\Filament\Resources\ChildrenResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChildren extends EditRecord
{
    protected static string $resource = ChildrenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
