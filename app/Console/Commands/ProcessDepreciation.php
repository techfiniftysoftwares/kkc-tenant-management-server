<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DepreciationService;
use App\Models\Asset;

class ProcessDepreciation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-depreciation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(DepreciationService $depreciationService)
    {
        $assets = Asset::with('depreciationRecord')->get();

        foreach ($assets as $asset) {

            $depreciationService->updateDepreciationRecord($asset->depreciationRecord);
        }

        $this->info('Depreciation processed for all assets.');
    }
}
