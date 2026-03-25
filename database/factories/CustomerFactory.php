<?php

namespace Database\Factories;

use App\CustomerStatus;
use App\Models\Customer;
use App\Models\Industry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $phone = $this->faker->phoneNumber();
        return [
            'company_name'=>$this->faker->company(),
            'full_name'=>$this->faker->name(),
            'birthday'=>$this->faker->dateTimeInInterval("-20 years"),
            'email'=>$this->faker->email(),
            'phone'=>$phone,
            'address'=>$this->faker->address(),
            'tax_code'=>$phone,
            'status'=>$this->faker->randomElement(CustomerStatus::cases()),
            'industry_id'=> Industry::query()->inRandomOrder()->value('id')
        ];
    }
}
