<?php

namespace Canvas;

use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class View extends Model
{
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
     * Return a view count for the last 30 days.
     *
     * @param Collection $views
     * @return array
     */
    public static function viewTrend(Collection $views): array
    {
        $filtered = $views->filter(function ($value, $key) {
            return $value->created_at >= now()->subDays(30);
        });

        $collection = collect();
        $filtered->sortBy('created_at')->each(function ($item, $key) use ($collection) {
            $collection->push($item->created_at->toDateString());
        });

        $views = array_count_values($collection->toArray());

        $period = CarbonPeriod::create(now()->subDays(30)->toDateString(), 30)->excludeStartDate();

        $range = collect();
        foreach ($period as $key => $date) {
            $range->push($date->toDateString());
        }

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
