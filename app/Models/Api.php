<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    public array $apiQueries;
    public array $apiFields;
    public array $pokemonList;
    public array $pagination;
    public int   $countPages = 1;
    public const POKEMONS_PER_PAGE = 10;

    public function __construct($pokemonList, $apiParams)
    {
        if(!empty($apiParams['page'])) {
            $page = $apiParams['page'];
            unset($apiParams['page']);
        } else {
            $page = 1;
        }

        $this->apiParams = $apiParams;
        $this->pokemonList = $pokemonList;

        $this->applyApiParams();
        $this->applyPagination($page);
    }

    private function applyApiParams()
    {
        foreach($this->pokemonList as $index => $pokemon) { 
            foreach($this->apiParams as $paramName => $param) {
                if(is_array($param)) {
                    $paramType = key($param); 

                    if($paramType === 'gte') {
                        if($pokemon[$paramName] < $param[$paramType]) {
                            unset($this->pokemonList[$index]);
                        } 
                    } elseif($paramType === 'lte') {
                        if($pokemon[$paramName] > $param[$paramType]) {
                            unset($this->pokemonList[$index]);
                        } 
                    }
                } else {
                    if($pokemon[$paramName] != $param) {
                        unset($this->pokemonList[$index]);
                    } 
                }
            }
        }
        sort($this->pokemonList);
    }
    
    private function applyPagination(int $page)
    {
        $pagination['current'] = $page ?? 1;
        $pagination['count'] = count($this->pokemonList);
        $pagination['per_page'] = self::POKEMONS_PER_PAGE;
        $pagination['first'] = 1;
        $pagination['last'] = ceil($pagination['count'] / self::POKEMONS_PER_PAGE);

        if ($page > $pagination['first'] + 5) {
            $pagination['min'] = $page - 5;    
        } else {
            $pagination['min'] =  $pagination['first'];   
        }

        if ($page < $pagination['last'] - 5) {
            $pagination['max'] = $page + 5;
        } else {
            $pagination['max'] = $pagination['last'];
        }
        
        ($page > 1) ? $pagination['previous'] = $page - 1 : $pagination['previous'] = $page;    
        ($page < $pagination['last']) ? $pagination['next'] = $page + 1 : $pagination['next'] = $page;  

        $this->pagination = $pagination;
        $this->pokemonList = array_chunk($this->pokemonList, self::POKEMONS_PER_PAGE);
        $this->countPages = count($this->pokemonList);
    }

    public function getPokemonList()
    {
        return $this->pokemonList[$this->pagination['current'] - 1];
    }
}