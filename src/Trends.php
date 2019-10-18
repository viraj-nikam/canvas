<?php

namespace Canvas;

use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

trait Trends
{
    /**
     * Return an array of daily view counts for a given number of days.
     *
     * @param Collection $views
     * @param int $days
     * @return array
     */
    public function getDailyViewCounts(Collection $views, int $days = 1): array
    {
        // Filter the view data to only include created_at date strings
        $collection = collect();
        $views->sortBy('created_at')->each(function ($item, $key) use ($collection) {
            $collection->push($item->created_at->toDateString());
        });

        // Count the unique values and assign to their respective keys
        $views = array_count_values($collection->toArray());

        // Create a [X] day range to hold the default date values
        $period = CarbonPeriod::create(now()->subDays($days)->toDateString(), $days)->excludeStartDate();
        // Prep the array to perform a comparison with the actual view data
        $range = collect();

        foreach ($period as $key => $date) {
            $range->push($date->toDateString());
        }

        // Compare the view data and date range arrays, assigning view counts where applicable
        $total = collect();
        foreach ($range as $date) {
            if (array_key_exists($date, $views)) {
                $total->put($date, $views[$date]);
            } else {
                $total->put($date, 0);
            }
        }

        return $total->toArray();
    }
}
