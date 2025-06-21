<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Address;

class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => null,
            'postal_code' => $this->faker->postcode,
            'prefecture' => $this->faker->state,
            'city' => $this->faker->city,
            'building' => $this->faker->secondaryAddress,
        ];
    }
}
