<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        return Category::create($request->only('name'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $category->update($request->only('name'));

        return response()->json(['message' => 'Categoría actualizada']);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
