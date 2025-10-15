<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Doctor;
use Nette\Utils\Image;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use App\Filament\Resources\DoctorResource\Pages;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Forms\Components\{Repeater, FileUpload, TextInput, Textarea, RichEditor, Select};
use Filament\Tables\Actions\{Action, ActionGroup, EditAction, DeleteAction, BulkActionGroup, DeleteBulkAction};

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Doctor';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1) // 1 kolom → semua field full width
                    ->schema([
                        Split::make([
                            Card::make('Doctor Info')->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('name')
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
                                            ->placeholder('Auto-generated from name')
                                            ->reactive()
                                            ->suffixAction(
                                                FormAction::make('generateSlug')
                                                    ->label('Generate')
                                                    ->icon('heroicon-o-arrow-path') // ganti icon kalau mau
                                                    ->action(function (Get $get, Set $set) {
                                                        $name = $get('name') ?? '';
                                                        $set('slug', Str::slug($name));
                                                    })
                                            )
                                            // jika user mengedit slug manual, kita normalisasi isian jadi slug-safe
                                            ->afterStateUpdated(function ($state, Set $set) {
                                                if (! blank($state)) {
                                                    $set('slug', Str::slug($state));
                                                }
                                            }),
                                    ]),
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('position')->maxLength(255),
                                        TextInput::make('language')->maxLength(255)->placeholder('e.g. English, Bahasa Indonesia'),
                                    ]),

                                RichEditor::make('short_desc')
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

                            Card::make('Sidebar')
                                ->description('Media and SEO settings.')
                                ->schema([
                                    // Doctor Avatar
                                    FileUpload::make('avatar')
                                        ->label('Doctor Avatar')
                                        ->image()
                                        ->directory(fn(Get $get) => 'doctors/' . ($get('slug') ?: Str::slug($get('name') ?? 'doctor')))
                                        ->disk('public')
                                        ->visibility('public')
                                        ->multiple(false)
                                        ->getUploadedFileNameForStorageUsing(
                                            fn($file, Get $get) =>
                                            'avatar.' . $file->getClientOriginalExtension()
                                        )
                                        ->imageCropAspectRatio('1:1')
                                        ->imagePreviewHeight('250')
                                        ->panelAspectRatio('1:1')
                                        ->formatStateUsing(fn($state) => $state ? [$state] : []) // preview saat edit
                                        ->dehydrateStateUsing(fn($state) => is_array($state) && array_is_list($state) ? array_shift($state) : $state)
                                        ->afterStateUpdated(function ($state, Get $get) {
                                            if (!$state) return;
                                            $slug = $get('slug') ?: Str::slug($get('name') ?? 'doctor');
                                            $path = storage_path("app/public/doctors/{$slug}/" . basename($state));
                                            if (file_exists($path)) {
                                                $image = Image::make($path);
                                                $size = min($image->width(), $image->height());
                                                $image->crop($size, $size)->save($path);
                                            }
                                        })
                                        ->required(),

                                    // Profile Thumbnail
                                    FileUpload::make('thumbnail_profile')
                                        ->label('Profile Detail')
                                        ->image()
                                        ->maxSize(500)
                                        ->directory(fn(Get $get) => 'doctors/' . ($get('slug') ?: Str::slug($get('name') ?? 'doctors-temp')))
                                        ->disk('public')
                                        ->visibility('public')
                                        ->multiple(false)
                                        ->getUploadedFileNameForStorageUsing(fn($file, $get) => 'thumbnail_profile.' . $file->getClientOriginalExtension())
                                        ->formatStateUsing(fn($state) => $state ? [$state] : []) // preview saat edit
                                        ->dehydrateStateUsing(fn($state) => is_array($state) && array_is_list($state) ? array_shift($state) : $state)
                                        ->required(),

                                    // Thumbnail alt text
                                    TextInput::make('thumbnail_alt_text')
                                        ->label('Thumbnail Alt Text')
                                        ->placeholder('Enter alt text for the thumbnail')
                                        ->columnSpanFull()
                                        ->reactive()
                                        ->hidden(fn($get) => ! $get('thumbnail_profile')),


                                    // Pindahkan Section SEO ke dalam Section Sidebar ini
                                    Section::make('Search Engine Optimization (SEO)')
                                        ->collapsed()
                                        ->schema([
                                            TextInput::make('meta_title')->label('Meta Title')->maxLength(255),
                                            TextInput::make('meta_keywords')->label('Meta Keywords')->maxLength(255),
                                            Textarea::make('meta_description')->label('Meta Description')->maxLength(160)->rows(2),
                                        ])->compact(), // Menggunakan compact untuk tampilan yang lebih kecil
                                ])
                                ->collapsible(false)->grow(false),
                        ])->from('md')
                    ]),

                Card::make('Doctor Education')
                    ->description('Add one or more educational backgrounds of the doctor, including the university name and graduation year.')
                    ->collapsible()
                    ->collapsed(
                        fn(string $operation, ?Doctor $record, Forms\Get $get) =>
                        $operation === 'create' || blank($record?->educations())
                    )
                    ->schema([
                        Repeater::make('educations')
                            ->relationship('educations') // relasi ke model DoctorEducation
                            ->label('Doctor Education')
                            ->schema([
                                TextInput::make('education_title')
                                    ->label('Education Title')
                                    ->placeholder('e.g. Dentistry Faculty in Mahasaraswati University, Bali')
                                    ->maxLength(255),

                                TextInput::make('graduation_year')
                                    ->label('Graduation Year')
                                    ->numeric()
                                    ->minValue(1900)
                                    ->maxValue(date('Y'))
                                    ->nullable(),
                            ])
                            ->columns(2)
                            ->collapsible()
                            ->orderable('order')
                            ->addActionLabel('Add Education')
                            ->defaultItems(0)
                            ->dehydrated(true) // tetap kirim data kalau ada
                            ->saveRelationshipsUsing(function ($component, $state, $record) {
                                // Bersihkan data kosong
                                $filtered = collect($state)
                                    ->filter(
                                        fn($item) =>
                                        !empty($item['education_title']) || !empty($item['graduation_year'])
                                    )
                                    ->values(); // reset index

                                // Hapus relasi lama
                                $record->educations()->delete();

                                // Insert baru dengan auto-set order
                                $filtered->each(function ($item, $index) use ($record) {
                                    $item['order'] = $index + 1; // urutan dimulai dari 1
                                    $record->educations()->create($item);
                                });
                            })
                    ]),

                Card::make('Doctor Certification')
                    ->description('Add one or more certifications or professional courses the doctor has completed, including the course title and the year it was obtained.')
                    ->collapsible()
                    ->collapsed(
                        fn(string $operation, ?Doctor $record, Forms\Get $get) =>
                        $operation === 'create' || blank($record?->certifications())
                    )
                    ->schema([
                        Repeater::make('certifications')
                            ->relationship('certifications') // relasi ke model DoctorEducation
                            ->label('Doctor Certifications')
                            ->schema([
                                TextInput::make('certification_title')
                                    ->label('Certifications Title')
                                    ->placeholder('e.g. Megagen Implant Short Course in Korea')
                                    ->maxLength(255),
                                TextInput::make('certification_year')
                                    ->label('Certifications Year')
                                    ->numeric()
                                    ->minValue(1900)
                                    ->maxValue(date('Y'))
                                    ->nullable(),
                            ])
                            ->columns(2)
                            ->collapsible()
                            ->orderable('order')
                            ->addActionLabel('Add Certification')
                            ->defaultItems(0)
                            ->dehydrated(true) // tetap kirim data kalau ada
                            ->saveRelationshipsUsing(function ($component, $state, $record) {
                                $filtered = collect($state)
                                    ->filter(
                                        fn($item) =>
                                        !empty($item['certification_title']) || !empty($item['certification_year'])
                                    )
                                    ->values();

                                $record->certifications()->delete();

                                $filtered->each(function ($item, $index) use ($record) {
                                    $item['order'] = $index + 1;
                                    $record->certifications()->create($item);
                                });
                            })
                    ]),
                Card::make('Doctor Association')
                    ->description('Add one or more professional associations or organizations the doctor is affiliated with.')
                    ->collapsible()
                    ->collapsed(
                        fn(string $operation, ?Doctor $record, Forms\Get $get) =>
                        $operation === 'create' || blank($record?->associations())
                    )
                    ->schema([
                        Repeater::make('associations')
                            ->relationship('associations')
                            ->label('Doctor Associations')
                            ->schema([
                                Toggle::make('show_name')
                                    ->label('Show Name on Profile')
                                    ->default(true),
                                Grid::make(2)->schema([
                                    RichEditor::make('association_name')
                                        ->toolbarButtons(['bold', 'italic', 'link', 'underline', 'undo', 'redo'])
                                        ->required(),
                                    FileUpload::make('img')
                                        ->label('Association Image')
                                        ->image()
                                        ->directory('doctors/association')
                                        ->disk('public')
                                        ->visibility('public')
                                        ->getUploadedFileNameForStorageUsing(function ($file, $get) {
                                            $slug = Str::slug($get('../../slug') ?? 'doctor');
                                            $assocName = Str::slug($get('association_name') ?? 'association');
                                            // $order = $get('order') ?? 0;
                                            $uuidShort = substr((string) Str::uuid(), 0, 4);
                                            return "{$slug}_{$uuidShort}_{$assocName}." . $file->getClientOriginalExtension();
                                        })
                                        ->multiple(false)
                                        ->nullable()
                                ]),
                            ])
                            ->orderable('order')
                            ->collapsible()
                            ->columns(2)
                            ->addActionLabel('Add Association')
                            ->defaultItems(0)
                            ->mutateRelationshipDataBeforeSaveUsing(function (array $data): ?array {
                                // 🔒 Cegah menyimpan data kosong
                                if (empty($data['association_name']) && empty($data['img'])) {
                                    return null;
                                }
                                return $data;
                            }),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->label('Thumbnail')
                    ->circular() // tampilkan sebagai lingkaran
                    ->height(40) // ukuran gambar
                    ->width(40)
                    ->disk('public'), // sesuaikan dengan direktori upload
                TextColumn::make('name')->label('Name')->sortable()->searchable(),
                TextColumn::make('position')->label('Position')->sortable(),
                TextColumn::make('slug')->label('Slug')->toggleable(isToggledHiddenByDefault: true)
            ])
            ->filters([
                // Tambahkan filter jika diperlukan di masa mendatang
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('preview')
                        ->label('Preview')
                        ->icon('heroicon-o-eye')
                        ->url(fn(Doctor $record) => route('doctor.show', [
                            'slug' => $record->slug,
                        ]))
                        ->openUrlInNewTab()
                        ->visible(fn(Doctor $record) => filled($record->slug))
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'edit' => Pages\EditDoctor::route('/{record}/edit'),
        ];
    }
}
