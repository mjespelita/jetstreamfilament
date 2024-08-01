<?php

namespace App\Filament\Exports;

use App\Models\Stocks;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class StocksExporter extends Exporter
{
    protected static ?string $model = Stocks::class;

    public static function getColumns(): array
    {
        return [
            'product_id',
            'name',
            'quantity'
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your stocks export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
