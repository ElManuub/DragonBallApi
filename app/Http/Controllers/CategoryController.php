<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();

        return CategoryResource::collection($category);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'description' => 'required|string'
            ]);

            $category = new Category();
            $category->name = $request->name;
            $category->description = $request->description;

            $category->save();

            return new CategoryResource($category);
        } catch (ValidationException $err) {

            return response()->json([
                'message' => 'Error al validar datos enviados!',
                'error' => $err->validator->errors()
            ], 422);
        } catch (Exception $err) {

            return response()->json([
                'message' => 'Error al crear categoria!',
                'error' => $err->getMessage()
            ], 500);
        }
    }
}
