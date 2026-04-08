<h2>Nueva Nota</h2>

<form method="POST" class="needs-validation" novalidate>
    <div class="mb-3">
        <label for="estudiante_id" class="form-label">Estudiante</label>
        <select class="form-select" id="estudiante_id" name="estudiante_id" required>
            <option value="">Seleccione un estudiante</option>
            <?php if (!empty($estudiantes)): ?>
                <?php foreach ($estudiantes as $estudiante): ?>
                    <option value="<?= $estudiante['id'] ?>">
                        <?= htmlspecialchars($estudiante['nombre'] . ' ' . $estudiante['apellido']) ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
        <div class="invalid-feedback">Por favor seleccione un estudiante</div>
    </div>
    
    <div class="mb-3">
        <label for="materia_id" class="form-label">Materia</label>
        <select class="form-select" id="materia_id" name="materia_id" required>
            <option value="">Seleccione una materia</option>
            <?php if (!empty($materias)): ?>
                <?php foreach ($materias as $materia): ?>
                    <option value="<?= $materia['id'] ?>">
                        <?= htmlspecialchars($materia['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
        <div class="invalid-feedback">Por favor seleccione una materia</div>
    </div>
    
    <div class="mb-3">
        <label for="nota" class="form-label">Nota (0.0 - 5.0)</label>
        <input type="number" class="form-control" id="nota" name="nota" min="0" max="5" step="0.1" required>
        <div class="invalid-feedback">Por favor ingrese una nota válida</div>
    </div>
    
    <div class="mb-3">
        <label for="fecha" class="form-label">Fecha</label>
        <input type="date" class="form-control" id="fecha" name="fecha" value="<?= date('Y-m-d') ?>" required>
        <div class="invalid-feedback">Por favor seleccione la fecha</div>
    </div>
    
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="?controller=notas" class="btn btn-secondary">Cancelar</a>
    </div>
</form>