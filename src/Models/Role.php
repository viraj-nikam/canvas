<?php

namespace Canvas\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * Corresponding ID for the contributor role.
     *
     * @const int
     */
    public const CONTRIBUTOR = 1;

    /**
     * Corresponding ID for the editor role.
     *
     * @const int
     */
    public const EDITOR = 2;

    /**
     * Corresponding ID for the admin role.
     *
     * @const int
     */
    public const ADMIN = 3;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'canvas_roles';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
