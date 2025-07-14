<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        // Aquí podrías pasar marcas desde la base de datos si lo deseas
        return view('brands.index');
    }
}
