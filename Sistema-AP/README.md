# Sistema de Aprendizaje MVC

Sistema de aprendizaje desarrollado con PHP, MySQL, HTML, CSS y JavaScript siguiendo el patrón MVC.

## Instalación

1. **Configurar XAMPP**
   - Asegúrate de tener XAMPP instalado
   - Inicia Apache y MySQL

2. **Base de Datos**
   - Abre phpMyAdmin (http://localhost/phpmyadmin)
   - Ejecuta el script `database.sql` para crear la base de datos y tablas

3. **Configuración**
   - El proyecto está configurado para usar:
     - Host: localhost
     - Usuario: root
     - Contraseña: (vacía)
     - Base de datos: sistema_aprendizaje

4. **Acceso**
   - URL: http://localhost/Sistema-AP/public/
   - Usuario admin: admin@sistema.com / password
   - Usuario estudiante: estudiante@sistema.com / password

## Estructura del Proyecto

```
Sistema-AP/
├── app/
│   ├── controllers/    # Controladores MVC
│   ├── models/        # Modelos de datos
│   └── views/         # Vistas HTML
├── config/            # Configuración de BD
├── public/            # Archivos públicos
│   ├── css/          # Estilos CSS
│   └── js/           # JavaScript
└── database.sql      # Script de BD
```

## Funcionalidades

- ✅ Registro e inicio de sesión
- ✅ Gestión de usuarios (estudiantes/instructores)
- ✅ Creación y visualización de cursos
- ✅ Dashboard personalizado
- ✅ Diseño responsive
- ✅ Validación de formularios

## Tecnologías

- **Backend**: PHP 7+
- **Base de Datos**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript
- **Patrón**: MVC (Model-View-Controller)