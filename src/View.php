<?php

namespace Canvas;

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
     * Return the last 30 days with calculated view counts.
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
            $collection->push($item->created_at->copy()->format('m/d'));
        });

        $array = array_count_values($collection->toArray());

        return array_slice($array, 0, 30, true);
    }
}
