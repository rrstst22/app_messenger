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
            'sender_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'room_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'message' => $this->faker->text,
            'sent_at' => $this->faker->dateTime
        ];
    }
}