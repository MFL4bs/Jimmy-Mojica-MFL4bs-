<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Panel de Administrador</h2>
    <div>
        <span class="me-3">Bienvenido, <?= htmlspecialchars($username) ?></span>
        <a href="?controller=auth&action=logout" class="btn btn-outline-danger btn-sm">Cerrar Sesión</a>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Gestión de Usuarios</h5>
                <p class="card-text">Crear y administrar usuarios del sistema</p>
                <a href="?controller=auth&action=register" class="btn btn-primary">Registrar Usuario</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Estudiantes</h5>
                <p class="card-text">Administrar información de estudiantes</p>
                <a href="?controller=estudiantes" class="btn btn-success">Ver Estudiantes</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Materias</h5>
                <p class="card-text">Gestionar materias del colegio</p>
                <a href="?controller=materias" class="btn btn-info">Ver Materias</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Notas</h5>
                <p class="card-text">Supervisar todas las calificaciones</p>
                <a href="?controller=notas" class="btn btn-warning">Ver Notas</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Profesores</h5>
                <p class="card-text">Administrar información de docentes</p>
                <a href="?controller=profesores" class="btn btn-secondary">Ver Profesores</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Reportes</h5>
                <p class="card-text">Generar reportes del sistema</p>
                <a href="?controller=reportes" class="btn btn-dark">Ver Reportes</a>
            </div>
        </div>
    </div>
</div>