<?php
// [file name]: TenderDetail.php
namespace App\Livewire;

use App\Models\Quote;
use App\Models\Tender;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class TenderDetail extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public Tender $tender;
    public bool $hasAlreadyQuoted = false;

    public function mount(Tender $tender): void
    {
        $this->tender = $tender;
        if (Auth::check()) {
            $this->hasAlreadyQuoted = Quote::where('tender_id', $this->tender->id)
                ->where('user_id', Auth::id())
                ->exists();
        }
    }

    public function submitQuoteAction(): Action
    {
        return Action::make('submitQuote')
            ->label(function (): string {
                if ($this->hasAlreadyQuoted || !Auth::user() || !Auth::user()->canSubmitQuote() || !$this->isUserAuthorizedToBid()) {
                    return 'Already submitted';
                }
                return 'Submit Quote';
            })
            ->button()
            ->color(function (): string {
                if ($this->hasAlreadyQuoted || !Auth::user() || !Auth::user()->canSubmitQuote() || !$this->isUserAuthorizedToBid()) {
                    return 'info';
                }
                return 'primary';
            })
            ->modalHeading('Submit Your Quote for: ' . $this->tender->title)
            ->form([
                TextInput::make('amount')
                    ->label('Quote Amount (AED)')
                    ->numeric()
                    ->required()
                    ->prefix('AED'),
                Textarea::make('proposal')
                    ->label('Proposal Details')
                    ->required()
                    ->minLength(50)
                    ->rows(6)
                    ->helperText('Describe your proposal in detail.'),
                FileUpload::make('documents')
                    ->label('Supporting Documents')
                    ->multiple()
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                    ->maxSize(10240)
                    ->directory('private/quote-documents')
            ])
            ->action(function (array $data) {
                $user = Auth::user();

                $quote = Quote::create([
                    'tender_id' => $this->tender->id,
                    'user_id' => $user->id,
                    'amount' => $data['amount'],
                    'proposal' => $data['proposal'],
                    'status' => 'under_review',
                ]);

                if (!empty($data['documents'])) {
                    foreach ($data['documents'] as $documentPath) {
                        $quote->documents()->create([
                            'file_path' => $documentPath,
                            'original_name' => basename($documentPath),
                            'file_type' => Storage::disk('private')->mimeType($documentPath),
                            'file_size' => Storage::disk('private')->size($documentPath),
                        ]);
                    }
                }

                Notification::make()
                    ->title('Quote Submitted Successfully!')
                    ->body('Your quote is now under review.')
                    ->success()
                    ->send();

                return redirect(route('filament.account.pages.browse-tenders'));
            })
            ->disabled(fn(): bool => $this->hasAlreadyQuoted || !Auth::user() || !Auth::user()->canSubmitQuote() || !$this->isUserAuthorizedToBid())
            ->modalDescription(function () {
                if ($this->hasAlreadyQuoted) {
                    return 'You have already submitted a quote for this tender.';
                }
                if (!Auth::user()?->canSubmitQuote()) {
                    return 'You have reached your free quote limit. Please subscribe to submit more quotes.';
                }
                if (!$this->isUserAuthorizedToBid()) {
                    return 'Your account type is not authorized to submit quotes for this tender.';
                }
                return 'Please fill in the details below. Your submission will be sent for admin review.';
            });
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

        return view('livewire.tender-detail', [
            'tenderTypes' => $tenderTypes,
            'workTypes' => $workTypes,
        ]);
    }
}
