<?php

namespace App\Utils;

use App\Enums\Currency;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * @throws \Throwable
     */
    public function createOrder(array $data): Order
    {
        /**
         * 這邊沒有考慮到高併發的狀態
         * 高併發的情境可能需要再根據實際條件與商務邏輯一起參與討論，才有實際對策
         * 初步想法為
         * 1. lock row
         * 2. update row status
         * 3. release row
         */
        $roomId = $data['room_id'];
        $checkInDate = $data['check_in_date'];
        $checkOutDate = $data['check_out_date'];

        $isOverlapping = Order::query()
            ->where('room_id', $roomId)
            ->where(function ($query) use ($checkInDate, $checkOutDate) {
                $query->whereBetween('check_in_date', [$checkInDate, $checkOutDate])
                    ->orWhereBetween('check_out_date', [$checkInDate, $checkOutDate])
                    ->orWhere(function ($query) use ($checkInDate, $checkOutDate) {
                        $query->where('check_in_date', '<=', $checkInDate)
                            ->where('check_out_date', '>=', $checkOutDate);
                    });
            })
            ->exists();

        throw_if($isOverlapping, new \Exception('room has been booked'));

        return Order::create([
            'bnb_id' => $data['bnb_id'],
            'room_id' => $data['room_id'],
            'currency' => $data['currency'],
            'amount' => CurrencyFacade::toTWD($data['price'], Currency::from($data['currency'])),
            'check_in_date' => $data['check_in_date'],
            'check_out_date' => $data['check_out_date'],
        ]);
    }

}
