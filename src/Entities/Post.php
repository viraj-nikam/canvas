<?php

namespace Canvas\Entities;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Post extends BaseEntity
{
    use HasSlug, SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'canvas_posts';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'summary',
        'body',
        'slug',
        'published_at',
    ];

    /**
     * @var array
     */
    protected $with = ['tags'];

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * A post can have many tags.
     *
     * @return MorphToMany
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * A post belongs to a user.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get the options for generating the slug.
     *
     * @return SlugOptions
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * @param $value
     * @return bool
     */
    public function getPublishedAttribute($value): bool
    {
        if ($this->published_at <= now()->toDateTimeString()) {
            return true;
        } else {
            return false;
        }
    }
}
