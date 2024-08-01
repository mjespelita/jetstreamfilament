<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class ExportIns extends Page
{
    protected static ?string $navigationGroup = 'Reporting';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.export-ins';
}
