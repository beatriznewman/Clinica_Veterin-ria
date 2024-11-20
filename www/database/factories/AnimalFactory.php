<?php
namespace Database\Factories;

use App\Models\Animal;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnimalFactory extends Factory
{
    protected $model = Animal::class;

    public function definition()
    {
        return [
            'especie' => $this->faker->name,
            'nome' => $this->faker->name,
            'descricao' => $this->faker->name,
        ];
    }
}