<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StocksResource\Pages;
use App\Filament\Resources\StocksResource\RelationManagers;
use App\Mail\TestMail;
use App\Models\Activities;
use App\Models\Ins;
use App\Models\Outs;
use App\Models\Stocks;
use App\Smark\Smark;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class StocksResource extends Resource
{
    protected static ?string $model = Stocks::class;

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
                Forms\Components\TextInput::make('product_id')->required(),
                Forms\Components\TextInput::make('name')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product_id')->searchable()->color('primary'),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('quantity')->sortable()->color(function ($record) {
                    return $record->quantity <= 10 ? 'danger' : 'primary';
                })->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Out')
                    ->action(function ($record, array $data) {
                        $quantityToRelease = $data['quantity']; // Get the quantity to release from the form

                        if ($record->quantity >= $quantityToRelease) {
                            $record->decrement('quantity', $quantityToRelease);

                            Smark::log(Auth::user()->id, Auth::user()->name, "Released a stock.");

                            Outs::create([
                                'product' => $record->id,
                                'receipt_number' => $data['receipt_number'],
                                'name' => $data['name'],
                                'quantity' => $data['quantity'],
                            ]);

                            Notification::make()
                                ->title('Stock Released')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Insufficient Stock')
                                ->danger()
                                ->send();
                        }
                    })
                    ->color('primary')
                    ->form([
                        Forms\Components\TextInput::make('receipt_number')
                            ->label('Reciept Number')
                            ->required(),
                        Forms\Components\TextInput::make('name')
                            ->label('Name')
                            ->required(),
                        Forms\Components\TextInput::make('quantity')
                            ->label('Quantity to Release')
                            ->required()
                            ->numeric(),
                    ]),
                Tables\Actions\Action::make('In')
                    ->action(function ($record, array $data) {
                        $quantityToAdd = $data['quantity']; // Get the quantity to add from the form

                        $record->increment('quantity', $quantityToAdd);

                        Smark::log(Auth::user()->id, Auth::user()->name, "Added a new stock.");
                        Ins::create([
                            'product' => $record->id,
                            'receipt_number' => $data['receipt_number'],
                            'name' => $data['name'],
                            'quantity' => $data['quantity'],
                        ]);

                        Notification::make()
                            ->title('Stock Added')
                            ->success()
                            ->send();
                    })
                    ->color('success')
                    ->form([
                        Forms\Components\TextInput::make('receipt_number')
                            ->label('Reciept Number')
                            ->required(),
                        Forms\Components\TextInput::make('name')
                            ->label('Name')
                            ->required(),
                        Forms\Components\TextInput::make('quantity')
                            ->label('Quantity to Add')
                            ->required()
                            ->numeric(),
                    ]),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->action(function ($record) {
                        Smark::log(Auth::user()->id, Auth::user()->name, "Deleted a stock. " . $record->name);
                    }),
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
            'index' => Pages\ListStocks::route('/'),
            'create' => Pages\CreateStocks::route('/create'),
            'edit' => Pages\EditStocks::route('/{record}/edit'),
        ];
    }
}
