<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Panel de Estudiante</h2>
    <div>
        <span class="me-3">Bienvenido, <?= htmlspecialchars($username) ?></span>
        <a href="?controller=auth&action=logout" class="btn btn-outline-danger btn-sm">Cerrar Sesión</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Mis Notas</h5>
                <p class="card-text">Ver todas mis calificaciones</p>
                <a href="?controller=estudiante&action=notas" class="btn btn-primary">Ver Notas</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Mis Materias</h5>
                <p class="card-text">Materias en las que estoy inscrito</p>
                <a href="?controller=estudiante&action=materias" class="btn btn-success">Ver Materias</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Mi Promedio</h5>
                <p class="card-text">Consultar promedio general</p>
                <a href="?controller=estudiante&action=promedio" class="btn btn-info">Ver Promedio</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Mi Perfil</h5>
                <p class="card-text">Ver y actualizar información personal</p>
                <a href="?controller=estudiante&action=perfil" class="btn btn-warning">Ver Perfil</a>
            </div>
        </div>
    </div>
</div>