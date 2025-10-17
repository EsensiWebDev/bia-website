<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Reservation;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ReservationResource\Pages;
use App\Filament\Resources\ReservationResource\RelationManagers;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                    Grid::make(3)->schema([
                        TextInput::make('required_service')->disabled(),
                        TextInput::make('country_of_origin')->disabled(),
                        TextInput::make('how_did_you_find_out')->disabled(),
                    ]),
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
            // ...
            ->actions([
                // Tambahkan ViewAction untuk fungsionalitas Preview
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            // 💡 Pastikan ada halaman 'view' untuk Preview Detail
            // 'view' => Pages\ViewReservation::route('/{record}'),
            // Anda bisa hapus 'create' dan 'edit' jika reservasi hanya masuk dari frontend
        ];
    }
}
