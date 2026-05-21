# 🏗️ Arquitectura del Gestor de Tareas

## Modelo de Datos

```
┌─────────────┐
│    User     │
│  (usuario)  │
└──────┬──────┘
       │ 1:N
       │
       ▼
┌─────────────────┐
│    Project      │
│  (proyecto)     │
│  - name         │
│  - description  │
└──────┬──────────┘
       │ 1:N
       │
       ▼
┌──────────────────┐
│      Task        │
│    (tarea)       │
│  - title         │
│  - description   │
│  - status        │
└──────────────────┘

Estados de tarea:
  • pending      (Pendiente)
  • in_progress  (En Proceso)
  • completed    (Completada)
```

---

## Flujo de rutas

```
Rutas Públicas:
  GET  /                    → welcome (página de bienvenida)

Rutas Autenticadas:
  
  Dashboard:
    GET  /dashboard         → dashboard

  Proyectos (Resource):
    GET    /projects                  → ProjectController@index
    GET    /projects/create           → ProjectController@create
    POST   /projects                  → ProjectController@store
    GET    /projects/{id}             → ProjectController@show
    GET    /projects/{id}/edit        → ProjectController@edit
    PUT    /projects/{id}             → ProjectController@update
    DELETE /projects/{id}             → ProjectController@destroy

  Tareas:
    POST   /projects/{id}/tasks       → TaskController@store
    PUT    /tasks/{id}                → TaskController@update
    DELETE /tasks/{id}                → TaskController@destroy
    PATCH  /tasks/{id}/status         → TaskController@updateStatus
```

---

## Estructura de Carpetas

```
app/
├── Http/
│   └── Controllers/
│       ├── ProjectController.php      ← Lógica de proyectos
│       └── TaskController.php         ← Lógica de tareas
├── Models/
│   ├── User.php                       ← Actualizado con proyectos
│   ├── Project.php                    ← Nuevo
│   └── Task.php                       ← Nuevo
└── Providers/
    └── AppServiceProvider.php         ← Políticas de autorización

database/
├── migrations/
│   ├── 2025_05_21_140000_create_projects_table.php
│   └── 2025_05_21_140100_create_tasks_table.php
├── factories/
│   ├── ProjectFactory.php
│   └── TaskFactory.php
└── seeders/
    └── DatabaseSeeder.php             ← Datos de prueba

resources/
└── views/
    ├── dashboard.blade.php            ← Actualizado
    ├── projects-index.blade.php       ← Listado
    ├── projects-create.blade.php      ← Crear
    ├── projects-edit.blade.php        ← Editar
    └── projects-show.blade.php        ← Detalle con tareas

routes/
└── web.php                            ← Rutas actualizadas
```

---

## Flujo de Usuario

### 1️⃣ Autenticación
```
Usuario no registrado
    ↓ (register)
Usuario registrado
    ↓ (login)
Dashboard
```

### 2️⃣ Gestión de Proyectos
```
Dashboard
    ↓ (Ir a Mis Proyectos)
Listado de Proyectos
    ├─ Click en proyecto → Ver detalle
    ├─ Editar proyecto → Editar proyecto
    └─ + Nuevo → Crear proyecto
```

### 3️⃣ Gestión de Tareas
```
Detalle del Proyecto
    ├─ Agregar Nueva Tarea
    ├─ Ver tareas por estado
    │   ├─ Pendiente
    │   ├─ En Proceso
    │   └─ Completada
    └─ Para cada tarea:
        ├─ Ver título y descripción
        ├─ Cambiar estado (dropdown)
        └─ Eliminar
```

---

## Validaciones

### Proyecto
- ✅ Nombre: requerido, string, máx 255 caracteres
- ✅ Descripción: opcional, string, máx 1000 caracteres

### Tarea
- ✅ Título: requerido, string, máx 255 caracteres
- ✅ Descripción: opcional, string, máx 1000 caracteres
- ✅ Estado: requerido, debe ser uno de: pending | in_progress | completed

---

## Seguridad

### Autenticación
- ✅ Middleware `auth` en todas las rutas protegidas
- ✅ Middleware `verified` en panel de control

### Autorización
- ✅ Solo el propietario puede ver sus proyectos
- ✅ Solo el propietario puede editar/eliminar
- ✅ Gates configuradas en AppServiceProvider

---

## Funcionalidades

### Proyectos
- ✨ Crear proyecto con nombre y descripción
- ✨ Ver listado de proyectos del usuario
- ✨ Ver detalle con contador de tareas
- ✨ Editar nombre y descripción
- ✨ Eliminar proyecto (elimina todas las tareas)

### Tareas
- ✨ Crear dentro de un proyecto
- ✨ Ver listadas por estado (Pendiente, En Proceso, Completada)
- ✨ Cambiar estado en tiempo real
- ✨ Ver fecha de creación
- ✨ Eliminar tarea

### Dashboard
- ✨ Resumen con número de proyectos
- ✨ Total de tareas
- ✨ Total de tareas completadas
- ✨ Botón directo a proyectos

---

## Stack Tecnológico

- **Framework**: Laravel 13.x
- **Base de datos**: SQLite (configurado, fácil migrar a MySQL)
- **Autenticación**: Laravel Breeze/Fortify
- **Frontend**: Blade + Tailwind CSS
- **Build tool**: Vite
- **Testing**: Pest (disponible)
- **ORM**: Eloquent
- **Validación**: Laravel Validation

---

## Próximas Mejoras (Sugerencias)

1. **Autenticación avanzada**
   - [ ] Asignar tareas a múltiples usuarios
   - [ ] Roles y permisos

2. **Funcionalidades**
   - [ ] Prioridades de tareas
   - [ ] Fechas límite
   - [ ] Archivos adjuntos
   - [ ] Comentarios en tareas

3. **Experiencia**
   - [ ] Filtros avanzados
   - [ ] Búsqueda
   - [ ] Vistas kanban
   - [ ] Calendario

4. **Integración**
   - [ ] API REST
   - [ ] Webhooks
   - [ ] Notificaciones por email

5. **Testing**
   - [ ] Tests unitarios
   - [ ] Tests de integración
   - [ ] E2E tests

