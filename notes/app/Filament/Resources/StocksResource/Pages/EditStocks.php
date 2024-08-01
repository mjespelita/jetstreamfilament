<?php

namespace App\Filament\Resources\StocksResource\Pages;

use App\Filament\Resources\StocksResource;
use App\Smark\Smark;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditStocks extends EditRecord
{
    protected static string $resource = StocksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $record = $this->record;

        Smark::log(Auth::user()->id, Auth::user()->name, "Updated a stock. " . $record->name);
    }
}
