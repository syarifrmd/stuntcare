<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DailyNutritionSummariesResource\Pages;
use App\Filament\Resources\DailyNutritionSummariesResource\RelationManagers;
use App\Models\DailyNutritionSummaries;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DailyNutritionSummariesResource extends Resource
{
     protected static ?string $model = DailyNutritionSummaries::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Pemantauan Gizi';
    protected static ?string $label = 'Rekap Gizi Harian';
    protected static ?string $pluralLabel = 'Statistik Gizi Anak';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('child_id')
                    ->label('Anak')
                    ->relationship('child', 'name')
                    ->required(),

                Forms\Components\DatePicker::make('date')->required(),

                Forms\Components\TextInput::make('energy_total')->numeric()->label('Energi (kkal)'),
                Forms\Components\TextInput::make('protein_total')->numeric()->label('Protein (g)'),
                Forms\Components\TextInput::make('fat_total')->numeric()->label('Lemak (g)'),
                Forms\Components\TextInput::make('carb_total')->numeric()->label('Karbo (g)'),

                Forms\Components\TextInput::make('energy_percent')->numeric()->label('Capaian Energi (%)'),
                Forms\Components\TextInput::make('protein_percent')->numeric()->label('Capaian Protein (%)'),
                Forms\Components\TextInput::make('fat_percent')->numeric()->label('Capaian Lemak (%)'),
                Forms\Components\TextInput::make('carb_percent')->numeric()->label('Capaian Karbo (%)'),

                Forms\Components\Select::make('energy_status')->options(['Terpenuhi' => 'Terpenuhi', 'Belum Terpenuhi' => 'Belum Terpenuhi']),
                Forms\Components\Select::make('protein_status')->options(['Terpenuhi' => 'Terpenuhi', 'Belum Terpenuhi' => 'Belum Terpenuhi']),
                Forms\Components\Select::make('fat_status')->options(['Terpenuhi' => 'Terpenuhi', 'Belum Terpenuhi' => 'Belum Terpenuhi']),
                Forms\Components\Select::make('carb_status')->options(['Terpenuhi' => 'Terpenuhi', 'Belum Terpenuhi' => 'Belum Terpenuhi']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('child.name')->label('Anak')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('date')->date()->label('Tanggal')->sortable(),

                Tables\Columns\TextColumn::make('energy_percent')->label('Energi (%)')->sortable(),
                Tables\Columns\TextColumn::make('protein_percent')->label('Protein (%)')->sortable(),
                Tables\Columns\TextColumn::make('fat_percent')->label('Lemak (%)')->sortable(),
                Tables\Columns\TextColumn::make('carb_percent')->label('Karbo (%)')->sortable(),

                Tables\Columns\BadgeColumn::make('energy_status')->colors(['success' => 'Terpenuhi', 'danger' => 'Belum Terpenuhi']),
                Tables\Columns\BadgeColumn::make('protein_status')->colors(['success' => 'Terpenuhi', 'danger' => 'Belum Terpenuhi']),
                Tables\Columns\BadgeColumn::make('fat_status')->colors(['success' => 'Terpenuhi', 'danger' => 'Belum Terpenuhi']),
                Tables\Columns\BadgeColumn::make('carb_status')->colors(['success' => 'Terpenuhi', 'danger' => 'Belum Terpenuhi']),
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
            'index' => Pages\ListDailyNutritionSummaries::route('/'),
            'create' => Pages\CreateDailyNutritionSummaries::route('/create'),
            'edit' => Pages\EditDailyNutritionSummaries::route('/{record}/edit'),
        ];
    }
}
