@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('characters.index') }}"><i class="fas fa-home"></i> Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('characters.saved') }}"><i class="fas fa-database"></i> Personajes Guardados</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar Personaje</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-dark text-white py-3">
                    <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Editar Personaje</h4>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('characters.update', $character->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $character->name) }}" placeholder="Nombre">
                                    <label for="name">Nombre</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select name="status" class="form-select @error('status') is-invalid @enderror" id="status">
                                        <option value="Alive" {{ old('status', $character->status) == 'Alive' ? 'selected' : '' }}>Vivo</option>
                                        <option value="Dead" {{ old('status', $character->status) == 'Dead' ? 'selected' : '' }}>Muerto</option>
                                        <option value="unknown" {{ old('status', $character->status) == 'unknown' ? 'selected' : '' }}>Desconocido</option>
                                    </select>
                                    <label for="status">Estado</label>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" name="species" class="form-control @error('species') is-invalid @enderror" id="species" value="{{ old('species', $character->species) }}" placeholder="Especie">
                                    <label for="species">Especie</label>
                                    @error('species')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select name="gender" class="form-select @error('gender') is-invalid @enderror" id="gender">
                                        <option value="Male" {{ old('gender', $character->gender) == 'Male' ? 'selected' : '' }}>Masculino</option>
                                        <option value="Female" {{ old('gender', $character->gender) == 'Female' ? 'selected' : '' }}>Femenino</option>
                                        <option value="Genderless" {{ old('gender', $character->gender) == 'Genderless' ? 'selected' : '' }}>Sin género</option>
                                        <option value="unknown" {{ old('gender', $character->gender) == 'unknown' ? 'selected' : '' }}>Desconocido</option>
                                    </select>
                                    <label for="gender">Género</label>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" name="type" class="form-control @error('type') is-invalid @enderror" id="type" value="{{ old('type', $character->type) }}" placeholder="Tipo">
                                    <label for="type">Tipo</label>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" name="origin_name" class="form-control @error('origin_name') is-invalid @enderror" id="origin_name" value="{{ old('origin_name', $character->origin_name) }}" placeholder="Origen">
                                    <label for="origin_name">Origen</label>
                                    @error('origin_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="url" name="image" class="form-control @error('image') is-invalid @enderror" id="image" value="{{ old('image', $character->image) }}" placeholder="URL de la imagen">
                                    <label for="image">URL de la imagen</label>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('characters.saved') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-save me-2"></i>Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden sticky-lg-top" style="top: 2rem;">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-eye me-2"></i>Vista Previa</h5>
                </div>
                <div class="card-body p-0">
                    <div class="position-relative">
                        <img src="{{ $character->image }}" alt="{{ $character->name }}" class="img-fluid w-100" id="preview-image">
                        <div class="position-absolute bottom-0 start-0 w-100 p-3 bg-dark bg-opacity-75 text-white">
                            <h5 class="mb-0 fw-bold" id="preview-name">{{ $character->name }}</h5>
                        </div>
                    </div>
                    <div class="p-3">
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <span class="badge bg-success fs-6 px-3 py-2" id="preview-status">
                                <i class="fas fa-heartbeat me-1"></i> {{ $character->status }}
                            </span>
                            <span class="badge bg-primary fs-6 px-3 py-2" id="preview-species">
                                <i class="fas fa-dna me-1"></i> {{ $character->species }}
                            </span>
                        </div>

                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="text-muted"><i class="fas fa-venus-mars me-2"></i>Género:</span>
                                <span class="fw-medium" id="preview-gender">{{ $character->gender }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="text-muted"><i class="fas fa-fingerprint me-2"></i>Tipo:</span>
                                <span class="fw-medium" id="preview-type">{{ $character->type ?: 'No especificado' }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="text-muted"><i class="fas fa-globe me-2"></i>Origen:</span>
                                <span class="fw-medium" id="preview-origin">{{ $character->origin_name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Actualizar vista previa en tiempo real
        const nameInput = document.getElementById('name');
        const statusSelect = document.getElementById('status');
        const speciesInput = document.getElementById('species');
        const typeInput = document.getElementById('type');
        const genderSelect = document.getElementById('gender');
        const originInput = document.getElementById('origin_name');
        const imageInput = document.getElementById('image');

        // Elementos de vista previa
        const previewName = document.getElementById('preview-name');
        const previewStatus = document.getElementById('preview-status');
        const previewSpecies = document.getElementById('preview-species');
        const previewType = document.getElementById('preview-type');
        const previewGender = document.getElementById('preview-gender');
        const previewOrigin = document.getElementById('preview-origin');
        const previewImage = document.getElementById('preview-image');

        // Actualizar nombre
        nameInput.addEventListener('input', function() {
            previewName.textContent = this.value || '{{ $character->name }}';
        });

        // Actualizar estado
        statusSelect.addEventListener('change', function() {
            previewStatus.textContent = this.value;

            // Cambiar color del badge según el estado
            if (this.value === 'Alive') {
                previewStatus.className = 'badge bg-success fs-6 px-3 py-2';
                previewStatus.innerHTML = '<i class="fas fa-heartbeat me-1"></i> ' + this.value;
            } else if (this.value === 'Dead') {
                previewStatus.className = 'badge bg-danger fs-6 px-3 py-2';
                previewStatus.innerHTML = '<i class="fas fa-skull me-1"></i> ' + this.value;
            } else {
                previewStatus.className = 'badge bg-secondary fs-6 px-3 py-2';
                previewStatus.innerHTML = '<i class="fas fa-question me-1"></i> ' + this.value;
            }
        });

        // Actualizar especie
        speciesInput.addEventListener('input', function() {
            previewSpecies.textContent = this.value || '{{ $character->species }}';
        });

        // Actualizar tipo
        typeInput.addEventListener('input', function() {
            previewType.textContent = this.value || 'No especificado';
        });

        // Actualizar género
        genderSelect.addEventListener('change', function() {
            previewGender.textContent = this.value;
        });

        // Actualizar origen
        originInput.addEventListener('input', function() {
            previewOrigin.textContent = this.value || '{{ $character->origin_name }}';
        });

        // Actualizar imagen
        imageInput.addEventListener('input', function() {
            if (this.value && isValidUrl(this.value)) {
                previewImage.src = this.value;
            }
        });

        // Validar URL
        function isValidUrl(string) {
            try {
                new URL(string);
                return true;
            } catch (_) {
                return false;
            }
        }
    });
</script>
@endsection

@section('styles')
<style>
    .rounded-4 {
        border-radius: 0.75rem;
    }

    .form-floating > .form-control,
    .form-floating > .form-select {
        height: calc(3.5rem + 2px);
        line-height: 1.25;
    }

    .form-floating > label {
        padding: 1rem 0.75rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
</style>
@endsection
