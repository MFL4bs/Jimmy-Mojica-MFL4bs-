<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Estudiantes</h2>
    <a href="?controller=estudiantes&action=create" class="btn btn-primary">Nuevo Estudiante</a>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Fecha Nacimiento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($estudiantes)): ?>
                <?php foreach ($estudiantes as $estudiante): ?>
                    <tr>
                        <td><?= $estudiante['id'] ?></td>
                        <td><?= htmlspecialchars($estudiante['nombre']) ?></td>
                        <td><?= htmlspecialchars($estudiante['apellido']) ?></td>
                        <td><?= htmlspecialchars($estudiante['email']) ?></td>
                        <td><?= $estudiante['fecha_nacimiento'] ?></td>
                        <td>
                            <a href="?controller=estudiantes&action=edit&id=<?= $estudiante['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No hay estudiantes registrados</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>