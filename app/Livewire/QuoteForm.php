<?php

namespace App\Livewire;

use App\Models\Tender;
use App\Models\Quote;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class QuoteForm extends Component
{
    use WithFileUploads;

    public $tender;
    public $amount;
    public $proposal;
    public $documents = [];
    public $success = false;

    protected $rules = [
        'amount' => 'required|numeric|min:0',
        'proposal' => 'required|string|min:50',
        'documents.*' => 'file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
    ];

    public function mount(Tender $tender)
    {
        $this->tender = $tender;

        // Check if user can submit a quote
        if (!Auth::check() || !$this->canSubmitQuote()) {
            abort(403, 'You are not authorized to submit a quote for this tender.');
        }
    }

    public function submitQuote()
    {
        $this->validate();

        // Create the quote
        $quote = Quote::create([
            'tender_id' => $this->tender->id,
            'user_id' => Auth::id(),
            'amount' => $this->amount,
            'proposal' => $this->proposal,
            'status' => 'submitted',
        ]);

        // Handle file uploads
        if ($this->documents) {
            foreach ($this->documents as $document) {
                $path = $document->store('quote-documents');

                $quote->documents()->create([
                    'file_path' => $path,
                    'original_name' => $document->getClientOriginalName(),
                    'file_type' => $document->getClientOriginalExtension(),
                    'file_size' => $document->getSize(),
                ]);
            }
        }

        $this->success = true;
    }

    private function canSubmitQuote()
    {
        $user = Auth::user();

        // Check if user has the right role for this tender type
        $requiredRole = match($this->tender->tender_type) {
            'design' => 'consultant',
            'construction' => 'contractor',
            'supply' => 'supplier',
            default => null
        };

        return $user->hasRole($requiredRole) && $user->approved;
    }

    public function render()
    {
        return view('livewire.quote-form')->layout('layouts.app', [
            'header' => __('Submit Quote'),
        ]);
    }

}
