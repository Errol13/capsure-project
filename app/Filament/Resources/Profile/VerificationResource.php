<?php

namespace App\Filament\Resources\Profile;

use App\Filament\Resources\Profile\VerificationResource\Pages;
use App\Filament\Resources\Profile\VerificationResource\RelationManagers;
use App\Models\Profile\Verification;
use App\Models\User;
use App\Notifications\VerificationStatus;
use Filament\Actions\StaticAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;

class VerificationResource extends Resource
{
    protected static ?string $model = Verification::class;

    protected static ?string $navigationIcon = 'heroicon-s-check-badge';


    public static function canCreate(): bool
    {
       return false;
    }
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('id_type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('id_card_image')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('pic_with_id')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                Verification::query()->whereHas('user', function ($query) {
                    $query->where('isVerified', false);
                })
            )
            ->columns([
                TextColumn::make('user_id')
                    ->label('User ID')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('userFullNameAndEmail')
                    ->label('User')
                    ->getStateUsing(fn($record) => $record->user->first_name . ' ' . $record->user->last_name)
                    ->description(fn($record): string => $record->user->email)
                    ->searchable(['user.first_name', 'user.last_name']),
                TextColumn::make('id_type')
                    ->label('ID Type')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('viewDetails')
                    ->label('View')
                    ->modalHeading('Verification Details')
                    ->modalDescription('Detailed view of the verification request.')
                    ->modalContent(fn($record) => view('components.verification-modal', ['record' => $record]))
                    ->modalCancelAction(fn(StaticAction $action) => $action->label('Close')->extraAttributes(['class' => 'ml-auto']))
                    ->color('info')
                    ->modalSubmitAction(false)
                    ->modalWidth('lg')
                    ->requiresConfirmation(false),
                Action::make('verify')
                    ->label('Verify')
                    ->color('success')
                    ->action(fn(Verification $record) => static::verifyRequest($record))
                    ->requiresConfirmation()
                    ->visible(fn(Verification $record) => !$record->user->isVerified),
                Action::make('resendVerification')
                    ->label('Resend Verification Notice')
                    ->color('warning')
                    ->action(fn(Verification $record) => static::resendVerificationNotice($record))
                    ->requiresConfirmation()
                    ->visible(fn(Verification $record) => !$record->user->isVerified),
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
            'index' => Pages\ListVerifications::route('/'),
           // 'create' => Pages\CreateVerification::route('/create'),
          //  'edit' => Pages\EditVerification::route('/{record}/edit'),
            //'view-id' => Pages\ViewID::route('/{record}/view'),
        ];
    }
    public function getActions(): array
    {
        return [
            Action::make('verify')
                ->label('Verify')
                ->action('verifyRequest')
                ->requiresConfirmation()
                ->color('success'),

            Action::make('resendVerification')
                ->label('Resend Verification Notice')
                ->action('resendVerificationNotice')
                ->requiresConfirmation()
                ->color('primary'),
        ];
    }

    public static function verifyRequest(Verification $record)
    {
        $user = $record->user;
        $user->update(['isVerified' => true]);

        // Notify the user about successful verification
        $user->notify(new VerificationStatus('Your account has been successfully verified.'));

        Log::info('HAS BEEN VERIFIED!');
    }

    public static function resendVerificationNotice(Verification $record)
    {
        $user = $record->user;

        // Reset verification status and delete the request
        $user->update(['isVerified' => false]);
        $record->delete();

        // Notify the user about the need to resubmit verification
        $user->notify(new VerificationStatus('Your verification request was denied. Please retry with clear and legitimate information.'));
    }

    
}
