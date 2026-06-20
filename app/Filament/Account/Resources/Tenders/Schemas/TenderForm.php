<?php

namespace App\Filament\Account\Resources\Tenders\Schemas;

use App\Models\City;
use App\Models\ProjectCategory;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;

class TenderForm
{
    public static function getSchema(): array
    {
        return [
            Section::make('Tender Details')
                ->description('Provide the main details of your project.')
                ->schema([
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255),
                    RichEditor::make('description')
                        ->toolbarButtons([
                            'bold',
                            'bulletList',
                            'orderedList',
                            'redo',
                            'undo',
                        ])
                        ->columnSpanFull()
                        ->disableAllToolbarButtons()
                        ->enableToolbarButtons([
                            'bold',
                            'bulletList',
                            'orderedList',
                            'redo',
                            'undo',
                        ])
                        ->extraAttributes(['class' => 'custom-rich-editor']),

                    Select::make('city_id')
                        ->label('City')
                        ->options(City::where('active', true)->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                    TextInput::make('area')
                        ->label('Neighborhood / Area')
                        ->maxLength(255)
                        ->required(),
                    DatePicker::make('closing_date')
                        ->required()
                        ->native(false)
                        ->minDate(now()),
                ])->columns(2),

            Section::make('Project Specifications')
                ->schema([
                    Forms\Components\Select::make('project_type')
                        ->options([
                            'building' => 'Building',
                            'roads' => 'Roads',
                        ])
                        ->required(),

                    Select::make('work_type')
                        ->options([
                            'maintenance' => 'Maintenance',
                            'new_construction' => 'New Construction',
                            'completion' => 'Completion',
                        ])
                        ->required()
                        ->reactive(),

                    Select::make('tender_type')
                        ->options([
                            'design' => 'Design',
                            'construction' => 'Construction',
                            'supply' => 'Supply',
                        ])
                        ->required()
                        ->reactive(),

                    Select::make('category_id')
                        ->label('Project Category')
                        ->options(ProjectCategory::where('active', true)->pluck('name', 'id'))
                        ->searchable()
                        ->required(),

                    // ---------- Maintenance Group ----------
                    Fieldset::make('Maintenance Details')
                        ->schema([
                            TextInput::make('required_service')
                                ->label('Required Service')
                                ->maxLength(255)
                                ->required(),
                        ])
                        ->hidden(fn ($get) => $get('work_type') !== 'maintenance' || $get('tender_type') === 'supply'),

                    // ---------- Construction / Design Group ----------
                    Fieldset::make('Building Details')
                        ->schema([
                            TextInput::make('floors')
                                ->numeric()
                                ->required(),

                            TextInput::make('building_area')
                                ->label('Building Area (sqm)')
                                ->numeric()
                                ->required(),

                            TextInput::make('land_area')
                                ->label('Land Area (sqm)')
                                ->numeric()
                                ->required(),
                        ])->columnSpanFull()
                        ->columns(3)
                        ->hidden(fn ($get) =>
                            $get('tender_type') === 'supply'
                            || $get('work_type') === 'maintenance'
                        ),
                ])->columns(2),

            Section::make('Tender Documents')
                ->description('Upload project drawings, specifications, bills of quantities, etc.')
                ->schema([
                    Forms\Components\FileUpload::make('attachments')
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
                        ->loadStateFromRelationshipsUsing(function (\App\Models\Tender $record) {
                            return $record->specifications->pluck('file_path')->toArray();
                        })
                        ->saveRelationshipsUsing(function (\App\Models\Tender $record, $state) {
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
                                        if (\Illuminate\Support\Facades\Storage::disk('s3')->exists($path)) {
                                            $fileSize = \Illuminate\Support\Facades\Storage::disk('s3')->size($path);
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
                ]),
        ];
    }
}
