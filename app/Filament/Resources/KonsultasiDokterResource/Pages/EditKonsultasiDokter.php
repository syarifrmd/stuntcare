<?php

namespace App\Filament\Resources\KonsultasiDokterResource\Pages;

use App\Filament\Resources\KonsultasiDokterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKonsultasiDokter extends EditRecord
{
    protected static string $resource = KonsultasiDokterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
