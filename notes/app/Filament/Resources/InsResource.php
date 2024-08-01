<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InsResource\Pages;
use App\Filament\Resources\InsResource\RelationManagers;
use App\Models\Ins;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InsResource extends Resource
{
    protected static ?string $model = Ins::class;

    protected static ?string $navigationLabel = 'Delivered/Arrived (Ins)';
    protected static ?string $navigationGroup = 'Stock Management';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('products.product_id')->label('Product ID')->searchable()->color('primary'),
                Tables\Columns\TextColumn::make('products.name')->label('Product Name')->searchable(),
                Tables\Columns\TextColumn::make('receipt_number')->searchable(),
                Tables\Columns\TextColumn::make('name')->searchable()->label('Supplier Name'),
                Tables\Columns\TextColumn::make('quantity')->searchable()->color('success'),
                Tables\Columns\TextColumn::make('created_at')->since()->sortable()->label('Arrived'),
                Tables\Columns\TextColumn::make('updated_at')->date()->label('Date')
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListIns::route('/'),
            'create' => Pages\CreateIns::route('/create'),
            'edit' => Pages\EditIns::route('/{record}/edit'),
        ];
    }
}
