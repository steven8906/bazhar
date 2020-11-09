<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\{SalesMedium};

class SalesMediumController extends Controller
{
    public function index()
    {
       return Inertia::render('SalesMediums/index',['salesMediums'=>SalesMedium::all()]);
    }

    public function new(Request $request)
    {
        $mediums = new SalesMedium();
        $mediums->create($request->all());
        return $mediums->all();

    }
}
