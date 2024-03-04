<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    

    public function index()
{
    $categories = Category::all(); // Fetch all categories from the database

    return view('pages.index', compact('categories'));
}


    // Store a new category
    public function store(Request $request)
    {
        // Immediately check if a user is authenticated and log their ID
    if (auth()->check()) {
        Log::info('User is logged in', ['user_id' => auth()->id()]);
    } else {
        Log::info('User is not logged in');
        // Consider redirecting the user to login page or handling this case appropriately
    }
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);

        $category = new Category([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        $category->save();

        return redirect()->back()->with('success', 'Category created successfully.');
    }

    // Display a specific category and its discussions
    public function show($categoryId)
{
    $category = Category::findOrFail($categoryId);
    $discussions = $category->discussions()->paginate();
    return view('categories.show', compact('category', 'discussions'));
}


    // Add other methods (edit, update, delete) as needed...
}
