<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Panel de Docente</h2>
    <div>
        <span class="me-3">Bienvenido, <?= htmlspecialchars($username) ?></span>
        <a href="?controller=auth&action=logout" class="btn btn-outline-danger btn-sm">Cerrar Sesión</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Mis Estudiantes</h5>
                <p class="card-text">Ver lista de estudiantes asignados</p>
                <a href="?controller=docente&action=estudiantes" class="btn btn-primary">Ver Estudiantes</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Registrar Notas</h5>
                <p class="card-text">Ingresar calificaciones de estudiantes</p>
                <a href="?controller=notas&action=create" class="btn btn-success">Nueva Nota</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Mis Notas</h5>
                <p class="card-text">Ver notas que he registrado</p>
                <a href="?controller=docente&action=notas" class="btn btn-info">Ver Mis Notas</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Mis Materias</h5>
                <p class="card-text">Materias que imparto</p>
                <a href="?controller=docente&action=materias" class="btn btn-warning">Ver Materias</a>
            </div>
        </div>
    </div>
</div>