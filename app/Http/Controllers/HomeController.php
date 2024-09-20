<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;
use App\Orders;
use App\Models\Role;
use App\Models\Permission;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Products::all();
        $orders = Orders::all();
        $roles = Role::all();
        $permissions = Permission::all();

        return view('layouts.dashboard', compact('products', 'orders', 'roles', 'permissions'));
    }
}
