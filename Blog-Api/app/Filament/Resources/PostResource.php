<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (Auth::user()->hasRole('admin')) {
            return $query; 
        }

        return $query->where('user_id', Auth::id()); 
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_name') 
                    ->label('Kategori')
                    ->options(Category::pluck('name', 'name')) 
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('text')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Hidden::make('user_id') 
                    ->default(fn () => Auth::id()), 

                DatePicker::make('start')
                    ->native(false),

                DatePicker::make('stop')
                    ->native(false),

                FileUpload::make('image') 
                    ->label('Görsel Yükle')
                    ->image()  
                    ->directory('posts') 
                    ->required()
                    ->preserveFilenames(),

                Forms\Components\TextInput::make('tags')
                ->label('Etiketler (Virgülle ayrılmış)')
                ->helperText('Etiketleri virgülle ayırarak girin. Örneğin: "Technology, Health, Business"')
                ->required(),
            
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category_name') 
                    ->label('Kategori')
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('text')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name') 
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('start')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('stop')
                    ->dateTime()
                    ->sortable(),
                    Tables\Columns\TextColumn::make('tags')
                    ->searchable(),
                    
                
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
