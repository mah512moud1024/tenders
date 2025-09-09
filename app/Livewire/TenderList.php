<?php

namespace App\Livewire;

use App\Models\Tender;
use App\Models\ProjectCategory;
use App\Models\City;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class TenderList extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';
    public $city = '';
    public $tenderType = '';
    public $workType = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => ''],
        'city' => ['except' => ''],
        'tenderType' => ['except' => ''],
        'workType' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function render()
    {
        $tenders = Tender::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->category, fn($q) => $q->where('category_id', $this->category))
            ->when($this->city, fn($q) => $q->where('city_id', $this->city))
            ->when($this->tenderType, fn($q) => $q->where('tender_type', $this->tenderType))
            ->when($this->workType, fn($q) => $q->where('work_type', $this->workType))
            ->where('status', 'published')
            ->where('closing_date', '>', now())
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        $categories = ProjectCategory::whereNull('parent_id')->get();
        $cities = City::where('active', true)->get();

        $tenderTypes = [
            'design' => 'Design',
            'construction' => 'Construction',
            'supply' => 'Supply',
        ];

        $workTypes = [
            'maintenance' => 'Maintenance',
            'new_construction' => 'New Construction',
            'completion' => 'Completion',
        ];

        $canSubmitQuotes = [];
        foreach ($tenders as $tender) {
            $canSubmitQuotes[$tender->id] = $this->canSubmitQuote($tender);
        }

        // ✅ Set the layout for page components
        return view('livewire.tender-list', [
            'tenders' => $tenders,
            'categories' => $categories,
            'cities' => $cities,
            'tenderTypes' => $tenderTypes,
            'workTypes' => $workTypes,
            'canSubmitQuotes' => $canSubmitQuotes,
        ])->layout('layouts.app'); // <- points to resources/views/layouts/app.blade.php
    }

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortBy === $field
            ? ($this->sortDirection === 'asc' ? 'desc' : 'asc')
            : 'asc';

        $this->sortBy = $field;
    }

    public function resetFilters()
    {
        $this->reset(['search', 'category', 'city', 'tenderType', 'workType']);
        $this->resetPage();
    }

    public function canSubmitQuote($tender)
    {
        if (!Auth::check()) return false;

        $user = Auth::user();

        $requiredRole = match($tender->tender_type) {
            'design' => 'consultant',
            'construction' => 'contractor',
            'supply' => 'supplier',
            default => null,
        };

        return $user->hasRole($requiredRole) && $user->approved;
    }
}
