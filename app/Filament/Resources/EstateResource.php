<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Kind;
use Filament\Tables;
use App\Models\Estate;
use Filament\Forms\Get;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EstateResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EstateResource\RelationManagers;

class EstateResource extends Resource
{
    protected static ?string $model = Estate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Forms\Components\Select::make('kind_id')->label('نوع العقار')
                    ->options( Kind::pluck('name','id'))
                    ->required()
                    ->live(),
                Forms\Components\Select::make('category_id')->label('نوع المبنى')
                    ->options(Category::pluck('name','id'))
                    ->hidden(fn (Get $get): bool =>  $get('kind_id') != 2),
                Forms\Components\Toggle::make('diuretic')->label('هل العقار مدر للدخل'),
                Forms\Components\Select::make('use')->label('الاستخدام')
                    ->hint('(قم بالاختيار او كتابة سبب معين)')
                    ->options( [
                        "سكني","تجاري","اداري","زراعي","صناعي","مستودعات","تعليمي","ترفيهي","صحي","خدمات عامة"
                    ])
                    ->required(),
                Forms\Components\TextInput::make('city_id')
                    ->numeric(),
                Forms\Components\TextInput::make('name_arabic')
                    ->maxLength(191),
                Forms\Components\TextInput::make('name_english')
                    ->maxLength(191),
                Forms\Components\Textarea::make('address')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('about')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('land_size')
                    ->maxLength(191),
                Forms\Components\TextInput::make('build_size')
                    ->maxLength(191),
                Forms\Components\TextInput::make('lat')
                    ->maxLength(191),
                Forms\Components\TextInput::make('lng')
                    ->maxLength(191),
                Forms\Components\TextInput::make('age')
                    ->maxLength(191),
                Forms\Components\TextInput::make('level')
                    ->maxLength(191),
                Forms\Components\TextInput::make('slug')
                    ->maxLength(191),
                Forms\Components\Toggle::make('active'),
                Forms\Components\TextInput::make('reviewer_id')
                    ->maxLength(191),
                Forms\Components\TextInput::make('approver_id')
                    ->maxLength(191),
                Forms\Components\TextInput::make('reviewer')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('approver')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('previewer')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('reviewer_reason')
                    ->maxLength(191),
                Forms\Components\TextInput::make('client_reason')
                    ->maxLength(191),
                Forms\Components\TextInput::make('approver_reason')
                    ->maxLength(191),
                Forms\Components\TextInput::make('previewer_reason')
                    ->maxLength(191),
                Forms\Components\TextInput::make('rater_id')
                    ->maxLength(191),
                Forms\Components\TextInput::make('rater')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('code')
                    ->maxLength(191),
                Forms\Components\TextInput::make('rater_reason')
                    ->maxLength(191),
                Forms\Components\DatePicker::make('perviewer_date'),
                Forms\Components\DatePicker::make('rater_date'),
                Forms\Components\DatePicker::make('reviewer_date'),
                Forms\Components\DatePicker::make('approver_date'),
                Forms\Components\TextInput::make('archive')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('qema')
                    ->maxLength(191),
                Forms\Components\TextInput::make('report_type')
                    ->maxLength(191)
                    ->default('new'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->whereUserId(auth()->id()))
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kind_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('city_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name_arabic')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name_english')
                    ->searchable(),
                Tables\Columns\TextColumn::make('land_size')
                    ->searchable(),
                Tables\Columns\TextColumn::make('build_size')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lng')
                    ->searchable(),
                Tables\Columns\TextColumn::make('age')
                    ->searchable(),
                Tables\Columns\TextColumn::make('level')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('reviewer_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('approver_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('reviewer')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('approver')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('previewer')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reviewer_reason')
                    ->searchable(),
                Tables\Columns\TextColumn::make('client_reason')
                    ->searchable(),
                Tables\Columns\TextColumn::make('approver_reason')
                    ->searchable(),
                Tables\Columns\TextColumn::make('previewer_reason')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rater_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rater')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rater_reason')
                    ->searchable(),
                Tables\Columns\TextColumn::make('perviewer_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rater_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reviewer_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('approver_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('archive')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('qema')
                    ->searchable(),
                Tables\Columns\TextColumn::make('report_type')
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
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListEstates::route('/'),
            'create' => Pages\CreateEstate::route('/create'),
            'edit' => Pages\EditEstate::route('/{record}/edit'),
        ];
    }    
}
