<?php

namespace Canvas;

use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class View extends Model
{
    const DAYS_PRIOR = 30;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'canvas_views';

    /**
     * The post a view belongs to.
     *
     * @return BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Return a view count for the last [X] days.
     *
     * @param Collection $views
     * @return array
     */
    public static function viewTrend(Collection $views): array
    {
        // Get all the views for the last [X] days
        $filtered = $views->filter(function ($value, $key) {
            return $value->created_at >= now()->subDays(self::DAYS_PRIOR);
        });

        // Sort the collection by created dates
        $collection = collect();
        $filtered->sortBy('created_at')->each(function ($item, $key) use ($collection) {
            $collection->push($item->created_at->toDateString());
        });

        // Count the views and assign the key/value pairs
        $views = array_count_values($collection->toArray());

        // Create a [X] day period
        $period = CarbonPeriod::create(now()->subDays(self::DAYS_PRIOR)->toDateString(), self::DAYS_PRIOR)->excludeStartDate();

        // Build a collection of dates for each day in the period
        $range = collect();
        foreach ($period as $key => $date) {
            $range->push($date->toDateString());
        }

        $total = collect();
        // Compare the collections and assign matching dates with their views
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
