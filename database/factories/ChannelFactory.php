<?php

namespace Database\Factories;

use App\Models\Channel;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;


class ChannelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Channel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->sentence(4);
        return [
            'name' => $name,
            'slug' => Str::slug($name)
        ];
    }
}

