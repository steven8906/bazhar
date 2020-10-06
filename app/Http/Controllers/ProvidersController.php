<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\{Providers};

class ProvidersController extends Controller
{
    public function index()
    {   
        return Inertia::render('Providers/index',['providers'=>Providers::all()]);
    }
}
