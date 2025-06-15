<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Food;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\FoodsResource\Pages;

class FoodsResource extends Resource
{
    protected static ?string $model = Food::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Pusat Data';
    protected static ?string $label = 'Makanan';
    protected static ?string $pluralLabel = 'Daftar Makanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Makanan')
                    ->required()
                    ->maxLength(100),

                
                FileUpload::make('foto')
                    ->label('Foto Makanan')
                    ->image()
                    ->directory('makanan')
                    ->imagePreviewHeight('150')
                    ->columnSpanFull(),    

                Forms\Components\Select::make('category')
                    ->label('Kategori')
                    ->options([
                        'Makanan Pokok' => 'Makanan Pokok',
                        'Sayuran' => 'Sayuran',
                        'Lauk Pauk' => 'Lauk Pauk',
                        'Buah' => 'Buah',
                    ])
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

                Forms\Components\Hidden::make('created_by')
                    ->default(fn () => Auth::id()), // Set otomatis user login
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
