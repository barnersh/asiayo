<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderPostRequest;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(OrderPostRequest $request)
    {
        $data = $request->validated();
        return response(null);
    }
}
