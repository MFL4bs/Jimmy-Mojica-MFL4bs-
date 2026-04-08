<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Aprendizaje</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="auth-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="card auth-card border-0 rounded-4">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <i class="fas fa-graduation-cap fa-3x text-gradient mb-3"></i>
                                <h2 class="fw-bold text-gradient">Iniciar Sesión</h2>
                                <p class="text-muted">Accede a tu cuenta de aprendizaje</p>
                            </div>
                            
                            <?php if(isset($error)): ?>
                                <div class="alert alert-danger d-flex align-items-center" role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <?php echo $error; ?>
                                </div>
                            <?php endif; ?>
                            
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-envelope text-muted"></i>
                                        </span>
                                        <input type="email" name="email" class="form-control border-start-0 ps-0" placeholder="tu@email.com" required>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Contraseña</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-lock text-muted"></i>
                                        </span>
                                        <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="••••••••" required>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-gradient w-100 py-3 fw-semibold">
                                    <i class="fas fa-sign-in-alt me-2"></i>Ingresar
                                </button>
                            </form>
                            
                            <div class="text-center mt-4">
                                <p class="text-muted mb-0">¿No tienes cuenta?</p>
                                <a href="registro.php" class="text-decoration-none fw-semibold text-gradient">Regístrate aquí</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <?php if(isset($_SESSION['registro_success'])): ?>
    <script>
        Swal.fire('¡Registro exitoso!', 'Ya puedes iniciar sesión', 'success');
    </script>
    <?php unset($_SESSION['registro_success']); endif; ?>
</body>
</html>