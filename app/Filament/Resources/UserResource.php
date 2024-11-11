<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-s-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('email')->email()->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(User::query()->where('user_type', '!=', 'admin')) //exclude the admin account
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('User ID'), // Display user ID
                Tables\Columns\TextColumn::make('name')
                    ->label('Name') // Display full name
                    ->getStateUsing(fn($record) => $record->first_name . ' ' . $record->last_name)
                    ->searchable(['first_name', 'last_name']),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable(),
                Tables\Columns\TextColumn::make('user_type')->label('')
                    ->getStateUsing(fn($record) => ucfirst($record->user_type)),
                Tables\Columns\TextColumn::make('created_at')->label('Date Created')->date(),
                Tables\Columns\TextColumn::make('isVerified')
                    ->label('Verification')
                    ->getStateUsing(fn($record) => $record->isVerified ? 'Verified' : 'Not Verified')
                    ->color(fn($record) => $record->isVerified ? 'success' : 'danger')
                    ->extraAttributes(fn($record) => [
                        'class' => $record->isVerified
                            ? 'inline-block px-3 py-1 text-white rounded-full font-regular'
                            : 'inline-block px-3 py-1 text-white rounded-full font-regular',
                    ]),
            ])
            ->filters([
                SelectFilter::make('user_type')
                    ->label('User Type') // Label for the filter
                    ->options([
                        'freelancer' => 'Freelancer',
                        'client' => 'Client',
                    ])
                    ->default(null), // Default to show all types
            ])
            ->searchPlaceholder('Search (Name, Email)')
            ->actions([
                //
            ])
            ->bulkActions([
                //
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
