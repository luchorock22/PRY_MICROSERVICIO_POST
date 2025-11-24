# PRY_MICROSERVICIO_POST

Microservicio Laravel para gestión de posts. API backend que usa PostgreSQL y Vite para el frontend de desarrollo.

## Requisitos
- PHP (compatible con la versión de Laravel del proyecto)
- Composer
- Node.js & npm
- PostgreSQL (o Docker)
- Git (opcional)

## Variables importantes (.env)
Asegúrate de configurar estas variables en .env:
- APP_URL=http://localhost:8000
- DB_CONNECTION=pgsql
- DB_HOST=127.0.0.1
- DB_PORT=5432
- DB_DATABASE=posts_db
- DB_USERNAME=postgres
- DB_PASSWORD=tu_password
- AUTH_SERVICE_URL=http://localhost:8001
- VITE_API_BASE_URL=http://localhost:8000

## Instalar dependencias (Windows / PowerShell)
1. Abrir PowerShell en la carpeta del proyecto:
   cd 'C:\Users\stali\Desktop\PRY_MICROSERVICIO_POST\PRY_MICROSERVICIO_POST'

2. PHP / Composer:
   composer install
   php artisan key:generate
   php artisan config:clear
   php artisan cache:clear

3. Node / Vite:
   npm install
   npm run dev   # dev server Vite -> http://localhost:5173
   # npm run build  (producción)

## Base de datos
Opción A — Docker (rápido):
```powershell
docker run --name postgres -e POSTGRES_USER=postgres -e POSTGRES_PASSWORD=Fioresam1417 -e POSTGRES_DB=posts_db -p 5432:5432 -v pgdata:/var/lib/postgresql/data -d postgres:15
```

Opción B — PostgreSQL en Windows:
- Instalar PostgreSQL y añadir psql al PATH.
- Crear BD:
  psql -h 127.0.0.1 -U postgres -c "CREATE DATABASE posts_db;"

Después de crear la BD:
php artisan migrate --seed

## Ejecutar la aplicación
1. Levantar backend Laravel:
   php artisan serve --host=127.0.0.1 --port=8000

2. Vite (si no está corriendo):
   npm run dev

Accesos:
- Backend: http://localhost:8000
- Frontend dev (Vite): http://localhost:5173

## Endpoints principales (ejemplo)
- GET /api/posts
- GET /api/posts/{id}
- POST /api/posts
- PUT/PATCH /api/posts/{id}
- DELETE /api/posts/{id}

Rutas protegidas usan middleware que valida token contra el microservicio de autenticación:
- AUTH_SERVICE_URL + /api/validate-token
  - Ejemplo curl (header Bearer):
    curl -H "Authorization: Bearer <TOKEN>" http://localhost:8001/api/validate-token

## Pruebas
- php artisan test
- vendor/bin/phpunit

## Logs y debugging
- Logs: storage/logs/laravel.log
- Ver salida en tiempo real (PowerShell):
  Get-Content .\storage\logs\laravel.log -Wait -Tail 50

## Problemas comunes
- "node not recognized": instalar Node.js y reiniciar terminal.
- "psql not recognized": instalar PostgreSQL o usar Docker.
- Línea suelta en .env (p. ej. `hello@example.com`): eliminar o mover dentro de la clave correspondiente.

## Notas
- Verificar que AUTH_SERVICE_URL apunte al servicio de autenticación activo.
- Ejecutar `php artisan storage:link` si necesita servir archivos desde storage.

## Licencia
Sin licencia especificada.