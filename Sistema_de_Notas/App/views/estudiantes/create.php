<h2>Nuevo Estudiante</h2>

<form method="POST" class="needs-validation" novalidate>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
                <div class="invalid-feedback">Por favor ingrese el nombre</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" required>
                <div class="invalid-feedback">Por favor ingrese el apellido</div>
            </div>
        </div>
    </div>
    
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
        <div class="invalid-feedback">Por favor ingrese un email válido</div>
    </div>
    
    <div class="mb-3">
        <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
        <div class="invalid-feedback">Por favor seleccione la fecha de nacimiento</div>
    </div>
    
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="?controller=estudiantes" class="btn btn-secondary">Cancelar</a>
    </div>
</form>