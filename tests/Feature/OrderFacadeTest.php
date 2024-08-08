<?php

namespace Tests\Feature;

use App\Models\Bnb;
use App\Models\Order;
use App\Models\Room;
use App\Utils\OrderFacade;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderFacadeTest extends TestCase
{
    use RefreshDatabase;

    private $bnb;
    private $room;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bnb = Bnb::firstOrCreate([
            'name' => 'Sweety Home'
        ]);

        $this->room = Room::firstOrCreate([
            'bnb_id' => $this->bnb->id,
            'name' => '3F-1',
        ]);

        Order::firstOrCreate([
            'room_id' => $this->room->id,
            'check_in_date' => Carbon::parse('2024-08-07 15:00'),
            'check_out_date' => Carbon::parse('2024-08-09 11:00'),
            'bnb_id' => $this->bnb->id,
            'currency' => 'TWD',
            'amount' => 1000,
        ]);
    }

    public function testValidOrders()
    {
        $isOverlapping = OrderFacade::createOrder([
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => 2000,
            'currency' => 'TWD',
            'room_id' => $this->room->id,
            'bnb_id' => $this->bnb->id,
            'check_in_date' => '2024-08-01 15:00',
            'check_out_date' => '2024-08-06 11:00'
        ]);

        $this->assertModelExists($isOverlapping);
    }

    public function testInvalidOrder()
    {
        $this->expectExceptionMessage('room has been booked');

        $isOverlapping = OrderFacade::createOrder([
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => 2000,
            'currency' => 'TWD',
            'room_id' => $this->room->id,
            'bnb_id' => $this->bnb->id,
            'check_in_date' => '2024-08-08 15:00',
            'check_out_date' => '2024-08-10 11:00'
        ]);
    }
}
