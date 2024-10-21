<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ValidationResource\Pages;
use App\Filament\Resources\ValidationResource\RelationManagers;
use App\Models\Validation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ValidationResource extends Resource
{
    protected static ?string $model = Validation::class;

    protected static ?string $navigationIcon = 'heroicon-s-check-badge';

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
                Tables\Columns\TextColumn::make('user_id'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('id_type'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('verify')
                    ->label('Verify') 
                    ->action(function ($record) {
                        $record->verified = true; 
                        $record->save(); 
                        \Filament\Facades\Filament::notify('success', 'Record verified successfully.');
                    })
                    ->requiresConfirmation() 
                    ->color('success'), 
                    
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
            'index' => Pages\ListValidations::route('/'),
            'create' => Pages\CreateValidation::route('/create'),
            'edit' => Pages\EditValidation::route('/{record}/edit'),
        ];
    }
}
