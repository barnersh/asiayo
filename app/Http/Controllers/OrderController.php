<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderPostRequest;
use App\Utils\OrderFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function store(OrderPostRequest $request)
    {
        $data = $request->validated();

        try {
            $order = OrderFacade::createOrder($data);
            return response()->json($order, 201);
        } catch (\Exception $e) {
            Log::error('create order error', [
                'message' => $e->getMessage()
            ]);

            abort(400, $e->getMessage());
        }
    }
}
