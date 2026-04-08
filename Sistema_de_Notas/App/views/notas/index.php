<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Notas</h2>
    <a href="?controller=notas&action=create" class="btn btn-primary">Nueva Nota</a>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Materia</th>
                <th>Nota</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($notas)): ?>
                <?php foreach ($notas as $nota): ?>
                    <tr>
                        <td><?= htmlspecialchars($nota['estudiante_nombre'] . ' ' . $nota['estudiante_apellido']) ?></td>
                        <td><?= htmlspecialchars($nota['materia_nombre']) ?></td>
                        <td>
                            <span class="badge <?= $nota['nota'] >= 3.0 ? 'bg-success' : 'bg-danger' ?>">
                                <?= $nota['nota'] ?>
                            </span>
                        </td>
                        <td><?= date('d/m/Y', strtotime($nota['fecha'])) ?></td>
                        <td>
                            <?= $nota['nota'] >= 3.0 ? 
                                '<span class="badge bg-success">Aprobado</span>' : 
                                '<span class="badge bg-danger">Reprobado</span>' ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No hay notas registradas</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>