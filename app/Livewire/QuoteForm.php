<?php

namespace App\Livewire;

use App\Models\Tender;
use App\Models\Quote;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class QuoteForm extends Component
{
    use WithFileUploads;

    public Tender $tender;
    public $amount;
    public $proposal;
    public array $documents = [];
    public bool $success = false;
    public ?string $authorizationError = null;

    protected $rules = [
        'amount' => 'required|numeric|min:0',
        'proposal' => 'required|string|min:50',
        'documents.*' => 'file|mimes:pdf,doc,docx,xls,xlsx|max:10240', // 10MB
    ];

    public function mount(Tender $tender)
    {
        $this->tender = $tender;
        $user = Auth::user();

        // Check 1: User must be an approved business owner of the correct type
        if (!$this->isUserAuthorizedToBid()) {
            $this->authorizationError = 'Your account is not authorized to submit quotes for this type of tender.';
            return;
        }

        // Check 2: Enforce the quote limit for non-subscribed users
        if (!$user->canSubmitQuote()) {
            $this->authorizationError = 'You have reached your free quote limit. Please subscribe to submit more quotes.';
            return;
        }
    }

    public function submitQuote()
    {
        // Re-check authorization on submit
        if ($this->authorizationError) {
            return;
        }

        $this->validate();

        $quote = Quote::create([
            'tender_id' => $this->tender->id,
            'user_id' => Auth::id(),
            'amount' => $this->amount,
            'proposal' => $this->proposal,
            'status' => 'under_review', // Quotes should be reviewed by admin first
        ]);

        foreach ($this->documents as $document) {
            $path = $document->store('private/quote-documents');
            $quote->documents()->create([
                'file_path' => $path,
                'original_name' => $document->getClientOriginalName(),
                'file_type' => $document->getClientOriginalExtension(),
                'file_size' => $document->getSize(),
            ]);
        }

        $this->success = true;
    }

    private function isUserAuthorizedToBid(): bool
    {
        $user = Auth::user();

        if (!$user || !$user->approved || $user->type === 'client') {
            return false;
        }

        $requiredRole = match($this->tender->tender_type) {
            'design' => 'consultant',
            'construction' => 'contractor',
            'supply' => 'supplier',
            default => null
        };

        return $user->hasRole($requiredRole);
    }

    public function render()
    {
        return view('livewire.quote-form')->layout('layouts.app');
    }
}
