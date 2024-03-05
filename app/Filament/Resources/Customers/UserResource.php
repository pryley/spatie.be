<?php

namespace App\Filament\Resources\Customers;

use App\Filament\Tables\Columns\BooleanColumn;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Customers';

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('uuid')
                    ->label('UUID')
                    ->maxLength(36),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(60),
                Forms\Components\TextInput::make('github_id')
                    ->numeric(),
                Forms\Components\TextInput::make('github_username')
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_sponsor'),
                Forms\Components\TextInput::make('avatar')
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_admin')
                    ->required(),
                Forms\Components\DateTimePicker::make('next_purchase_discount_period_ends_at'),
                Forms\Components\DateTimePicker::make('sponsor_gift_given_at'),
                Forms\Components\Toggle::make('has_access_to_unreleased_products')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->default(fn (User $record) => gravatar_url($record->email)),

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('github_username')
                    ->searchable(),

                BooleanColumn::make('is_sponsor')->default(false),
                BooleanColumn::make('is_admin'),
                BooleanColumn::make('has_access_to_unreleased_products'),

                Tables\Columns\TextColumn::make('created_at')
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
            'index' => \App\Filament\Resources\Customers\UserResource\Pages\ListUsers::route('/'),
            'create' => \App\Filament\Resources\Customers\UserResource\Pages\CreateUser::route('/create'),
            'edit' => \App\Filament\Resources\Customers\UserResource\Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
