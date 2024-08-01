<?php

namespace App\Filament\Resources\StocksResource\Pages;

use App\Filament\Resources\StocksResource;
use App\Mail\TestMail;
use App\Smark\Smark;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CreateStocks extends CreateRecord
{
    protected static string $resource = StocksResource::class;

    protected function afterCreate(): void
    {
        $record = $this->record;

        Smark::log(Auth::user()->id, Auth::user()->name, "Created a stock. " . $record->name);
    }
}
