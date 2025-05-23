<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KvkkResource\Pages;
use App\Filament\Resources\KvkkResource\RelationManagers;
use App\Models\Kvkk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KvkkResource extends Resource
{
    protected static ?string $model = Kvkk::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Textarea::make('kvkk')
                ->required()  
                ->label('KVKK Metni')  
                ->placeholder('KVKK metnini buraya yazın...')  
                ->columnSpanFull(),  
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kvkk')
                ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
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
            'index' => Pages\ListKvkks::route('/'),
            'create' => Pages\CreateKvkk::route('/create'),
            'edit' => Pages\EditKvkk::route('/{record}/edit'),
        ];
    }
}
