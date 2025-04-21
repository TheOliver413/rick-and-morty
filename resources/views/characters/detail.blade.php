@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('characters.index') }}"><i class="fas fa-home"></i> Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detalle del Personaje</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="position-relative">
                    <img src="{{ $character['image'] }}" alt="{{ $character['name'] }}" class="card-img-top img-fluid">
                    <div class="position-absolute bottom-0 start-0 w-100 p-3 bg-dark bg-opacity-75 text-white">
                        <h3 class="mb-0 fw-bold">{{ $character['name'] }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center gap-2 mb-4">
                        @if($character['status'] == 'Alive')
                            <span class="badge bg-success fs-6 px-3 py-2"><i class="fas fa-heartbeat me-1"></i> {{ $character['status'] }}</span>
                        @elseif($character['status'] == 'Dead')
                            <span class="badge bg-danger fs-6 px-3 py-2"><i class="fas fa-skull me-1"></i> {{ $character['status'] }}</span>
                        @else
                            <span class="badge bg-secondary fs-6 px-3 py-2"><i class="fas fa-question me-1"></i> {{ $character['status'] }}</span>
                        @endif

                        <span class="badge bg-primary fs-6 px-3 py-2">
                            @if($character['species'] == 'Human')
                                <i class="fas fa-user me-1"></i>
                            @elseif($character['species'] == 'Alien')
                                <i class="fas fa-user-astronaut me-1"></i>
                            @elseif($character['species'] == 'Robot')
                                <i class="fas fa-robot me-1"></i>
                            @else
                                <i class="fas fa-dna me-1"></i>
                            @endif
                            {{ $character['species'] }}
                        </span>

                        <span class="badge bg-info fs-6 px-3 py-2">
                            @if($character['gender'] == 'Male')
                                <i class="fas fa-mars me-1"></i>
                            @elseif($character['gender'] == 'Female')
                                <i class="fas fa-venus me-1"></i>
                            @else
                                <i class="fas fa-genderless me-1"></i>
                            @endif
                            {{ $character['gender'] }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-dark text-white py-3">
                    <h4 class="mb-0"><i class="fas fa-info-circle me-2"></i>Información del Personaje</h4>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="info-card p-3 border rounded-3 h-100">
                                <h5 class="border-bottom pb-2 mb-3"><i class="fas fa-dna me-2 text-primary"></i>Especie</h5>
                                <p class="fs-5 mb-0">{{ $character['species'] }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-card p-3 border rounded-3 h-100">
                                <h5 class="border-bottom pb-2 mb-3"><i class="fas fa-venus-mars me-2 text-primary"></i>Género</h5>
                                <p class="fs-5 mb-0">{{ $character['gender'] }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-card p-3 border rounded-3 h-100">
                                <h5 class="border-bottom pb-2 mb-3"><i class="fas fa-fingerprint me-2 text-primary"></i>Tipo</h5>
                                <p class="fs-5 mb-0">{{ $character['type'] ? $character['type'] : 'No especificado' }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-card p-3 border rounded-3 h-100">
                                <h5 class="border-bottom pb-2 mb-3"><i class="fas fa-globe me-2 text-primary"></i>Origen</h5>
                                <p class="fs-5 mb-0">{{ $character['origin']['name'] }}</p>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="info-card p-3 border rounded-3">
                                <h5 class="border-bottom pb-2 mb-3"><i class="fas fa-map-marker-alt me-2 text-primary"></i>Ubicación</h5>
                                <p class="fs-5 mb-0">{{ $character['location']['name'] ?? 'Desconocida' }}</p>
                            </div>
                        </div>

                        @if(!empty($character['episode']) && is_array($character['episode']))
                        <div class="col-12">
                            <div class="info-card p-3 border rounded-3">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="fas fa-film me-2 text-primary"></i>Apariciones
                                    <span class="badge bg-secondary ms-2">{{ count($character['episode']) }}</span>
                                </h5>
                                <div class="episodes-container">
                                    <div class="row g-2">
                                        @foreach(array_slice($character['episode'], 0, 8) as $episode)
                                            @php
                                                $episodeNumber = intval(substr($episode, strrpos($episode, '/') + 1));
                                            @endphp
                                            <div class="col-md-3 col-6">
                                                <span class="badge bg-light text-dark p-2 w-100 text-center">
                                                    Episodio {{ $episodeNumber }}
                                                </span>
                                            </div>
                                        @endforeach

                                        @if(count($character['episode']) > 8)
                                            <div class="col-md-3 col-6">
                                                <span class="badge bg-primary p-2 w-100 text-center">
                                                    +{{ count($character['episode']) - 8 }} más
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-footer bg-light p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('characters.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Volver a la lista
                        </a>

                        <div>
                            @if(isset($character['id']))
                                <a href="https://rickandmortyapi.com/api/character/{{ $character['id'] }}" target="_blank" class="btn btn-outline-info">
                                    <i class="fas fa-code me-2"></i>Ver API
                                </a>
                            @endif

                            @if(isset($character['id']) && \App\Models\Character::find($character['id']))
                                <a href="{{ route('characters.edit', $character['id']) }}" class="btn btn-primary ms-2">
                                    <i class="fas fa-edit me-2"></i>Editar
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .rounded-4 {
        border-radius: 0.75rem;
    }

    .info-card {
        transition: all 0.3s ease;
    }

    .info-card:hover {
        background-color: rgba(0, 123, 255, 0.05);
        transform: translateY(-2px);
    }

    .hover-card {
        transition: all 0.3s ease;
    }

    .hover-card:hover {
        transform: translateY(-5px);
    }

    .episodes-container {
        max-height: 150px;
        overflow-y: auto;
    }
</style>
@endsection
