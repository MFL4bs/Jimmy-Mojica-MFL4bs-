<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sistema de Notas' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Sistema de Notas</a>
            <div class="navbar-nav">
                <a class="nav-link" href="?controller=estudiantes">Estudiantes</a>
                <a class="nav-link" href="?controller=materias">Materias</a>
                <a class="nav-link" href="?controller=notas">Notas</a>
            </div>
        </div>
    </nav>
    <div class="container mt-4">