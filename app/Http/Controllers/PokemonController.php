<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pokemon;
use App\Models\Api;

class PokemonController extends Controller
{
    public function __invoke(Request $request)
    {
        $params = $request->all();

        $pokemon = new Pokemon(); //pokemonList
        $api = new Api($pokemon->pokemonList, $params);

        $pokemons = $api->getPokemonList();

        $params = http_build_query($api->apiParams);
        $params = str_replace('%5B','[',$params);
        $params = str_replace('%5D',']',$params);

        $pagination = $api->pagination;

        return view('pokemon', compact('pokemons', 'params', 'pagination'));
    }
}