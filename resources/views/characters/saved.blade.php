@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-5 fw-bold text-primary">
                <i class="fas fa-database me-2"></i>Personajes Guardados
            </h1>
            <p class="text-muted lead">Personajes de Rick and Morty almacenados en tu base de datos</p>
        </div>
        <div class="col-md-4 d-flex align-items-center justify-content-md-end mt-3 mt-md-0">
            <a href="{{ route('characters.index') }}" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-sync-alt me-2"></i>Volver a la API
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error') || $errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') ?? $errors->first() }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Vista de tabla -->
    <div class="card shadow-sm border-0 rounded-3 overflow-hidden mb-4">
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
                    @forelse ($characters as $char)
                        <tr class="character-row" data-name="{{ strtolower($char->name) }}" data-species="{{ strtolower($char->species) }}" data-status="{{ strtolower($char->status) }}">
                            <td class="text-center fw-bold">{{ $char->id }}</td>
                            <td class="fw-medium">{{ $char->name }}</td>
                            <td>
                                @if($char->status == 'Alive')
                                    <span class="badge bg-success">{{ $char->status }}</span>
                                @elseif($char->status == 'Dead')
                                    <span class="badge bg-danger">{{ $char->status }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $char->status }}</span>
                                @endif
                            </td>
                            <td>{{ $char->species }}</td>
                            <td class="text-center">
                                <img src="{{ $char->image }}" class="rounded-circle border shadow-sm" width="50" height="50" alt="{{ $char->name }}">
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('characters.edit', $char->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit me-1"></i>Editar
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a href="{{ route('characters.detail', $char->id) }}" class="dropdown-item">
                                                <i class="fas fa-eye me-2"></i>Ver detalle
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        {{-- <li>
                                            <button type="button" class="dropdown-item text-danger delete-btn"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"
                                                data-id="{{ $char->id }}"
                                                data-name="{{ $char->name }}">
                                                <i class="fas fa-trash-alt me-2"></i>Eliminar
                                            </button>
                                        </li> --}}
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-database fa-3x text-muted mb-3"></i>
                                    <h5>No hay personajes guardados</h5>
                                    <p class="text-muted">Guarda personajes desde la API para verlos aquí</p>
                                    <a href="{{ route('characters.index') }}" class="btn btn-primary mt-2">
                                        <i class="fas fa-plus me-2"></i>Ir a la API
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($characters->hasPages())
        <div class="card-footer bg-light py-3">
            <div class="d-flex justify-content-center">
                {!! $characters->links() !!}
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Modal de confirmación de eliminación -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirmar eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar al personaje <strong id="characterName"></strong>?</p>
                <p class="text-muted mb-0">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <form id="deleteForm" action="" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-2"></i>Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Toast de notificación -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-check-circle me-2"></i>
                <span id="successToastMessage">Operación completada con éxito</span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configuración del modal de eliminación
        const deleteModal = document.getElementById('deleteModal');
        const characterName = document.getElementById('characterName');
        const deleteForm = document.getElementById('deleteForm');
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const name = this.dataset.name;

                characterName.textContent = name;
                // Usar la ruta correcta para la eliminación
                deleteForm.action = "{{ route('characters.destroy', ['id' => '__id__']) }}".replace('__id__', id);


                // Para depuración
                console.log("URL de eliminación:", deleteForm.action);
            });
        });

        // Mostrar toast si hay mensaje de éxito
        @if(session('success'))
            const successToast = document.getElementById('successToast');
            const successToastMessage = document.getElementById('successToastMessage');
            successToastMessage.textContent = "{{ session('success') }}";
            const toast = new bootstrap.Toast(successToast);
            toast.show();
        @endif
    });
</script>
@endsection

@section('styles')
<style>
    .dropdown-item:active {
        background-color: #f8f9fa;
        color: inherit;
    }

    .dropdown-item.text-danger:active {
        background-color: #f8d7da;
        color: #dc3545;
    }

    /* Estilos directos para la paginación */
    nav[aria-label="Pagination Navigation"] {
        width: 100%;
    }

    .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        margin: 0;
        padding: 0.5rem;
        background-color: white;
        border-radius: 50px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .pagination li {
        margin: 0 2px;
    }

    .pagination li .page-link,
    .pagination li span.page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 2.5rem;
        height: 2.5rem;
        padding: 0 0.75rem;
        border-radius: 50px;
        border: none;
        color: #6c757d;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .pagination li .page-link:hover {
        background-color: #f8f9fa;
        color: #007bff;
        transform: translateY(-2px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .pagination li.active span.page-link {
        background-color: #007bff;
        color: white;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0, 123, 255, 0.4);
    }

    .pagination li.disabled span.page-link {
        color: #dee2e6;
        background-color: transparent;
        cursor: not-allowed;
    }

    /* Estilos para los iconos de paginación */
    .pagination svg {
        width: 1rem;
        height: 1rem;
    }

    /* Estilos para el texto de paginación */
    .text-sm.text-gray-700.leading-5 {
        display: none;
    }

    /* Estilos para dispositivos móviles */
    @media (max-width: 576px) {
        .pagination {
            flex-wrap: wrap;
            border-radius: 25px;
            padding: 0.25rem;
        }

        .pagination li .page-link,
        .pagination li span.page-link {
            min-width: 2rem;
            height: 2rem;
            padding: 0 0.5rem;
            font-size: 0.875rem;
        }
    }

    /* Estilos para el modal de confirmación */
    .modal-content {
        border: none;
        border-radius: 0.75rem;
        overflow: hidden;
    }

    .modal-header {
        border-bottom: none;
    }

    .modal-footer {
        border-top: none;
    }

    /* Estilos para el toast */
    .toast {
        border-radius: 0.5rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
</style>
@endsection
