<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\{Product,Providers,Taxes,Presentation,Business};

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Product/index',[
            'products'=>Product::all(),
            'providers'=>Providers::all(),
            'taxes'=>Taxes::all(),
            'business'=>Business::all(),
            'presentations'=>Presentation::all()
        ]);
    }

    public function newProduct()
    {
        return Inertia::render('Product/new_product',[
            'products'=>Product::all(),
            'providers'=>Providers::all(),
            'taxes'=>Taxes::all(),
            'business'=>Business::all(),
            'presentations'=>Presentation::all()
        ]);
    }

    public function new(Request $request)
    {
        $product = new Product();
        $product->create($request->all());
        return $product->all();
    }
}
