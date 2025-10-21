<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Reservation;
use App\Models\CategoryTreatment;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\Filter;
use App\Filament\Resources\ReservationResource\Pages;
use pxlrbt\FilamentExcel\Columns\Column;
// use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
// use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Filament\Tables\Actions\ExportAction;
use App\Filament\Exports\ReservationExporter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\{ActionGroup,  DeleteAction, ViewAction};

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;
    protected static ?string $navigationLabel = 'Booking Reservation';

    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-c-calendar-date-range';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Reservation Details')->schema([
                    Grid::make(3)->schema([
                        TextInput::make('first_name')->disabled(),
                        TextInput::make('last_name')->disabled(),
                        TextInput::make('phone')->disabled(),
                    ]),
                    Grid::make(3)->schema([
                        TextInput::make('email')->disabled(),
                        DatePicker::make('preferred_date')->disabled(),
                        TextInput::make('preferred_time')->disabled(),
                    ]),
                    Grid::make(2)->schema([
                        TextInput::make('required_service')->disabled(),
                        TextInput::make('country_of_origin')->disabled(),
                    ]),
                    Textarea::make('how_did_you_find_out')->columnSpanFull()->disabled(),
                    Textarea::make('message')->columnSpanFull()->disabled(),
                    DatePicker::make('created_at')->label('Dibuat Pada')->disabled(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')->label('Nama Depan')->searchable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('preferred_date')->label('Tanggal')->date('d M Y')->sortable(),
                TextColumn::make('preferred_time')->label('Waktu'),
                TextColumn::make('required_service')->label('Layanan'),
                TextColumn::make('created_at')->label('Diterima')->dateTime('d M Y H:i')->sortable(),
            ])
            ->filters([
                Filter::make('preferred_date')
                    ->form([
                        DatePicker::make('from')->label('From Date')->displayFormat('d/m/Y'),
                        DatePicker::make('until')->label('To Date')->displayFormat('d/m/Y'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn($q) => $q->whereDate('preferred_date', '>=', $data['from']))
                            ->when($data['until'], fn($q) => $q->whereDate('preferred_date', '<=', $data['until']));
                    }),

                SelectFilter::make('required_service')
                    ->label('Required Service')
                    ->options(
                        CategoryTreatment::query()
                            ->orderBy('title')
                            ->pluck('title', 'title')
                            ->toArray()
                    )
                    ->searchable()
                    ->placeholder('Select service type'),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(ReservationExporter::class)
                    ->label('Export Excel')
                    ->fileName(fn($export) => 'reservations-export-' . now()->format('Ymd_His')),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    DeleteAction::make(),
                ])
                    ->button()
                    ->label('Actions'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReservations::route('/'),
        ];
    }
}
