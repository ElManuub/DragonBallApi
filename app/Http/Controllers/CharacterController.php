<?php

namespace App\Http\Controllers;

use App\Http\Resources\CharactersResource;
use App\Models\Character;
use App\Models\Technique;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CharacterController extends Controller
{
    public function index()
    {
        $characters = Character::with('techniques.category')->get();

        if ($characters->isEmpty()) {
            return response()->json([
                'data' => [],
                'message' => 'No hay ningún personaje registrado'
            ], 200);
        }

        return CharactersResource::collection($characters);
    }

    public function store(Request $request)
    {
        try {
            // Validación
            $validated = $request->validate(
                [
                    'name' => 'required',
                    'age' => 'required|integer',
                    'breed' => 'required',
                    'power' => 'required|max:1000000',
                    'character_type' => 'required|in:good,bad',
                    'techniques' => 'required|array',
                    'techniques.*' => 'integer|exists:techniques,id',
                ],
                ['techniques.*.exists' => 'Tecnica no existe']
            );

            // Crear y guardar personaje
            $character = Character::create([
                'name' => $request->name,
                'age' => $request->age,
                'breed' => $request->breed,
                'power' => $request->power,
                'character_type' => $request->character_type,
            ]);

            // Asociar técnicas
            $character->techniques()->sync($request->techniques);

            // Devolver con técnicas cargadas
            return new CharactersResource($character->load('techniques.category'));
        } catch (ValidationException $err) {
            return response()->json([
                'message' => 'Error al validar datos enviados!',
                'error' => $err->validator->errors()
            ], 422);
        } catch (Exception $err) {
            return response()->json([
                'message' => 'Error al crear personaje!',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $character = Character::with(['techniques.category'])->find($id);

        if (!$character) {
            return response()->json([
                'error' => 'no existe personaje'
            ], 404);
        }


        return new CharactersResource($character);
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate(
                [
                    'name' => 'required',
                    'age' => 'required|integer',
                    'breed' => 'required',
                    'power' => 'required|max:1000000',
                    'character_type' => 'required|in:good,bad',
                    'techniques' => 'required|array',
                    'techniques.*' => 'integer|exists:techniques,id',
                ],
                ['techniques.*.exists' => 'Tecnica no existe']
            );


            $character = Character::find($id);

            if (!$character) {
                return response()->json([
                    'message' => 'Personaje no encontrado.',
                    'personaje' => $character
                ], 404);
            }


            $character->name = $request->name;
            $character->age = $request->age;
            $character->breed = $request->breed;
            $character->power = $request->power;
            $character->character_type = $request->character_type;

            $character->save();

            // Asociar técnicas
            $character->techniques()->sync($request->techniques);

            // Devolver con técnicas cargadas
            return new CharactersResource($character->load('techniques.category'));
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

    public function destroy($id)
    {

        try {
            $character = Character::find($id);

            if (!$character) {
                return response()->json([
                    'data' => [],
                    'message' => 'Personaje no encontrado'
                ], 404);
            }

            $character->delete();

            return response()->json([
                'data' => $character,
                'message' => 'personaje eliminado con exito!'
            ], 200);
        } catch (Exception $th) {
            return response()->json([
                'data' => [],
                'message' => 'Ocurrio un error',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
