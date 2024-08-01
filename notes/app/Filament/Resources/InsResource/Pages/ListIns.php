<?php

namespace App\Filament\Resources\InsResource\Pages;

use App\Filament\Resources\InsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIns extends ListRecords
{
    protected static string $resource = InsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            InsResource\Widgets\Ins::class,
        ];
    }
}
