<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
        $name = collect([
            "name" => [
                "title" => "Ms",
                "first"=> "Hella",
                "last"=> "Van Doeselaar"
            ]
        ]);

        $location = [
            "location" => [
                "street" => [
                    "number" => 8958,
                    "name" => "Klein Jagersteinstraat"
                ],
                "city" => "Aldtsjerk",
                "state" => "Limburg",
                "country" => "Netherlands",
                "postcode" => "5240 ME",
                "coordinates" => [
                    "latitude" => "30.1103",
                    "longitude" => "119.8708"
                ],
                "timezone" => [
                    "offset" => "+4:30",
                    "description" => "Kabul"
                ]
            ]
        ];
        
        return [
            'name' => json_encode($name),
            'gender' => 'male',
            'location' => json_encode($location),
            'age' => 27,
        ];
    }
}
