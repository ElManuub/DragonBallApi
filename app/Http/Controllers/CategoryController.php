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

    public function show($id){
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'error' => 'no existe Categoria'
            ],404);
        }


        return new CategoryResource($category);
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'description' => 'required|string'
            ]);


            $categories = Category::find($id);

            if (!$categories) {
                return response()->json([
                    'message' => 'Categoria no encontrada.',
                    'categoria' => $categories
                ], 404);
            }


            $categories->name = $request->name;
            $categories->description = $request->description;

            $categories->save();

            return new CategoryResource($categories);

        } catch (ValidationException $err) {
            return response()->json([
                'message' => 'Error al validar datos enviados!',
                'error' => $err->validator->errors()
            ], 422);
        } catch (Exception $err) {
            return response()->json([
                'message' => 'Error al editar categoria!',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    public function destroy($id){
        try {
            $category = Category::find($id);

            if(!$category){
                return response()->json([
                    'data' => [],
                    'message' => 'Categoria no encontrada'
                ],404);
            }

            $category->delete();
    
            return response()->json([
                'data' => $category,
                'message' => 'Categoria eliminada con exito!'
            ],200);

        } catch (Exception $th) {
            return response()->json([
                'data' => [],
                'message' => 'Ocurrio un error',
                'error' => $th->getMessage()
            ],500);
        }
    }
}
