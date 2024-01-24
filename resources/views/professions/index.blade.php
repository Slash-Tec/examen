@extends('layout')

@section('title', 'Profesiones')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-3">
        <h1 class="pb-1">Listado de profesiones</h1>
    </div>

    @if($professions->isNotEmpty())
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Título</th>
                <th scope="col">Nivel de educación</th>
                <th scope="col">Salario</th>
                <th scope="col">Experiencia Requerida</th>
                <th scope="col">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($professions as $profession)
                <tr>
                    <td scope="row">{{ $profession->id }}</td>
                    <td>{{ $profession->title }}</td>
                    <td>{{ $profession->education_level }}</td>
                    <td>{{ $profession->salary }}</td>
                    <td>
                        @foreach($profession->skills as $skill)
                            {{ $skill->name }}
                            @if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </td>
                    <td>
                        @if($profession->profiles_count == 0)
                            <form action="{{ url('profesiones/' . $profession->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link"><span
                                            class="material-symbols-outlined">delete</span>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $professions->links() }}
    @else
        <p>No hay profesiones registradas</p>
    @endif
@endsection
