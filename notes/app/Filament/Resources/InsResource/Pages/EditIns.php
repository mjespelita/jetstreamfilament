<?php

namespace App\Filament\Resources\InsResource\Pages;

use App\Filament\Resources\InsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIns extends EditRecord
{
    protected static string $resource = InsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
