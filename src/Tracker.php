<?php

namespace Canvas;

use Carbon\CarbonInterval;
use DateInterval;
use DatePeriod;
use DateTimeInterface;
use Illuminate\Support\Collection;

trait Tracker
{
    /**
     * Return a date => total array for a given number of days.
     *
     * @param Collection $data
     * @param int $days
     * @return array
     */
    public function countTrackedDataForDays(Collection $data, int $days = 1): array
    {
        // Filter the data to only include created_at date strings
        $filtered = collect();
        $data->sortBy('created_at')->each(function ($item, $key) use ($filtered) {
            $filtered->push($item->created_at->toDateString());
        });

        // Count the unique values and assign to their respective keys
        $unique = array_count_values($filtered->toArray());

        // Create a day range to hold the default date values
        $period = $this->generateDateRange(today()->subDays($days), CarbonInterval::day(), $days);

        // Compare the data and date range arrays, assigning counts where applicable
        $total = collect();

        foreach ($period as $date) {
            if (array_key_exists($date, $unique)) {
                $total->put($date, $unique[$date]);
            } else {
                $total->put($date, 0);
            }
        }

        return $total->toArray();
    }

    /**
     * Get post-specific tracking data along with totals.
     *
     * @param array $postIDs
     * @param int $days
     * @return array
     */
    public function getTrackedDataForPosts(array $postIDs, int $days): array
    {
        $totalViews = View::whereIn('post_id', $postIDs)
                          ->whereBetween('created_at', [
                              today()->subDays($days)->startOfDay()->toDateTimeString(),
                              today()->endOfDay()->toDateTimeString(),
                          ])
                          ->get();

        $totalVisits = Visit::whereIn('post_id', $postIDs)
                            ->whereBetween('created_at', [
                                today()->subDays($days)->startOfDay()->toDateTimeString(),
                                now()->endOfDay()->toDateTimeString(),
                            ])
                            ->get();

        $dataForPosts = collect();

        foreach ($postIDs as $postID) {
            $viewCount = $totalViews->where('post_id', $postID)->count();
            $visitCount = $totalVisits->where('post_id', $postID)->count();

            // Only collect view data if any exists
            if (array_sum([$viewCount, $visitCount]) > 0) {
                $post = Post::find($postID);
                $dataForPosts->put($post->id, [
                    'title' => $post->title,
                    'views' => $viewCount,
                    'visits' => $visitCount,
                ]);
            }
        }

        $data = collect();
        $data->put('posts', $dataForPosts);
        $data->put('totals', [
            'views' => $totalViews->count(),
            'visits' => $totalVisits->count(),
            'startDate' => now()->subDays(self::DAYS)->format('M d'),
            'endDate' => now()->format('M d'),
        ]);

        return $data->toArray();
    }

    /**
     * Given two collections of monthly data, compare the totals and return the
     * overall directional trend as well as the percentage increase/decrease.
     *
     * @param Collection $current
     * @param Collection $previous
     * @return array
     */
    public function compareMonthToMonth(Collection $current, Collection $previous): array
    {
        $dataCountThisMonth = $current->count();
        $dataCountLastMonth = $previous->count();

        if ($dataCountLastMonth != 0) {
            $difference = (int) $dataCountLastMonth - (int) $dataCountThisMonth;
            $growth = ($difference / $dataCountLastMonth) * 100;
        } else {
            $growth = $dataCountThisMonth * 100;
        }

        return [
            'direction' => $dataCountThisMonth > $dataCountLastMonth ? 'up' : 'down',
            'percentage' => number_format($growth),
        ];
    }

    /**
     * Generate a date range array of formatted strings.
     *
     * @param DateTimeInterface $start_date
     * @param DateInterval $interval
     * @param int $recurrences
     * @param int $exclusive
     * @return array
     */
    private function generateDateRange(DateTimeInterface $start_date, DateInterval $interval, int $recurrences, int $exclusive = 1): array
    {
        $period = new DatePeriod($start_date, $interval, $recurrences, $exclusive);
        $dates = collect();

        foreach ($period as $date) {
            $dates->push($date->format('Y-m-d'));
        }

        return $dates->toArray();
    }
}
