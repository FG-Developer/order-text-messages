<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testOrder()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/orders', [
            'restaurant_name' => 'Burger King',
            'delivery_time' => 30,
            'phone_number' => '345345345345'
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'status' => 200,
                'msg' => 'Success'
            ]);
    }

    /**
     * Order short restaurant name validation test.
     *
     * @return void
     */
    public function testOrderShortRestaurantNameValidation()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/orders', [
            'restaurant_name' => 'S',
            'delivery_time' => 30,
            'phone_number' => '9046473647634'
        ]);

        $response->assertStatus(422);
    }

    /**
     * Order long restaurant name validation test.
     *
     * @return void
     */
    public function testOrderLongRestaurantNameValidation()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/orders', [
            'restaurant_name' => 'Burger Test lorem ipsum bla bla blatest Restaurant long nameSally Test lorem ipsum bla bla blatest Restaurant long nameSally Test lorem ipsum bla bla blatest Restaurant long nameSally Test lorem ipsum bla bla blatest Restaurant long nameSally Test lorem ipsum bla bla blatest Restaurant long name',
            'delivery_time' => 30,
            'phone_number' => '09046473647634'
        ]);

        $response->assertStatus(422);
    }

    /**
     * Order short restaurant delivery time validation test.
     *
     * @return void
     */
    public function testOrderShortDeliveryTimeValidation()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/orders', [
            'restaurant_name' => 'Burger Test',
            'delivery_time' => 4,
            'phone_number' => '09046473647634'
        ]);

        $response->assertStatus(422);
    }

    /**
     * Order long restaurant delivery time validation test.
     *
     * @return void
     */
    public function testOrderLongDeliveryTimeValidation()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/orders', [
            'restaurant_name' => 'Burger Test',
            'delivery_time' => 61,
            'phone_number' => '09046473647634'
        ]);

        $response->assertStatus(422);
    }

    /**
     * Order short customer phone number validation test.
     *
     * @return void
     */
    public function testOrderShortPhoneNumberValidation()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/orders', [
            'restaurant_name' => 'Burger Test',
            'delivery_time' => 30,
            'phone_number' => '123123123'
        ]);

        $response->assertStatus(422);
    }

    /**
     * Order long customer phone number validation test.
     *
     * @return void
     */
    public function testOrderLongPhoneNumberValidation()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/orders', [
            'restaurant_name' => 'Burger Test',
            'delivery_time' => 30,
            'phone_number' => '0904647364763498234234234'
        ]);

        $response->assertStatus(422);
    }
}
