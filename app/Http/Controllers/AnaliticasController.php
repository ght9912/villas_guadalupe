<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Analiticas;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AnaliticasController extends Controller
{
    public function index()
    {


        return view("analiticas");
    }
}
