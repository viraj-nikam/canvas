<?php

namespace Canvas\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Note extends Model
{
    use SoftDeletes, Searchable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'canvas_notes';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Get the tags relationship.
     *
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            'canvas_notes_tags',
            'note_id',
            'tag_id'
        );
    }

    /**
     * Get the topic relationship.
     *
     * @return BelongsToMany
     */
    public function topic(): BelongsToMany
    {
        return $this->belongsToMany(
            Topic::class,
            'canvas_notes_topics',
            'note_id',
            'topic_id'
        );
    }

    /**
     * Get the user relationship.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function (self $note) {
            $note->tags()->detach();
            $note->topic()->detach();
        });
    }

    /**
     * Determine if the model should be searchable.
     */
    public function shouldBeSearchable(): bool
    {
        return true;
    }

    /**
     * Fields to be indexed by Scout/Typesense.
     */
    public function toSearchableArray(): array
    {
        $text = trim(strip_tags((string) $this->body));

        return [
            'id' => $this->id,
            'body' => $text,
            'created_at' => optional($this->created_at)->timestamp,
            'updated_at' => optional($this->updated_at)->timestamp,
        ];
    }
}
