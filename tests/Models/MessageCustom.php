<?php

namespace SertxuDeveloper\Media\Tests\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SertxuDeveloper\Media\HasMedia;
use SertxuDeveloper\Media\Interfaces\MediaInteraction;
use SertxuDeveloper\Media\Tests\Database\Factories\MessageCustomFactory;

class MessageCustom extends Model implements MediaInteraction
{
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

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return new MessageCustomFactory;
    }

    /**
     * Get the media table for the relationship.
     */
    public function getMediaTable(): string
    {
        return 'message_custom_media';
    }
}
