@echo off
cd /d c:\Users\Aprendiz\gestor-de-tareas

echo ======================================
echo Verificando estado...
echo ======================================
git status

echo.
echo ======================================
echo Agregando cambios...
echo ======================================
git add .

echo.
echo ======================================
echo Creando commit...
echo ======================================
git commit -m "Fase 1: Cimiento y Autenticación - Setup Laravel 13 + Breeze + MySQL

- Instalar Laravel 13.7 con PHP 8.3
- Configurar Laravel Breeze con autenticación avanzada (2FA, Passkeys)
- Configurar .env para conectar con MySQL
- Crear modelos: Project, Task con relaciones Eloquent
- Crear migraciones: projects_table, tasks_table
- Crear controladores: ProjectController, TaskController con CRUD completo
- Agregar rutas de recursos para proyectos y tareas
- Crear 5 vistas Blade responsivas con Tailwind CSS
- Implementar autenticación middleware y Gates de autorización
- Agregar validaciones de formularios
- Crear factories y seeders para datos de prueba
- Documentación completa (8 archivos)
- Base de datos SQLite lista, fácil migración a MySQL

Co-authored-by: Copilot <223556219+Copilot@users.noreply.github.com>"

echo.
echo ======================================
echo Verificando commit...
echo ======================================
git log --oneline -1

echo.
echo ✅ Commit completado exitosamente!
pause
