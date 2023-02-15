<?php

namespace SertxuDeveloper\Media\Tests\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SertxuDeveloper\Media\HasMedia;
use SertxuDeveloper\Media\Interfaces\MediaInteraction;
use SertxuDeveloper\Media\Tests\Database\Factories\MessageFactory;

class Message extends Model implements MediaInteraction
{
    use HasFactory, HasMedia;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = [];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return new MessageFactory;
    }
}
