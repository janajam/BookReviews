<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'book_id'=>null,
            'review'=>fake()->paragraph,
            'rate'=>fake()->numberBetween(1,5),
            'created_at'=>fake()->dateTimeBetween('-2 years'),
            'updated_at'=>function(array $attributs){
                return fake()->dateTimeBetween($attributs['created_at']);
            }

        
        ];


    }


    public function good(){
        return  $this->state(function(array $attributs){
            return[
                'rate'=>fake()->numberBetween(4,5),
            ];
        });
    }

    public function avarage(){
        return  $this->state(function(array $attributs){
            return[
                'rate'=>fake()->numberBetween(2,5),
            ];
        });
    }

    public function bad(){
        return  $this->state(function(array $attributs){
            return[
                'rate'=>fake()->numberBetween(1,3),
            ];
        });
    }
}
