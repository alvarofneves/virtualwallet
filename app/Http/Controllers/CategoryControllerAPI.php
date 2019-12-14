<?php

namespace App\Http\Controllers;

use App\Http\Resources\Category as CategoryResource;

use Illuminate\Http\Request;
use App\Category;

class CategoryControllerAPI extends Controller
{
    //
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }
}
