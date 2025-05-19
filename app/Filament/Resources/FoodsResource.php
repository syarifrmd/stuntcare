<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Foods;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\FoodsResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FoodsResource\RelationManagers;

class FoodsResource extends Resource
{
    protected static ?string $model = Food::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Makanan Bang';
    protected static ?string $label = 'Makanan';
    protected static ?string $pluralLabel = 'Daftar Makanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Heading')
                    ->description('')
                    ->schema([
                        TextInput::make('name')->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('category')->label('Kategori')->sortable(),
                Tables\Columns\TextColumn::make('energy')->label('Energi')->sortable(),
                Tables\Columns\TextColumn::make('protein')->label('Protein')->sortable(),
                Tables\Columns\TextColumn::make('fat')->label('Lemak')->sortable(),
                Tables\Columns\TextColumn::make('carbohydrate')->label('Karbohidrat')->sortable(),
                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Dibuat Oleh')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
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
            'index' => Pages\ListFoods::route('/'),
            'create' => Pages\CreateFoods::route('/create'),
            'edit' => Pages\EditFoods::route('/{record}/edit'),
        ];
    }
}
