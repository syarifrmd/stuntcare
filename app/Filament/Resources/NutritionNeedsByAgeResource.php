<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NutritionNeedsByAgeResource\Pages;
use App\Filament\Resources\NutritionNeedsByAgeResource\RelationManagers;
use App\Models\NutritionNeedsByAge;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NutritionNeedsByAgeResource extends Resource
{
    protected static ?string $model = NutritionNeedsByAge::class;

    protected static ?string $navigationIcon = 'heroicon-o-scale';
    protected static ?string $navigationGroup = 'Pemantauan Gizi';
    protected static ?string $label = 'Kebutuhan Gizi';
    protected static ?string $pluralLabel = 'Kebutuhan Gizi per Umur';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('age_range')
                ->label('Rentang Usia')
                ->placeholder('Contoh: 1-3 tahun')
                ->required(),

            Forms\Components\TextInput::make('energy')
                ->label('Energi (kkal)')
                ->numeric()
                ->step(0.01)
                ->required(),

            Forms\Components\TextInput::make('protein')
                ->label('Protein (g)')
                ->numeric()
                ->step(0.01)
                ->required(),

            Forms\Components\TextInput::make('fat')
                ->label('Lemak (g)')
                ->numeric()
                ->step(0.01)
                ->required(),

            Forms\Components\TextInput::make('carbohydrate')
                ->label('Karbohidrat (g)')
                ->numeric()
                ->step(0.01)
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('age_range')->label('Usia')->sortable(),
            Tables\Columns\TextColumn::make('energy')->label('Energi')->sortable(),
            Tables\Columns\TextColumn::make('protein')->label('Protein')->sortable(),
            Tables\Columns\TextColumn::make('fat')->label('Lemak')->sortable(),
            Tables\Columns\TextColumn::make('carbohydrate')->label('Karbo')->sortable(),
        ])
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
            'index' => Pages\ListNutritionNeedsByAges::route('/'),
            'create' => Pages\CreateNutritionNeedsByAge::route('/create'),
            'edit' => Pages\EditNutritionNeedsByAge::route('/{record}/edit'),
        ];
    }
}
