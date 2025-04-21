@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-5 fw-bold text-primary">
                <i class="fas fa-users me-2"></i>Personajes de Rick and Morty
            </h1>
            <p class="text-muted lead">Explora los personajes del universo de Rick and Morty</p>
        </div>
        <div class="col-md-4 d-flex align-items-center justify-content-md-end mt-3 mt-md-0">
            <form action="{{ route('characters.store') }}" method="POST">
                @csrf
                <button class="btn btn-success btn-lg shadow-sm">
                    <i class="fas fa-save me-2"></i>Guardar en Base de Datos
                </button>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
        <div class="card-header bg-dark text-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0"><i class="fas fa-table me-2"></i>Lista de Personajes</h5>
                </div>
                <div class="col-auto">
                    <span class="badge bg-primary rounded-pill">{{ count($characters) }} personajes</span>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">#ID</th>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Especie</th>
                        <th class="text-center">Imagen</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($characters as $char)
                        <tr>
                            <td class="text-center fw-bold">{{ $char['id'] }}</td>
                            <td class="fw-medium">{{ $char['name'] }}</td>
                            <td>
                                @if($char['status'] == 'Alive')
                                    <span class="badge bg-success">{{ $char['status'] }}</span>
                                @elseif($char['status'] == 'Dead')
                                    <span class="badge bg-danger">{{ $char['status'] }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $char['status'] }}</span>
                                @endif
                            </td>
                            <td>{{ $char['species'] }}</td>
                            <td class="text-center">
                                <img src="{{ $char['image'] }}" class="rounded-circle border shadow-sm" width="60" height="60" alt="{{ $char['name'] }}">
                            </td>
                            <td class="text-center">
                                <a href="{{ route('characters.detail', $char['id']) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i>Ver Detalle
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center mt-4 text-muted">
        <small>Datos obtenidos de la API oficial de Rick and Morty</small>
    </div>
</div>
@endsection

@section('styles')
<style>
    .table th {
        justify-content: center;
        font-weight: 600;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
</style>
@endsection
