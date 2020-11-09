<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\{Providers,Business};

class ProvidersController extends Controller
{
    public function index()
    {   
        return Inertia::render('Providers/index',[
            'providers'=>Providers::all(),
            'business' =>Business::all()
            ]);
    }

    public function new(Request $request)
    {
        $providers = new Providers();
        $providers->create($request->all());
        return $providers->all();
    }
}
