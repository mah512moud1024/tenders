<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeAllFilamentResources extends Command
{
    protected $signature = 'filament:make-all-resources';
    protected $description = 'Generate Filament resources for all models in app/Models';

    public function handle(): int
    {
        $modelsPath = app_path('Models');
        $models = collect(File::files($modelsPath))
            ->map(fn($file) => pathinfo($file, PATHINFO_FILENAME));

        foreach ($models as $model) {
            $this->info("Generating Filament resource for {$model}...");
            $this->call('filament:resource', [
                'model' => "{$model}",
                '--generate' => true,
            ]);
        }

        $this->info("✅ All Filament resources generated!");
        return self::SUCCESS;
    }
}
