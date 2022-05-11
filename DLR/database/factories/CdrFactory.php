<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cdr>
 */
class CdrFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'message_id' => $this->faker->text,
            'client' => $this->faker->text,
            'sender_id' => $this->faker->text,
            'message_text' => $this->faker->text,
            'status' => $this->faker->text,
            'destination_phone_number' => $this->faker->text,
            'operator' => $this->faker->text,
            'country' => $this->faker->text,
            'delivery_status' => $this->faker->text,
            'terminator_message_id' => $this->faker->text,
            'date_recieved' => $this->faker->text,
            'date_sent' => $this->faker->text,
            'date_dlr' => $this->faker->text,
            'fake' => $this->faker->text,
        ];
    }
}
