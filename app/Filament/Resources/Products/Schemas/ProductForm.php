<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms;
use Filament\Schemas\Components\Section;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->columns(1)
            ->components([
                Forms\Components\TextInput::make('name')
                    ->label('Produto'),
                Forms\Components\RichEditor::make('body')
                    ->label('Sobre Produto'),


                Forms\Components\TextInput::make('price')
                    ->label('Preço')
                    ->reactive(),

                Forms\Components\FileUpload::make('photo')
                    ->label('Foto Produto')
                    ->disk('public')

            ]);
    }
}
