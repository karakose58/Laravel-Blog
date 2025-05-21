<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
    public function Category($categoryName)
    {
        $category = Category::where('name', $categoryName)
                            ->where('status', 1) //kategori ile post çağırma
                            ->with('posts')  
                            ->firstOrFail();
            
        return response()->json($category->posts);
    }
    
    



public function ListCategory() //kategorileri listeleme
{
    $categories = Category::where('status', 1)->with(['posts' => function ($query) {
        $query->where('status', 1);
    }])->get();

    return response()->json($categories);
}
}
