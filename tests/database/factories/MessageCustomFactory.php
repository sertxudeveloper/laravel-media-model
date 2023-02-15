<?php

namespace SertxuDeveloper\Media\Tests\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use SertxuDeveloper\Media\Tests\Models\MessageCustom;

class MessageCustomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = MessageCustom::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject' => $this->faker->sentence,
            'message' => $this->faker->paragraph,
        ];
    }
}
