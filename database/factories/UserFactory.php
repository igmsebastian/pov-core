<?php

namespace Database\Factories;

use App\Models\Team;
use App\Enums\StatusEnum;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id'                => (string) Str::ulid(),
            'guid'              => Str::uuid(),
            'samaccountname'    => $this->faker->unique()->userName,
            'dn'                => $this->faker->domainName,
            'name'              => $this->faker->name,
            'email'             => $this->faker->unique()->safeEmail,
            'title'             => $this->faker->jobTitle,
            'company'           => $this->faker->company,
            'division'          => $this->faker->word,
            'memberof'          => implode(',', $this->faker->words(3)),
            'department'        => $this->faker->word,
            'departmentNumber'  => (string) $this->faker->numberBetween(100, 999),
            'manager'           => $this->faker->name,
            'manager_email'     => $this->faker->companyEmail,
            'lead'              => $this->faker->name,
            'lead_email'        => $this->faker->companyEmail,
            'team_id'           => null,
            'status'            => StatusEnum::ACTIVE,
            'created_at'        => now(),
            'updated_at'        => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user belongs to a team.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withTeam()
    {
        return $this->state(function (array $attributes) {
            return [
                'team_id' => Team::factory(),
            ];
        });
    }
}
