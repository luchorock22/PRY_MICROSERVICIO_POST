# 📘 **README – Microservicio de Autenticación + Microservicio de Posts (CRUD)**  
### Proyecto para evaluación con Laravel Sanctum y comunicación entre microservicios

---

# 📌 **1. Descripción general del proyecto**

Este proyecto está compuesto por **dos microservicios independientes**:

---

## 🟦 **Microservicio 1: Autenticación (Laravel Sanctum)**  
- Maneja el **registro**, **login**, **generación de tokens**, y **validación de usuarios**.  
- Funciona con **Laravel Sanctum**.  
- Base de datos: **MySQL (XAMPP)**  
- Puerto por defecto: **8000**

Ejecutar:
php artisan serve --port=8000 en el servidor de autenticación

## 🟩 **Microservicio 2: Posts (CRUD)**  
- Permite crear, listar, actualizar y eliminar posts.  
- Funciona con un **Middleware personalizado (auth.micro)** para validar tokens desde el microservicio de autenticación.  
- Base de datos: **PostgreSQL**  
- Puerto utilizado: **8001**

Ejecutar:
php artisan serve --port=8001 en el servidor del post.

# 📌 **3. Configuración de Bases de Datos**

---

## 🟦 Microservicio 1: Autenticación (MySQL)

Crear base de datos:

db_users_auto ---- Nombre de la base de datos del servidor de autenticación


## Editar `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_users_auto
DB_USERNAME=root
DB_PASSWORD=

## Ejecutar migraciones:

php artisan migrate

🟩 Microservicio 2: Posts (PostgreSQL)
Crear base de datos:

posts_db nombre de la base de datos 

## Editar `.env`:

```env

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=posts_db
DB_USERNAME=postgres
DB_PASSWORD=TU_CLAVE

## Ejecutar migraciones:
php artisan migrate
