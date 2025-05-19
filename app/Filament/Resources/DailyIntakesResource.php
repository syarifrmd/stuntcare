<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DailyIntakesResource\Pages;
use App\Models\DailyIntake;
use App\Models\Children;
use App\Models\Foods;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DailyIntakesResource extends Resource
{
    protected static ?string $model = DailyIntake::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationGroup = 'Pemantauan Gizi';
    protected static ?string $label = 'Intake Harian';
    protected static ?string $pluralLabel = 'Intake Harian Anak';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('child_id')
                    ->label('Anak')
                    ->relationship('child', 'name')
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('food_id')
                    ->label('Makanan')
                    ->relationship('food', 'name')
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('time_of_day')
                    ->label('Waktu Konsumsi')
                    ->options([
                        'Pagi' => 'Pagi',
                        'Siang' => 'Siang',
                        'Malam' => 'Malam',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('portion')
                    ->label('Porsi')
                    ->numeric()
                    ->minValue(0.1)
                    ->step(0.1)
                    ->required(),

                Forms\Components\DatePicker::make('date')
                    ->label('Tanggal')
                    ->default(now())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('child.name')
                    ->label('Anak')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('food.name')
                    ->label('Makanan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('time_of_day')
                    ->label('Waktu')
                    ->sortable(),

                Tables\Columns\TextColumn::make('portion')
                    ->label('Porsi')
                    ->sortable(),

                Tables\Columns\TextColumn::make('date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDailyIntakes::route('/'),
            'create' => Pages\CreateDailyIntakes::route('/create'),
            'edit' => Pages\EditDailyIntakes::route('/{record}/edit'),
        ];
    }
}
