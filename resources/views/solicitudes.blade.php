<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Soporte Técnico - Hito 3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
<div class="container">
    <h2 class="mb-4 text-center">Sistema de Registro y Control de Solicitudes de Soporte Técnico</h2>

    <!-- Mensajes de confirmación o error -->
    @if(session('exito'))
        <div class="alert alert-success">{{ session('exito') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <!-- 3.1 Formulario de Registro -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">Nueva Solicitud</div>
                <div class="card-body">
                    <form action="{{ route('solicitudes.store') }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Solicitante:</label>
                            <input type="text" name="solicitante" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Departamento:</label>
                            <input type="text" name="departamento" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Descripción del problema:</label>
                            <textarea name="descripcion" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prioridad:</label>
                            <select name="prioridad" class="form-select" required>
                                <option value="Baja">Baja</option>
                                <option value="Media">Media</option>
                                <option value="Alta">Alta</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Registrar Solicitud</button>
                    </form>
                </div>
            </div>

            <!-- 3.4 Botón de Envío a Red Local -->
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">Sincronización Red Local</div>
                <div class="card-body text-center">
                    <p class="small text-muted">Envía los registros locales a la BD MySQL del docente (Upsert).</p>
                    <form action="{{ route('solicitudes.sincronizar') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning w-100 fw-bold">
                            Enviar Datos a BD Destino
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- 3.2 Listado y 3.3 Actualización de Estado -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">Listado de Solicitudes (BD Local)</div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Solicitante</th>
                                <th>Departamento</th>
                                <th>Descripción</th>
                                <th>Prioridad</th>
                                <th>Estado</th>
                                <th>Fecha Registro</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($solicitudes as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->solicitante }}</td>
                                    <td>{{ $item->departamento }}</td>
                                    <td>{{ $item->descripcion }}</td>
                                    <td>{{ $item->prioridad }}</td>
                                    <td>
                                        <form action="{{ route('solicitudes.updateEstado', $item->id) }}" method="POST" class="d-flex gap-1">
                                            @csrf
                                            @method('PATCH')
                                            <select name="estado" class="form-select form-select-sm">
                                                <option value="Pendiente" {{ $item->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                                <option value="En proceso" {{ $item->estado == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                                                <option value="Resuelta" {{ $item->estado == 'Resuelta' ? 'selected' : '' }}>Resuelta</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-success">Guardar</button>
                                        </form>
                                    </td>
                                    <td>{{ $item->created_at }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No hay solicitudes registradas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>