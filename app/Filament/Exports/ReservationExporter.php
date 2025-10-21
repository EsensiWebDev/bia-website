<?php

namespace App\Filament\Exports;

use App\Models\Reservation;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ReservationExporter extends Exporter
{
    protected static ?string $model = Reservation::class;
    public static bool $shouldDisableQueueing = false;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('first_name')->label('First Name'),
            ExportColumn::make('last_name')->label('Last Name'),
            ExportColumn::make('phone')->label('Phone'),
            ExportColumn::make('email')->label('Email'),
            ExportColumn::make('preferred_date')->label('Preferred Date'),
            ExportColumn::make('preferred_time')->label('Preferred Time'),
            ExportColumn::make('required_service')->label('Service'),
            ExportColumn::make('country_of_origin')->label('Country of Origin'),
            ExportColumn::make('how_did_you_find_out')->label('How Did You Find Out'),
            ExportColumn::make('message')->label('Message'),
            ExportColumn::make('created_at')->label('Dibuat Pada'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your reservation export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
