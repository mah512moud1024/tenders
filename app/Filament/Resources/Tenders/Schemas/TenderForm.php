<?php

namespace App\Filament\Resources\Tenders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use App\Models\Tender;

class TenderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label(__('Title'))
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->label(__('Description'))
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('user_id')
                    ->label(__('Client'))
                    ->relationship('user', 'first_name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('city_id')
                    ->label(__('City'))
                    ->relationship('city', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('area')
                    ->label(__('Area'))
                    ->default(null)
                    ->maxLength(255),
                Select::make('project_type')
                    ->label(__('Project Type'))
                    ->options([
                        'building' => __('Building'),
                        'roads' => __('Roads'),
                    ])
                    ->required(),
                Select::make('work_type')
                    ->label(__('Work Type'))
                    ->options([
                        'maintenance' => __('Maintenance'),
                        'new_construction' => __('New construction'),
                        'completion' => __('Completion'),
                    ])
                    ->required(),
                Select::make('tender_type')
                    ->label(__('Tender Type'))
                    ->options([
                        'design' => __('Design'),
                        'construction' => __('Construction'),
                        'supply' => __('Supply'),
                    ])
                    ->required(),
                Select::make('category_id')
                    ->label(__('Category'))
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('floors')
                    ->label(__('Floors'))
                    ->numeric()
                    ->default(null),
                TextInput::make('building_area')
                    ->label(__('Building Area'))
                    ->numeric()
                    ->default(null)
                    ->suffix('m²'),
                TextInput::make('land_area')
                    ->label(__('Land Area'))
                    ->numeric()
                    ->default(null)
                    ->suffix('m²'),
                TextInput::make('required_service')
                    ->label(__('Required Service'))
                    ->default(null)
                    ->maxLength(255),
                Select::make('status')
                    ->label(__('Status'))
                    ->options([
                        'draft' => __('Draft'),
                        'pending' => __('Pending'),
                        'published' => __('Published'),
                        'assigned' => __('Assigned'),
                        'completed' => __('Completed'),
                    ])
                    ->default('draft')
                    ->required(),
                DateTimePicker::make('closing_date')
                    ->label(__('Closing Date')),
                FileUpload::make('attachments')
                    ->label(__('Attachments'))
                    ->multiple()
                    ->disk('s3')
                    ->directory('tender-specifications')
                    ->visibility('private')
                    ->acceptedFileTypes([
                        '.pdf', '.doc', '.docx', '.xls', '.xlsx', '.dwg', '.dwf', '.dxf',
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'image/vnd.dwg',
                        'image/x-dwg',
                        'image/vnd.dxf',
                        'image/x-dxf',
                        'drawing/x-dwf',
                        'model/vnd.dwf',
                        'application/acad',
                        'application/dxf',
                        'application/x-dwg',
                        'application/x-dxf',
                    ])
                    ->rules(['file', 'extensions:pdf,doc,docx,xls,xlsx,dwg,dwf,dxf'])
                    ->maxSize(2097152) // 2GB
                    ->loadStateFromRelationshipsUsing(function (Tender $record) {
                        return $record->specifications->pluck('file_path')->toArray();
                    })
                    ->saveRelationshipsUsing(function (Tender $record, $state) {
                        $currentPaths = is_array($state) ? $state : [];
                        
                        // Delete specifications that are no longer in the state
                        $record->specifications()->whereNotIn('file_path', $currentPaths)->delete();
                        
                        // Add new specifications
                        $existingPaths = $record->specifications()->pluck('file_path')->toArray();
                        
                        foreach ($currentPaths as $path) {
                            if (!in_array($path, $existingPaths)) {
                                $filename = basename($path);
                                $extension = pathinfo($path, PATHINFO_EXTENSION);
                                
                                $fileSize = 0;
                                try {
                                    if (Storage::disk('s3')->exists($path)) {
                                        $fileSize = Storage::disk('s3')->size($path);
                                    }
                                } catch (\Exception $e) {
                                    // s3 not configured yet in local environment
                                }
                                
                                $record->specifications()->create([
                                    'file_path' => $path,
                                    'original_name' => $filename,
                                    'file_type' => $extension,
                                    'file_size' => $fileSize,
                                ]);
                            }
                        }
                    })
                    ->columnSpanFull(),
            ]);
    }
}
