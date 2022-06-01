<?php

namespace SertxuDeveloper\Media;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Media
 * @package SertxuDeveloper\Media
 *
 * @property string $path
 */
class Media extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'media';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [

    ];
}
