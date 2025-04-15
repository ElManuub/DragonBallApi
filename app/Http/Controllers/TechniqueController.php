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
}
