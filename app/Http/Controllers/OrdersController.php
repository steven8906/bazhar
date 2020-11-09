<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use App\Models\{Orders,Product};

class OrdersController extends Controller
{
    public function index(){
        $products = DB::table('products AS a')                    
                    ->join('presentations AS b','b.id','=','a.id_presentation')
                    ->select('a.*','b.name as presentation')
                    ->get();                  

        return Inertia::render('Orders/index',[
            'products' => $products,

        ]);
    }
}