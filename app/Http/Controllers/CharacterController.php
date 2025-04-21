<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Character;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    public function index()
    {
        try {
            $response = Http::get('https://rickandmortyapi.com/api/character', ['page' => 1]);

            if (!$response->successful()) {
                return back()->withErrors(['error' => 'No se pudo conectar con la API.']);
            }

            $results = $response->json()['results'];

            for ($i = 2; count($results) < 100; $i++) {
                $page = Http::get("https://rickandmortyapi.com/api/character?page=$i");

                if (!$page->successful()) break;

                $results = array_merge($results, $page->json()['results']);
            }

            $characters = array_slice($results, 0, 100);

            return view('characters.index', compact('characters'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }

    public function store()
    {
        try {
            $results = [];

            $response = Http::get('https://rickandmortyapi.com/api/character', ['page' => 1]);

            if (!$response->successful() || !isset($response['results'])) {
                return back()->withErrors(['error' => 'No se pudo obtener datos de la API.']);
            }

            $results = $response['results'];

            for ($i = 2; count($results) < 100; $i++) {
                $response = Http::get("https://rickandmortyapi.com/api/character", ['page' => $i]);

                if (!$response->successful() || !isset($response['results'])) {
                    break;
                }

                $results = array_merge($results, $response['results']);
            }

            $characters = array_slice($results, 0, 100);

            foreach ($characters as $char) {
                Character::updateOrCreate(
                    ['id' => $char['id']],
                    [
                        'name' => $char['name'],
                        'status' => $char['status'],
                        'species' => $char['species'],
                        'type' => $char['type'],
                        'gender' => $char['gender'],
                        'origin_name' => $char['origin']['name'],
                        'origin_url' => $char['origin']['url'],
                        'image' => $char['image'],
                    ]
                );
            }

            return redirect()->route('characters.saved')->with('success', 'Personajes guardados correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al guardar personajes: ' . $e->getMessage()]);
        }
    }

    public function saved()
    {
        try {
            $characters = Character::paginate(15);
            return view('characters.saved', compact('characters'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al cargar los personajes guardados: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        try {
            $character = Character::findOrFail($id);
            return view('characters.edit', compact('character'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('characters.saved')->withErrors(['error' => 'Personaje no encontrado.']);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al cargar el personaje: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $character = Character::findOrFail($id);
            $character->update($request->all());
            return redirect()->route('characters.saved')->with('success', 'Personaje actualizado correctamente.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('characters.saved')->withErrors(['error' => 'Personaje no encontrado.']);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al actualizar el personaje: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $response = Http::get("https://rickandmortyapi.com/api/character/$id");

            if (!$response->successful()) {
                return back()->withErrors(['error' => 'No se pudo obtener la información del personaje.']);
            }

            $character = $response->json();

            return view('characters.detail', compact('character'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al mostrar el personaje: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $character = Character::findOrFail($id);
            $character->delete();

            Cache::forget('saved_characters');

            return redirect()->route('characters.saved')->with('success', 'Personaje eliminado correctamente.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('characters.saved')->withErrors(['error' => 'Personaje no encontrado.']);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al eliminar el personaje: ' . $e->getMessage()]);
        }
    }
}
