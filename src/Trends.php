<?php

namespace Canvas;

use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use Carbon\CarbonInterval;
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
    public function getDailyViewCounts(Collection $views, int $days): array
    {
        // Filter the view data to only include created_at date strings
        $collection = collect();
        $views->sortBy('created_at')->each(function ($item, $key) use ($collection) {
            $collection->push($item->created_at->toDateString());
        });

        // Count the unique values and assign to their respective keys
        $views = array_count_values($collection->toArray());

        // Create a [X] day range to hold the default date values
        $range = $this->generateFormattedDateRange(today()->subDays($days), CarbonInterval::day(), $days);

        // Compare the view data and date range arrays, assigning view counts where applicable
        $total = collect();
        foreach ($range as $date) {
            array_key_exists($date, $views) ? $total->put($date, $views[$date]) : $total->put($date, 0);
        }

        return $total->toArray();
    }

    /**
     * Return an array of formatted dates for a given interval.
     *
     * @param Carbon $start_date
     * @param DateInterval $interval
     * @param int $recurrences
     * @param int $exclusive
     * @return array
     */
    private function generateFormattedDateRange(Carbon $start_date, DateInterval $interval, int $recurrences, int $exclusive = 1): array
    {
        $period = new DatePeriod($start_date, $interval, $recurrences, $exclusive);

        $dates = collect();
        foreach ($period as $date) {
            $dates->push($date->format('Y-m-d'));
        }

        return $dates->toArray();
    }
}
