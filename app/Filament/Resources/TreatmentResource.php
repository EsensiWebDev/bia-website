<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Carbon\Carbon;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Treatment;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Split;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\RichEditor;
use App\Filament\Forms\ValidationExceptions;
use Illuminate\Validation\ValidationException;
use App\Filament\Resources\TreatmentResource\Pages;
// use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Tables\Actions\{Action, ActionGroup, EditAction, DeleteAction, BulkActionGroup, DeleteBulkAction};
use Filament\Forms\Components\{Repeater, FileUpload, TextInput, Textarea, Select};

class TreatmentResource extends Resource
{
    protected static ?string $model = Treatment::class;
    protected static ?string $navigationGroup = 'Treatments';
    protected static ?string $navigationIcon = null;
    protected static ?string $navigationLabel = 'Treatment List';
    protected static ?string $pluralLabel = 'Treatments';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(1) // 1 kolom → semua field full width
                ->schema([
                    Split::make([
                        // Kolom Kiri
                        Card::make('Treatment Details')
                            ->description('Basic information, content, and the main description.')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Treatment Title')
                                            ->required()
                                            ->maxLength(255)
                                            ->reactive()
                                            ->afterStateUpdated(function ($state, Set $set, $get) {
                                                if (blank($get('slug'))) {
                                                    $set('slug', Str::slug($state));
                                                }
                                            }),

                                        TextInput::make('slug')
                                            ->label('Slug')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(255)
                                            ->placeholder('Auto-generated from title')
                                            ->reactive()
                                            ->suffixAction(
                                                FormAction::make('generateSlug')
                                                    ->label('Generate')
                                                    ->icon('heroicon-o-arrow-path') // ganti icon kalau mau
                                                    ->action(function (Forms\Get $get, Forms\Set $set) {
                                                        $title = $get('title') ?? '';
                                                        $set('slug', Str::slug($title));
                                                    })
                                            )
                                            ->afterStateUpdated(function ($state, Set $set) {
                                                if (! blank($state)) {
                                                    $set('slug', Str::slug($state));
                                                }
                                            }),
                                    ]),

                                Select::make('category_treatment_id')
                                    ->relationship('category', 'title')
                                    ->label('Category')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                RichEditor::make('desc')
                                    ->toolbarButtons([
                                        'bulletList',
                                        'orderedList',
                                        'bold',
                                        'italic',
                                        'link',
                                        'underline',
                                        'undo',
                                        'redo',
                                    ])
                                    ->required(),

                                RichEditor::make('maintenance')
                                    ->toolbarButtons([
                                        'h2',
                                        'bulletList',
                                        'orderedList',
                                        'bold',
                                        'italic',
                                        'link',
                                        'underline',
                                        'undo',
                                        'redo',
                                    ])
                                    ->label('Maintenance')
                                    ->required()
                                    ->columnSpanFull(),
                            ])->columns(1)
                            ->grow(),

