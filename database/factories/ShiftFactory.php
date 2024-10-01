<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shift>
 */
class ShiftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'shift_name' => 'morning_shift', // This could be dynamic if needed
            'start_shift' => Carbon::parse('09:00:00'), // Properly formatted time
            'end_shift' => Carbon::parse('16:00:00'),  // Using 24-hour format for clarity
        ];
    }
}
