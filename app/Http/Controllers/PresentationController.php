<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\{Presentation};

class PresentationController extends Controller
{
    public function index()
    {
        return Inertia::render('Presentation/index',['presentations'=> Presentation::all()]);
    }
}
