<?php

namespace SertxuDeveloper\Media\Tests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SertxuDeveloper\Media\HasMedia;
use SertxuDeveloper\Media\Interfaces\MediaInteraction;

class MessageCustom extends Model implements MediaInteraction {

    use HasFactory, HasMedia;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'message_custom';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = [];
}
