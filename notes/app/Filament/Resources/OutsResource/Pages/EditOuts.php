<?php

namespace App\Filament\Resources\OutsResource\Pages;

use App\Filament\Resources\OutsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOuts extends EditRecord
{
    protected static string $resource = OutsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
