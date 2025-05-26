<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KonsultasiDokterResource\Pages;
use App\Models\KonsultasiDokter;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

// Forms
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Forms\Set;

// Tables
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
        return $form->schema([
            Card::make([
                TextInput::make('nama_dokter')
                    ->label('Nama Dokter')
                    ->required(),

                TextInput::make('no_wa_dokter')
                    ->label('Nomor WhatsApp Dokter')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (?string $state, Set $set) {
                        if ($state) {
                            $set('whatsapp_log', 'https://wa.me/' . preg_replace('/^0/', '62', $state));
                        } else {
                            $set('whatsapp_log', null);
                        }
                    }),

                TextInput::make('whatsapp_log')
                    ->label('Link WhatsApp')
                    ->disabled()
                    ->dehydrated(false)
                    ->placeholder('Akan diisi otomatis dari nomor WA'),

                DateTimePicker::make('waktu_konsultasi')
                    ->label('Waktu Konsultasi')
                    ->default(now())
                    ->required(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'terbuka' => 'Terbuka',
                        'selesai' => 'Selesai',
                        'ditutup' => 'Ditutup',
                    ])
                    ->default('terbuka')
                    ->required(),

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
                TextColumn::make('nama_dokter')->label('Nama Dokter')->sortable()->searchable(),
                TextColumn::make('no_wa_dokter')->label('No. WA Dokter')->limit(20),
                TextColumn::make('status')->badge(),
                TextColumn::make('waktu_konsultasi')->label('Waktu')->dateTime('d M Y H:i'),
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