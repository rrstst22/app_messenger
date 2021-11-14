<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Message;

class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sender_id' => $this->faker->numberBetween($min = 1, $max = 2),
            'room_id' => $this->faker->numberBetween($min = 1, $max = 1),
            'message' => $this->faker->realText(10),
            'sent_at' => $this->faker->dateTime
        ];
    }
}