<?php

namespace SertxuDeveloper\Media\Tests\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SertxuDeveloper\Media\HasMedia;
use SertxuDeveloper\Media\Tests\Database\Factories\NonMediaModelFactory;

class NonMediaModel extends Model {

    use HasFactory, HasMedia;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = [];


    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory {
        return new NonMediaModelFactory();
    }
}
