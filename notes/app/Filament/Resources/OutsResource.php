<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OutsResource\Pages;
use App\Filament\Resources\OutsResource\RelationManagers;
use App\Models\Outs;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OutsResource extends Resource
{
    protected static ?string $model = Outs::class;

    protected static ?string $navigationLabel = 'Purchased/Released (Outs)';
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
                Tables\Columns\TextColumn::make('quantity')->searchable()->color('danger'),
                Tables\Columns\TextColumn::make('created_at')->since()->sortable()->label('Released'),
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
            'index' => Pages\ListOuts::route('/'),
            'create' => Pages\CreateOuts::route('/create'),
            'edit' => Pages\EditOuts::route('/{record}/edit'),
        ];
    }
}