                        // Kolom Kanan
                        Card::make('Sidebar')
                            ->description('Media, contact, and SEO settings.')
                            ->schema([
                                FileUpload::make('thumbnail')
                                    ->image()
                                    ->maxSize(500) // max 500 KB
                                    ->label('Thumbnail')
                                    ->directory(fn(Get $get) => Treatment::getUploadDirectory('thumbnail', $get))

                                    ->getUploadedFileNameForStorageUsing(function ($file, Get $get) {
                                        // Ambil slug terbaru dari form. Jika kosong, fallback ke 'thumbnail'
                                        $slug = $get('slug') ?: Str::slug($get('title') ?? 'thumbnail');
                                        $ext  = $file->getClientOriginalExtension();
                                        return "{$slug}.{$ext}";
                                    })
                                    ->visibility('public')
                                    ->imagePreviewHeight('150')
                                    ->imageResizeMode('cover')
                                    ->required()
                                    ->disk('public'),

                                // Thumbnail alt text
                                TextInput::make('thumbnail_alt_text')
                                    ->label('Thumbnail Alt Text')
                                    ->placeholder('Enter alt text for the thumbnail')
                                    ->columnSpanFull()
                                    ->reactive()
                                    ->maxLength(100)
                                    ->extraInputAttributes(['maxlength' => 100])
                                    ->hidden(fn($get) => ! $get('thumbnail')),

                                TextInput::make('contact')
                                    ->label('Contact URL')
                                    ->url()
                                    ->helperText('Enter the URL for contact (e.g., WhatsApp link)'),

                                // Pindahkan Section SEO ke dalam Section Sidebar ini
                                Section::make('Search Engine Optimization (SEO)')
                                    ->collapsed()
                                    ->schema([
                                        TextInput::make('meta_title')->label('Meta Title')->maxLength(100)->extraInputAttributes(['maxlength' => 100]),
                                        TextInput::make('meta_keywords')->label('Meta Keywords')->maxLength(100)->extraInputAttributes(['maxlength' => 100]),
                                        Textarea::make('meta_description')->label('Meta Description')->maxLength(160)->extraInputAttributes(['maxlength' => 160])->rows(2),
                                    ])->compact(), // Menggunakan compact untuk tampilan yang lebih kecil
                            ])
                            ->collapsible(false)->grow(false),
                    ])->from('md')
                ]),


            // SECTION: Who Needs
            Section::make('Who Needs This Treatment')
                ->description('Specify the target audience and their descriptions (Max 9 items).')
                ->collapsible()
                ->schema([
                    Repeater::make('whoNeeds')
                        ->relationship('whoNeeds')
                        ->label(false)
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    FileUpload::make('thumbnail')
                                        ->image()
                                        ->label('Image')
                                        ->maxSize(500) // max 500 KB
                                        ->directory(fn(Get $get) => Treatment::getUploadDirectory('whoneeds', $get))
                                        ->getUploadedFileNameForStorageUsing(fn($file) => (string) Str::uuid() . '.' . $file->getClientOriginalExtension())
                                        ->visibility('public')
                                        ->imagePreviewHeight('245')
                                        ->imageResizeMode('cover')
                                        ->disk('public')
                                        ->required(),

                                    RichEditor::make('desc')
                                        ->toolbarButtons([
                                            'bulletList',
                                            'orderedList',
                                            'bold',
                                            'italic',
                                            'link',
                                            'underline',
                                            'undo',
                                            'redo',
                                        ])->required(),
                                ]),
                        ])
                        ->orderable('order')
                        ->reorderableWithButtons() // Memudahkan reorder
                        ->createItemButtonLabel('Add Who Needs Item')
                        ->defaultItems(1)
                        ->maxItems(9)
                        ->columns(1)
                ]),

            // SECTION: Treatment Time Frames
            Section::make('Treatment Time Frame Stages')
                ->description('Stages, frames, and detailed steps of the treatment process.')
                ->collapsible()
                ->schema([
                    Repeater::make('timeFrames')
                        ->relationship('timeFrames')
                        ->label(false)
                        ->schema([

                            RichEditor::make('stage')
                                ->label('Stage Title')
                                ->toolbarButtons([
                                    'bold',
                                    'italic',
                                    'h2',
                                    'link',
                                    'underline',
                                    'undo',
                                    'redo',
                                ])
                                ->placeholder('Stage name, e.g., Stage 1 or Initial Phase')
                                ->default(function (Forms\Get $get) {
                                    // Ambil semua stage yang sudah ada
                                    $stages = $get('../../timeFrames') ?? [];

                                    // Hitung hanya item yang sudah punya ID atau data valid (bukan yang baru dibuat di UI)
                                    $filledStages = collect($stages)
                                        ->filter(fn($stage) => filled(data_get($stage, 'stage')))
                                        ->count();

                                    // Stage berikutnya adalah jumlah stage terisi + 1
                                    return 'Stage ' . ($filledStages + 1);
                                })
                                ->afterStateHydrated(function (string $operation, Forms\Set $set, Forms\Get $get, ?string $state) {
                                    // Jika belum ada nilai saat form dibuka, set default berdasarkan jumlah stage yang sudah terisi
                                    if (blank($state)) {
                                        $stages = $get('../../timeFrames') ?? [];
                                        $filledStages = collect($stages)
                                            ->filter(fn($stage) => filled(data_get($stage, 'stage')))
                                            ->count();

                                        $set('stage', 'Stage ' . ($filledStages + 1));
                                    }
                                })
                                ->dehydrated(true)
                                ->required()
                                ->maxLength(130),

                            Grid::make(2)
                                ->schema([
                                    Select::make('frame')
                                        ->label('Frame Type')
                                        ->options(['line' => 'Line', 'arrow' => 'Arrow'])
                                        ->required()
                                        ->default('line'),

                                    Toggle::make('show_stage')
                                        ->label('Show Stage Title')
                                        ->default(true)
                                        ->inline(false)
                                        ->required(),
                                ]),

                            Repeater::make('stageItems')
                                // ... (Kode untuk Stage Items tetap sama) ...
                                ->label('Stage Items')
                                ->relationship('stageItems')
                                ->schema([
                                    TextInput::make('title')->label('Title')->required(),
                                    Grid::make(2)
                                        ->schema([
                                            FileUpload::make('thumbnail')
                                                ->image()
                                                ->label('Image')
                                                ->maxSize(500) // max 500 KB
                                                ->directory(fn(Get $get) => Treatment::getUploadDirectory('timeframe-items', $get))
                                                ->getUploadedFileNameForStorageUsing(fn($file) => (string) Str::uuid() . '.' . $file->getClientOriginalExtension())
                                                ->visibility('public')
                                                ->imagePreviewHeight('245')
                                                ->imageResizeMode('cover')
                                                ->disk('public')
                                                ->required(),

                                            RichEditor::make('desc')
                                                ->toolbarButtons([
                                                    'bulletList',
                                                    'orderedList',
                                                    'bold',
                                                    'italic',
                                                    'link',
                                                    'underline',
                                                    'undo',
                                                    'redo',
                                                ])
                                                ->label('Description')
                                                ->required(),
                                        ]),
                                ])
                                ->orderable('order')
                                ->reorderableWithButtons()
                                ->createItemButtonLabel('Add Stage Item')
                                ->columns(1)
                                ->columnSpanFull(),
                        ])
                        ->orderable('order')
                        ->reorderableWithButtons()
                        ->createItemButtonLabel('Add New Stage')
                        ->defaultItems(1)
                        ->columns(1)
                ]),

            // SECTION: Additional Information
            Section::make('Additional Information (Key Highlights)')
                ->description('Important extra notes (Max 3 items).')
                ->collapsible()
                ->collapsed(
                    fn(string $operation, ?Treatment $record, Forms\Get $get) =>
                    $operation === 'create' || blank($record?->additionals)
                )
                ->schema([
                    Repeater::make('additionals')
                        ->relationship('additionals')
                        ->label(false)
                        ->schema([
                            RichEditor::make('desc')
                                ->label('Description')
                                ->toolbarButtons([
                                    'bulletList',
                                    'orderedList',
                                    'bold',
                                    'italic',
                                    'link',
                                    'underline',
                                    'undo',
                                    'redo',
                                ])
                                ->maxLength(500),
                        ])
                        ->minItems(0)
                        ->maxItems(3)
                        ->orderable('order')
                        ->reorderableWithButtons()
                        ->createItemButtonLabel('Add Info Item')
                        ->columns(1)
                        ->mutateRelationshipDataBeforeCreateUsing(function ($data) {
                            $desc = trim(strip_tags((string) data_get($data, 'desc')));
                            return $desc === '' ? null : $data; // null → tidak disimpan
                        })

                        // 🔍 Filter juga sebelum update (opsional)
                        ->mutateRelationshipDataBeforeSaveUsing(function ($data) {
                            $desc = trim(strip_tags((string) data_get($data, 'desc')));
                            return $desc === '' ? null : $data;
                        })
                        ->dehydrated(fn($state) => filled($state)),
                ]),
        ]);
    }
    // ----------------------------------------------------------------------
    // BAGIAN TABLE DAN RELASI
    // ----------------------------------------------------------------------

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Title')->sortable()->searchable(),
                TextColumn::make('category.title')->label('Category')->sortable(),
                TextColumn::make('slug')->label('Slug')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->label('Updated')->dateTime()->sortable()
                    ->formatStateUsing(
                        fn($state) =>
                        $state
                            ? Carbon::parse($state)
                            ->locale('id')
                            ->translatedFormat('d F Y, H.i')
                            : '-'
                    )->toggleable(),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan di masa mendatang
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('preview')
                        ->label('Preview')
                        ->icon('heroicon-o-eye')
                        ->url(fn(Treatment $record) => route('treatments.show', [
                            'category' => $record->category?->slug,
                            'slug' => $record->slug,
                        ]))
                        ->openUrlInNewTab()
                        ->visible(fn(Treatment $record) => filled($record->slug))
                        ->color('info'),
                    EditAction::make(),
                    DeleteAction::make(),
                ])
                    ->button()
                    ->label('Actions'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTreatments::route('/'),
            'create' => Pages\CreateTreatment::route('/create'),
            'edit' => Pages\EditTreatment::route('/{record}/edit'),
        ];
    }
}
