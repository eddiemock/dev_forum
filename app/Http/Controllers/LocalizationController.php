<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Middleware\Localization;



class LocalizationController extends Controller
{
    public function index($locale){
        App::setlocale($locale);
        session()->put('locale',$locale);
        // return dd($locale);
        // return dd(session('locale'));
        return redirect()->back();
    }
}
