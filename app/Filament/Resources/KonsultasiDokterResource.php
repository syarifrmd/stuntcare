<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KonsultasiDokterResource\Pages;
use App\Models\KonsultasiDokter;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

// ✅ Import komponen Forms
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Forms\Set;

// ✅ Import komponen Tables
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class KonsultasiDokterResource extends Resource
{
    protected static ?string $model = KonsultasiDokter::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';
    protected static ?string $navigationLabel = 'Konsultasi Dokter';
    protected static ?string $pluralLabel = 'Konsultasi Dokter';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    TextInput::make('nama_pasien')
                        ->label('Nama Pasien')
                        ->required(),

                    Select::make('nama_dokter')
                        ->label('Pilih Dokter')
                        ->options(fn () => User::where('role', 'dokter')->pluck('name', 'name'))
                        ->searchable()
                        ->required()
                        ->live()
                        ->afterStateUpdated(function (string $state, Set $set) {
                            $dokter = User::where('name', $state)->first();
                            if ($dokter) {
                                $set('no_wa_dokter', $dokter->phone);
                                $set('whatsapp_log', 'https://wa.me/' . ltrim($dokter->phone, '0'));
                            }
                        }),

                    TextInput::make('no_wa_dokter')
                        ->label('Nomor WhatsApp Dokter')
                        ->required()
                        ->disabled(),

                    TextInput::make('whatsapp_log')
                        ->label('Link WhatsApp')
                        ->url()
                        ->nullable()
                        ->disabled(),

                    DateTimePicker::make('waktu_konsultasi')
                        ->label('Waktu Konsultasi')
                        ->default(now())
                        ->required(),

                    Select::make('status')
                        ->label('Status')
                        ->required()
                        ->options([
                            'terbuka' => 'Terbuka',
                            '
                            selesai' => 'Selesai',
                            'ditutup' => 'Ditutup',
                        ])
                        ->default('terbuka'),

                    Textarea::make('catatan_user')
                        ->label('Catatan User')
                        ->rows(3)
                        ->nullable(),

                    Textarea::make('catatan_dokter')
                        ->label('Catatan Dokter')
                        ->rows(3)
                        ->nullable(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_pasien')->searchable()->sortable(),
                TextColumn::make('nama_dokter')->sortable(),
                TextColumn::make('no_wa_dokter')->label('WA Dokter')->limit(20),
                TextColumn::make('status')->badge(),
                TextColumn::make('waktu_konsultasi')->label('Waktu')->dateTime('d M Y H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
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
            'index' => Pages\ListKonsultasiDokters::route('/'),
            'create' => Pages\CreateKonsultasiDokter::route('/create'),
            'edit' => Pages\EditKonsultasiDokter::route('/{record}/edit'),
        ];
    }
}
