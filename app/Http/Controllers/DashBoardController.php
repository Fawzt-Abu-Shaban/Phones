<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    public function showDashBoard()
    {

        $productCount = Product::count();
        $userCount = User::count();
        $order = Order::with('cart')->paginate(6);

        return response()->view('cms.dashboard', compact('productCount', 'userCount', 'order'));
    }
}
