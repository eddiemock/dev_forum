<?php
namespace App\Http\Controllers;
use App\Models\Professional;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function index(Request $request)
    {
        $professionals = Professional::all(); // Fetch all professionals

        return view('pages.resources', compact('professionals'));
    }
}
