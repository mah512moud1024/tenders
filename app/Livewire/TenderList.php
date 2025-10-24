<?php
namespace App\Livewire;

use App\Models\Quote;
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
    public $selectedCategories = [];
    public $selectedCities = [];
    public $selectedTenderTypes = [];
    public $selectedWorkTypes = [];
    public $sortBys = 'created_at';
    public $sortDirections = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategories' => ['except' => []],
        'selectedCities' => ['except' => []],
        'selectedTenderTypes' => ['except' => []],
        'selectedWorkTypes' => ['except' => []],
        'sortBys' => ['except' => 'created_at'],
        'sortDirections' => ['except' => 'desc'],
    ];

    public function updating($property, $value)
    {
        if (in_array($property, ['search', 'selectedCategories', 'selectedCities', 'selectedTenderTypes', 'selectedWorkTypes', 'sortBys', 'sortDirections'])) {
            $this->resetPage();
        }
    }

    public function updated($property, $value)
    {
        // Reset page for any filter or sort change
        $this->resetPage();
    }

    private function hasAlreadyQuoted($tenderId)
    {
        if (!Auth::check()) return false;

        return Quote::where('tender_id', $tenderId)
            ->where('user_id', Auth::id())
            ->exists();
    }
    public function render()
    {
        $query = Tender::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when(!empty($this->selectedCategories), fn($q) => $q->whereIn('category_id', $this->selectedCategories))
            ->when(!empty($this->selectedCities), fn($q) => $q->whereIn('city_id', $this->selectedCities))
            ->when(!empty($this->selectedTenderTypes), fn($q) => $q->whereIn('tender_type', $this->selectedTenderTypes))
            ->when(!empty($this->selectedWorkTypes), fn($q) => $q->whereIn('work_type', $this->selectedWorkTypes))
            ->where('status', 'published')
            ->where('closing_date', '>', now())
            ->orderBy($this->sortBys, $this->sortDirections);

        $tenders = $query->paginate(20);

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
        $hasAlreadyQuoted = [];
        foreach ($tenders as $tender) {
            $canSubmitQuotes[$tender->id] = $this->canSubmitQuote($tender);
            $hasAlreadyQuoted[$tender->id] = $this->hasAlreadyQuoted($tender->id);
        }

        // Reorder tenders based on quote submission capability
        $currentItems = $tenders->getCollection();
        $tendersCan = $currentItems->filter(fn($t) => ($canSubmitQuotes[$t->id] ?? false))->values();
        $tendersCant = $currentItems->filter(fn($t) => !($canSubmitQuotes[$t->id] ?? false))->values();
        $merged = $tendersCan->merge($tendersCant)->values();
        $tenders->setCollection($merged);

        return view('livewire.tender-list', [
            'tenders' => $tenders,
            'categories' => $categories,
            'cities' => $cities,
            'tenderTypes' => $tenderTypes,
            'workTypes' => $workTypes,
            'canSubmitQuotes' => $canSubmitQuotes,
            'hasAlreadyQuoted' => $hasAlreadyQuoted,
        ]);
    }

    public function sortBy($field)
    {

        if ($this->sortBys === $field) {
            $this->sortDirections = $this->sortDirections === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirections = 'asc';
        }

        $this->sortBy = $field;
    }

    public function resetFilters()
    {
        $this->reset([
            'search',
            'selectedCategories',
            'selectedCities',
            'selectedTenderTypes',
            'selectedWorkTypes'
        ]);
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

        return $user->hasRole($requiredRole) && $user->approved && $user->canSubmitQuote();
    }
}
