<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Customer;
use App\Models\PaymentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'employee_id' => 1,
            'customer_id' => $this->faker->randomElement(Customer::all())['id'],
            'order_date' => $this->faker->dateTime('now','Asia/Ho_Chi_Minh'),
            'order_note' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'address_id' => $this->faker->randomElement(Address::all())['id'],
            'shipping_fee' => $this->faker->randomElement(array(15000,20000, 25000, 30000)),
            'payment_type_id' => $this->faker->randomElement(PaymentType::all())['id'],
            'order_status' => $this->faker->numberBetween(1,4),
            'created_at' => $this->faker->dateTime('now','Asia/Ho_Chi_Minh'),
            'updated_at' => $this->faker->dateTime('now','Asia/Ho_Chi_Minh'),
        ];
    }
}
