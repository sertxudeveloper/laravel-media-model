<?php

namespace SertxuDeveloper\Media;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Media
 *
 * @package SertxuDeveloper\Media
 *
 * @property integer $id
 * @property integer $model_id
 * @property string $filename
 * @property string $path
 * @property string $disk
 * @property string $collection
 * @property string $mime_type
 * @property integer $size
 * @property Carbon $created_at
 * @property Carbon $updated_at
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
