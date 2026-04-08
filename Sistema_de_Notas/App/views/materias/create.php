<h2>Nueva Materia</h2>

<form method="POST" class="needs-validation" novalidate>
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre de la Materia</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required>
        <div class="invalid-feedback">Por favor ingrese el nombre de la materia</div>
    </div>
    
    <div class="mb-3">
        <label for="codigo" class="form-label">Código</label>
        <input type="text" class="form-control" id="codigo" name="codigo" required>
        <div class="invalid-feedback">Por favor ingrese el código de la materia</div>
    </div>
    
    <div class="mb-3">
        <label for="creditos" class="form-label">Créditos</label>
        <input type="number" class="form-control" id="creditos" name="creditos" min="1" max="6" value="3" required>
        <div class="invalid-feedback">Por favor ingrese el número de créditos</div>
    </div>
    
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="?controller=materias" class="btn btn-secondary">Cancelar</a>
    </div>
</form>