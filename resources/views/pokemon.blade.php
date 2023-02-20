@extends('layout')

@section('content')
    <div class="bg-gray-100">
            <h1>Pokemon World</h1>
            <a class="btn btn-outline-dark" href="\pokemon?hp[gte]=50">HP >= 50</a>
            <a class="btn btn-outline-dark" href="\pokemon?hp[gte]=100">HP >= 100</a>
            <a class="btn btn-outline-dark" href="\pokemon?hp[gte]=100&attack[lte]=100">HP >= 100 & AT <= 100</a>
            <a class="btn btn-outline-dark" href="\pokemon?hp[gte]=150&speed[lte]=150">HP >= 150 & SP <= 150</a>
            <a class="btn btn-outline-dark" href="\pokemon?hp[gte]=250&defense[lte]=250">HP >= 250 & DF <= 250</a>
    </div>

    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href="./pokemon?{{$params}}&page={{$pagination['previous']}}">Previous</a>
            </li>

            @if($pagination['last'] < 11)
                @for ($page = 1; $page <= $pagination['last']; $page++)
                    <li class="page-item">
                        <a class="page-link" href="./pokemon?{{$params}}&page={{$page}}">{{$page}}</a>
                    </li>
                @endfor
            @else
                @if($pagination['current'] > $pagination['first'] + 5)
                    <li class="page-item">
                        <a class="page-link" href="./pokemon?{{$params}}&page={{$pagination['first']}}">{{$pagination['first']}}</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="./pokemon?{{$params}}&page={{$pagination['min'] - 1}}">...</a>
                    </li>
                @endif

                @for ($page = $pagination['min']; $page < $pagination['current']; $page++)
                    <li class="page-item">
                        <a class="page-link" href="./pokemon?{{$params}}&page={{$page}}">{{$page}}</a>
                    </li>
                @endfor

                <li class="page-item">
                    <strong><a class="page-link" href="./pokemon?{{$params}}&page={{$pagination['current']}}">{{$pagination['current']}}</a></strong>
                </li>

                @for ($page = $pagination['current'] + 1; $page < $pagination['max']; $page++)
                    <li class="page-item">
                        <a class="page-link" href="./pokemon?{{$params}}&page={{$page}}">{{$page}}</a>
                    </li>
                @endfor

                @if($pagination['current'] < $pagination['last'] - 5)
                    <li class="page-item">
                        <a class="page-link" href="./pokemon?{{$params}}&page={{$pagination['max']}}">...</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="./pokemon?{{$params}}&page={{$pagination['last']}}">{{$pagination['last']}}</a>
                    </li>
                @endif
            @endif

            <li class="page-item">
                    <a class="page-link" href="./pokemon?{{$params}}&page={{$pagination['next']}}">Next</a>
            </li>
        </ul>
    </nav>

    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-400 sm:items-center py-4 sm:pt-0">

        <table class="table table-striped table-bordered table-sm" cellspacing="0" width="100%" id="pokemon-table">
            <thead class="thead-dark">
                <tr>
                    @foreach ($pokemons[0] as $key => $pokemon)
                        <th scope="col">{{$key}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($pokemons as $key => $pokemon)
                    <tr>
                        @foreach ($pokemon as $key => $value)
                            <td scope="col">{{ $pokemon[$key] }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection