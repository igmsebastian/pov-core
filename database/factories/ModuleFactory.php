<?php

namespace Database\Factories;

use App\Enums\StatusEnum;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Module>
 */
class ModuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'country' => 'PH',
            'name' => $this->faker->words(2, true),
            'code' => strtoupper(Str::slug($this->faker->unique()->words(2, true), '_')),
            'description' => $this->faker->optional()->sentence(),
            'status' => $this->faker->randomElement(StatusEnum::commonStatuses()),
            'configs' => [
                'enabled' => true,
                'allowed_permissions' => [$this->faker->slug()],
                'sidemenus' => [$this->faker->slug()],
                'custom_fields' => [
                    ['label' => $this->faker->word(),
                    'type' => $this->faker->word(),
                    'value' => $this->faker->word(),
                    'options' => [$this->faker->word()],
                    'regex' => $this->faker->word(),]
                ],
            ],
            'metas' => [
                'visibility' => true,
                'style' => $this->faker->word(),
                'hex_color' => $this->faker->word(),
                'icon' => $this->faker->word(),
            ],
        ];
    }
}
