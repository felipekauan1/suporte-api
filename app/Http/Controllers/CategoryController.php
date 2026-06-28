<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return response()->json(['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $category = Category::create(['name' => $request->input('name')]);

        return response()->json(['category' => $category], 201);
    }
}
