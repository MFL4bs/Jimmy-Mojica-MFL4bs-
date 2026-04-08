# Sistema de Notas - Colegio

Sistema de gestión de notas para colegios desarrollado con PHP, MySQL, HTML, CSS y JavaScript siguiendo el patrón MVC.

## Características

- Gestión de estudiantes
- Administración de materias
- Registro y consulta de notas
- Interfaz responsive con Bootstrap
- Arquitectura MVC
- Validación de formularios

## Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache/Nginx)
- XAMPP (recomendado para desarrollo local)

## Instalación

1. **Clonar o descargar el proyecto** en la carpeta `htdocs` de XAMPP:
   ```
   c:\xampp\htdocs\Sistema_de_Notas\
   ```

2. **Crear la base de datos**:
   - Abrir phpMyAdmin (http://localhost/phpmyadmin)
   - Importar el archivo `database/schema.sql`
   - O ejecutar manualmente las consultas SQL del archivo

3. **Configurar la conexión a la base de datos**:
   - Editar `config/database.php` si es necesario
   - Por defecto usa: host=localhost, usuario=root, sin contraseña

4. **Acceder al sistema**:
   - Abrir navegador en: http://localhost/Sistema_de_Notas

## Estructura del Proyecto

```
Sistema_de_Notas/
├── app/
│   ├── controllers/     # Controladores MVC
│   ├── models/         # Modelos de datos
│   └── views/          # Vistas HTML
├── config/             # Configuración
├── database/           # Scripts SQL
├── public/             # Archivos públicos (CSS, JS, imágenes)
└── index.php          # Punto de entrada
```

## Uso

1. **Estudiantes**: Registrar y gestionar información de estudiantes
2. **Materias**: Crear y administrar materias del colegio
3. **Notas**: Asignar calificaciones a estudiantes por materia

## Tecnologías Utilizadas

- **Backend**: PHP 7.4+
- **Base de datos**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript
- **Framework CSS**: Bootstrap 5
- **Arquitectura**: MVC (Modelo-Vista-Controlador)

## Funcionalidades Futuras

- Autenticación de usuarios
- Reportes de notas
- Gestión de profesores
- Períodos académicos
- Exportación a PDF/Excel