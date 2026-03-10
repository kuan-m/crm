<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'subject' => $this->faker->sentence(),
            'text' => $this->faker->paragraphs(3, true),
            'status' => 1,
            'replied_at' => null,
        ];
    }

    public function inWork(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 2,
        ]);
    }

    public function processed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 3,
            'replied_at' => now()->subHours(rand(1, 48)),
        ]);
    }
}
