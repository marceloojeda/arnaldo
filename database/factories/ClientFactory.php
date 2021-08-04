<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->name,
            'fone' => $this->faker->phoneNumber,
            'endereco' => $this->faker->address,
            'bairro' => 'djjkashdjashdjkahsd',
            'cidade' => 'sfkjskldfjskldjfklsdjf',
            'uf' => 'MG',
            'cep' => '78058-888',
            'data_nascimento' => $this->faker->date(),
            'data_adesao' => $this->faker->date(),
            'referencia' => 'Marcelo Ojeda Testes'
        ];
    }
}
