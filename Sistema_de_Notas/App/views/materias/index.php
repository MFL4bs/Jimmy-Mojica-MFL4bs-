<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Materias</h2>
    <a href="?controller=materias&action=create" class="btn btn-primary">Nueva Materia</a>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Código</th>
                <th>Créditos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($materias)): ?>
                <?php foreach ($materias as $materia): ?>
                    <tr>
                        <td><?= $materia['id'] ?></td>
                        <td><?= htmlspecialchars($materia['nombre']) ?></td>
                        <td><?= htmlspecialchars($materia['codigo']) ?></td>
                        <td><?= $materia['creditos'] ?></td>
                        <td>
                            <a href="?controller=materias&action=edit&id=<?= $materia['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No hay materias registradas</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>