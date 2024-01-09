<?php

namespace Database\Factories;

use App\Models\Request;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RequestFactory extends Factory
{
    protected $model = Request::class;

    public function definition(): array
    {
        $status = $this->faker->randomElement([Request::STATUS_ACTIVE, Request::STATUS_RESOLVED]);
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'status' => $status,
            'message' => $this->faker->word(),
            'comment' => ($status === Request::STATUS_RESOLVED) ? $this->faker->word() : null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
