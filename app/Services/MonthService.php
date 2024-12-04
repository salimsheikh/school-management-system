<?php

namespace App\Services;

use Illuminate\Support\Collection;
use InvalidArgumentException;

class MonthService
{
    /**
     * Get ordered months with dynamic keys.
     *
     * @param bool $short
     * @param string $startMonth
     * @return array
     */
    public function getMonths(bool $short = false, string $startMonth = 'june'): array
    {
        // Define months with keys as lowercase names for consistency
        $months = collect([
            'january' => $short ? __('Jan') : __('January'),
            'february' => $short ? __('Feb') : __('February'),
            'march' => $short ? __('Mar') : __('March'),
            'april' => $short ? __('Apr') : __('April'),
            'may' => $short ? __('May') : __('May'),
            'june' => $short ? __('Jun') : __('June'),
            'july' => $short ? __('Jul') : __('July'),
            'august' => $short ? __('Aug') : __('August'),
            'september' => $short ? __('Sep') : __('September'),
            'october' => $short ? __('Oct') : __('October'),
            'november' => $short ? __('Nov') : __('November'),
            'december' => $short ? __('Dec') : __('December'),
        ]);

        // Convert the start month to lowercase to match keys
        $startMonth = strtolower($startMonth);

        // Ensure the start month exists in the collection
        if (!$months->has($startMonth)) {
            throw new InvalidArgumentException(__('Invalid start month.'));
        }

        // Rotate the months array to start from the configured month
        $startIndex = $months->keys()->search($startMonth);
        $orderedMonths = $months->slice($startIndex)->merge($months->take($startIndex));

        // Generate the months_fields array dynamically
        return $orderedMonths->values()->mapWithKeys(function ($month, $index) {
            $key = 'month' . str_pad($index + 1, 2, '0', STR_PAD_LEFT);
            return [$key => $month];
        })->toArray();
    }
}
