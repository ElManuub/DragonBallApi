<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use App\Models\Technique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\TechquineResource;
use Illuminate\Validation\ValidationException;

class TechniqueController extends Controller
{
    public function index(){
        $techniques = Technique::all();

        if($techniques->isEmpty()){
            return response()->json([
                'data' => null,
                'message' => 'No se encontro ninguna tecnica'
            ]);
        }

        return TechquineResource::collection($techniques);
    }

    public function store(Request $request){


        try {
            $request->validate([
                'technique' => 'required|string',
                'power' => 'required|integer',
                'category_id' => 'required|integer|exists:categories,id'
            ]);
    
            $technique = new Technique();
            $technique->technique = $request->technique;
            $technique->power = $request->power;
            $technique->category_id = $request->category_id;
    
            $technique->save();
    
            return new TechquineResource($technique);
        } catch (ValidationException $th) {
            return [
                'data' => null,
                'error' => $th->validator->errors() 
            ];
        } catch (Exception $err){
            return [
                'data' => null,
                'error' => $err->getMessage()
            ];
        }

    }

    public function show($id){
        $technique = Technique::with(['category'])->find($id);

        if (!$technique) {
            return response()->json([
                'error' => 'no existe Técnica'
            ],404);
        }


        return new TechquineResource($technique);
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'technique' => 'required|string',
                'power' => 'required|integer',
                'category_id' => 'required|integer|exists:categories,id'
            ]);


            $techniques = Technique::find($id);

            if (!$techniques) {
                return response()->json([
                    'message' => 'Tecnica no encontrada.',
                    'tecnica' => $techniques
                ], 404);
            }


            $techniques->technique = $request->technique;
            $techniques->power = $request->power;
            $techniques->category_id = $request->category_id;

            $techniques->save();

            // Devolver con técnicas cargadas
            return new TechquineResource($techniques);

        } catch (ValidationException $err) {
            return response()->json([
                'message' => 'Error al validar datos enviados!',
                'error' => $err->validator->errors()
            ], 422);
        } catch (Exception $err) {
            return response()->json([
                'message' => 'Error al editar personaje!',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    public function destroy($id){
        try {
            $technique = Technique::find($id);

            if(!$technique){
                return response()->json([
                    'data' => [],
                    'message' => 'Técnica no encontrada'
                ],404);
            }

            $technique->delete();
    
            return response()->json([
                'data' => $technique,
                'message' => 'Técnica eliminada con exito!'
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
