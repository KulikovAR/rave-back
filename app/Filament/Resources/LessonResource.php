<?php

namespace App\Filament\Resources;

use App\Models\Tag;
use Filament\Forms;
use Filament\Tables;
use App\Models\Lesson;
use App\Filament\MenuTitles;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\LessonResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LessonResource\RelationManagers;
use App\Filament\Resources\LessonResource\RelationManagers\QuizRelationManager;
use App\Filament\Resources\LessonResource\RelationManagers\CommentsRelationManager;
use App\Filament\Resources\LessonResource\RelationManagers\LessonAdditionalDataRelationManager;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = MenuTitles::CATEGORY_APP;

    protected static ?string $pluralModelLabel = 'Уроки';

    protected static ?string $modelLabel = 'Урок';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->maxLength(255)
                     ->translateLabel()
                     ->required()
                     ->label('Заголовок'),
                Textarea::make('description')
                     ->required()
                     ->label('Опиание'),
                FileUpload::make('preview_path')
                    ->tooltip('Загрузите обложку (изображение)')
                    ->enableDownload()
                    ->enableOpen()
                    ->columnSpanFull()
                    ->maxSize(100000)
                    ->required()
                    ->label('Превью'),
                Select::make('tags')
                    ->multiple()
                    ->relationship('tags', 'name')
                    ->searchable()
                    ->label('Тэги'),
                TextInput::make('rating')
                    ->integer()
                    ->minValue(1)
                    ->maxValue(5)
                    ->maxLength(255)
                    ->label('Рейтинг'),
                TextInput::make('duration')
                    ->integer()
                    ->required()
                    ->label('Длительность'),
                DateTimePicker::make('announc_date')
                    ->required()
                    ->label('Дата анонса'),
                TextInput::make('order_in_display')
                    ->integer()
                    ->required()
                    ->label('Порядок показа'),
                ViewField::make('video_path')
                    ->tooltip("1.Выберите видео файл. 2. Нажмите на кнопку «Загрузить». 3. Дождитесь загрузки")
                    ->view('livewire.chunkuploader')
                    ->required()
                    ->label('Видеоролик'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->tooltip(fn($record) => $record->title)
                    ->limit(15),
                // TextColumn::make('description'),
                TextColumn::make('video_path')
                    ->tooltip(fn($record) => $record->video_path)
                    ->limit(15),
                TextColumn::make('order_in_display')
                    ->sortable(),
                ImageColumn::make('preview_path')
                    ->label('Обложка'),
                TextColumn::make('rating')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                                                     Tables\Actions\EditAction::make(),
                                                     Tables\Actions\DeleteAction::make(),
                                                 ])
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }


    public static function getRelations(): array
    {
        return [
            CommentsRelationManager::class,
            LessonAdditionalDataRelationManager::class,
            QuizRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLessons::route('/'),
            'create' => Pages\CreateLesson::route('/create'),
            'edit' => Pages\EditLesson::route('/{record}/edit'),
        ];
    }
}
