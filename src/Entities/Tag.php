<?php

namespace Canvas\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends BaseEntity
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'tags';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @return MorphToMany
     */
    public function posts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }
}
