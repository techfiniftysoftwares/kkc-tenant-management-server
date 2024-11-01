<?php

namespace App\Services;

use App\Models\Asset;
use App\Models\DepreciationRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DepreciationService
{
    public function initializeDepreciationRecord(Asset $asset)
    {
        try {
            $record = new DepreciationRecord();
            $record->asset_id = $asset->id;
            $record->depreciation_method = $asset->depreciation_method;
            $record->depreciation_rate = $this->getDepreciationRate($asset);
            $record->accumulated_depreciation = 0;
            $record->book_value = $asset->purchase_price;
            $record->current_value = $asset->purchase_price;
            $record->valuation_method = $asset->valuation_method;
            $record->valuation_date = Carbon::now();
            $record->remaining_useful_life = $asset->estimated_useful_life;
            $record->salvage_value = $asset->salvage_value;
            $record->depreciation_period = 0; // Start at period 0

            $record->save();

            return successResponse('Depreciation record initialized successfully', $record, 201);
        } catch (\Exception $e) {
            Log::error('Error initializing depreciation record', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'asset' => $asset
            ]);

            return serverErrorResponse('Error initializing depreciation record', $e->getMessage());
        }
    }

    private function getDepreciationRate(Asset $asset)
    {
        if ($asset->depreciation_method === 'Straight Line') {
            return 100 / $asset->estimated_useful_life;
        } elseif ($asset->depreciation_method === 'Single Declining Balance') {
            return 1 / $asset->estimated_useful_life;
        } elseif ($asset->depreciation_method === 'Double Declining Balance') {
            return 2 / $asset->estimated_useful_life;
        } elseif ($asset->depreciation_method === 'Units of Production') {
            return ($asset->units_produced / $asset->total_estimated_units) * 100;
        } elseif ($asset->depreciation_method === 'Sum of Years Digits') {
            $sumOfYearsDigits = ($asset->estimated_useful_life * ($asset->estimated_useful_life + 1)) / 2;
            $remainingLife = $asset->estimated_useful_life - ($asset->depreciationRecord->valuation_date->diffInYears(Carbon::now()));
            return ($remainingLife / $sumOfYearsDigits) * 100;
        }

        throw new \InvalidArgumentException("Unsupported depreciation method: {$asset->depreciation_method}");
    }

    private function calculateStraightLineDepreciation($bookValue, $salvageValue, $usefulLife)
    {
        return ($bookValue - $salvageValue) / $usefulLife;
    }

    private function calculateSingleDecliningBalanceDepreciation($bookValue, $rate)
    {
        return $bookValue * ($rate / 100);
    }

    private function calculateDoubleDecliningBalanceDepreciation($bookValue, $rate)
    {
        return $bookValue * ($rate / 100) * 2;
    }

    private function calculateUnitsOfProductionDepreciation($bookValue, $salvageValue, $unitsProduced, $totalEstimatedUnits)
    {
        return ($bookValue - $salvageValue) * ($unitsProduced / $totalEstimatedUnits);
    }

    private function calculateSumOfYearsDigitsDepreciation($bookValue, $salvageValue, $remainingLife)
    {
        $sumOfYearsDigits = ($remainingLife * ($remainingLife + 1)) / 2;
        return ($bookValue - $salvageValue) * ($remainingLife / $sumOfYearsDigits);
    }

    public function calculateDepreciation(DepreciationRecord $record)
    {
        $method = $record->depreciation_method;
        $rate = $record->depreciation_rate;
        $bookValue = $record->book_value;
        $salvageValue = $record->salvage_value;

        if ($method === 'Straight Line') {
            return $this->calculateStraightLineDepreciation($bookValue, $salvageValue, $record->asset->estimated_useful_life);
        } elseif ($method === 'Single Declining Balance') {
            return $this->calculateSingleDecliningBalanceDepreciation($bookValue, $rate);
        } elseif ($method === 'Double Declining Balance') {
            return $this->calculateDoubleDecliningBalanceDepreciation($bookValue, $rate);
        } elseif ($method === 'Units of Production') {
            return $this->calculateUnitsOfProductionDepreciation($bookValue, $salvageValue, $record->asset->units_produced, $record->asset->total_estimated_units);
        } elseif ($method === 'Sum of Years Digits') {
            return $this->calculateSumOfYearsDigitsDepreciation($bookValue, $salvageValue, $record->remaining_useful_life);
        }

        throw new \InvalidArgumentException("Unsupported depreciation method: {$method}");
    }

    public function updateDepreciationRecord(DepreciationRecord $record)
    {
        try {
            $depreciation = $this->calculateDepreciation($record);

            $record->accumulated_depreciation += $depreciation;
            $record->book_value -= $depreciation;
            $record->remaining_useful_life--;

            if ($record->valuation_method === 'Market Value') {
                // Implement logic to get the current market value of the asset
                // $record->current_value = $this->getCurrentMarketValue($record->asset);
                $record->current_value = $record->book_value; // Assumption for now
            } else {
                $record->current_value = $record->book_value;
            }

            $record->valuation_date = Carbon::now();
            $record->depreciation_period += 1; // Increment period by 1
            $record->save();

            return successResponse('Depreciation record updated successfully', $record);
        } catch (\Exception $e) {
            Log::error('Error updating depreciation record', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'record' => $record
            ]);

            return serverErrorResponse('Error updating depreciation record', $e->getMessage());
        }
    }
}
