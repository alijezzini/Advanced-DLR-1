<?php

namespace Database\Factories;

use App\Models\Cdr;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cdr>
 */
class CdrFactory extends Factory
{
    protected $model = Cdr::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'message_id' => $this->faker->randomDigit,
            'client' => $this->faker->title,
            'sender_id' => $this->faker->randomDigit,
            'message_text' => $this->faker->text,
            'status' => $this->faker->text,
            'destination' => $this->faker->text,
            'operator' => $this->faker->text,
            'country' => $this->faker->text,
            'delivery_status' => $this->faker->text,
            'terminator_message_id' => $this->faker->randomDigit,
            'date_recieved' => $this->faker->date,
            'date_sent' => $this->faker->date,
            'date_dlr' => $this->faker->date,
            'fake' => $this->faker->boolean,
        ];
    }
}
