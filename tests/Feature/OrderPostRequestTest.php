<?php

namespace Tests\Feature;

use App\Http\Requests\OrderPostRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class OrderPostRequestTest extends TestCase
{
    public function testValidRequest()
    {
        $request = [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => 2000,
            'currency' => 'TWD',
            'room_id' => 1,
            'bnb_id' => 1,
            'check_in_date' => '2024-08-08',
            'check_out_date' => '2024-08-10'
        ];

        $formRequest = new OrderPostRequest();

        $validator = Validator::make($request, $formRequest->rules());

        $this->assertFalse($validator->fails(), 'Validator should not fail for valid data.');
    }

    public function testInvalidCapitalizeNameRequest()
    {
        $request = [
            'id' => 'A0000001',
            'name' => 'melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => 2000,
            'currency' => 'TWD',
            'room_id' => 1,
            'bnb_id' => 1,
            'check_in_date' => '2024-08-08',
            'check_out_date' => '2024-08-10'
        ];

        $formRequest = new OrderPostRequest();

        $validator = Validator::make($request, $formRequest->rules());

        $this->assertTrue($validator->fails(), $validator->messages());
    }

    public function testInvalidAlphaNameRequest()
    {
        $request = [
            'id' => 'A0000001',
            'name' => 'melody Holiday Inn1',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => 2000,
            'currency' => 'TWD',
            'room_id' => 1,
            'bnb_id' => 1,
            'check_in_date' => '2024-08-08',
            'check_out_date' => '2024-08-10'
        ];

        $formRequest = new OrderPostRequest();

        $validator = Validator::make($request, $formRequest->rules());

        $this->assertTrue($validator->fails(), $validator->messages());
    }

    public function testInvalidAmountRequest()
    {
        $request = [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => 2001,
            'currency' => 'TWD',
            'room_id' => 1,
            'bnb_id' => 1,
            'check_in_date' => '2024-08-08',
            'check_out_date' => '2024-08-10'
        ];

        $formRequest = new OrderPostRequest();

        $validator = Validator::make($request, $formRequest->rules());

        $this->assertTrue($validator->fails(), $validator->messages());
    }

    public function testInvalidCurrencyRequest()
    {
        $request = [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => 2001,
            'currency' => 'CNY',
            'room_id' => 1,
            'bnb_id' => 1,
            'check_in_date' => '2024-08-08',
            'check_out_date' => '2024-08-10'
        ];

        $formRequest = new OrderPostRequest();

        $validator = Validator::make($request, $formRequest->rules());

        $this->assertTrue($validator->fails(), $validator->messages());
    }
}
