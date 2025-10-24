<?php
// [file name]: CheckLicenseExpiry.php
namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckLicenseExpiry extends Command
{
    protected $signature = 'licenses:check-expiry';
    protected $description = 'Check and update expired licenses';

    public function handle()
    {
        $expiredCount = User::whereIn('type', ['consultant', 'contractor', 'subcontractor', 'supplier'])
            ->where('approved', true)
            ->whereNotNull('license_expiry')
            ->where('license_expiry', '<', now())
            ->update(['approved' => false]);

        $this->info("Updated {$expiredCount} users with expired licenses.");
        Log::info("License expiry check: {$expiredCount} users updated.");

        return Command::SUCCESS;
    }
}
