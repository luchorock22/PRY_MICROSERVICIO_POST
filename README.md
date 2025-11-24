# 📘 **README – Microservicio de Autenticación + Microservicio de Posts (CRUD)**  
### Proyecto para evaluación con Laravel Sanctum y comunicación entre microservicios

---

# 📌 **1. Descripción general del proyecto**

Este proyecto está compuesto por **dos microservicios independientes**, cada uno ejecutándose en un servidor diferente y con su propia base de datos.

---

## 🟦 **Microservicio 1: Autenticación (Laravel Sanctum)**

- Maneja **registro**, **login**, **generación de tokens**, **validación de token**, y **cierre de sesión**.  
- Utiliza **Laravel Sanctum** para la gestión de tokens personales.  
- Base de datos: **MySQL (XAMPP)**  
- Puerto recomendado: **8000**

### Ejecutar servidor:
```bash
php artisan serve --port=8000
```

---

## 🟩 **Microservicio 2: Posts (CRUD)**

- CRUD completo de posts.  
- Usa un **Middleware personalizado (`auth.micro`)** para validar tokens enviando la solicitud al microservicio de autenticación.  
- Base de datos: **PostgreSQL**  
- Puerto recomendado: **8001**

### Ejecutar servidor:
```bash
php artisan serve --port=8001
```

---

# 📌 **2. Configuración de Bases de Datos**

---

## 🟦 **Microservicio de Autenticación – MySQL (XAMPP)**

### Crear base de datos:
```
db_users_auto
```

### Editar archivo `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_users_auto
DB_USERNAME=root
DB_PASSWORD=
```

### Ejecutar migraciones:
```bash
php artisan migrate
```

---

## 🟩 **Microservicio de Posts – PostgreSQL**

### Crear base de datos:
```
posts_db
```

### Editar archivo `.env`:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=posts_db
DB_USERNAME=postgres
DB_PASSWORD=TU_CLAVE
```

### Ejecutar migraciones:
```bash
php artisan migrate
```

---

# 📌 **3. Comunicación entre microservicios**

El microservicio de Posts envía el token recibido hacia el microservicio de Autenticación:

```
GET http://127.0.0.1:8000/api/validate-token
```

Si el token es válido, el microservicio de autenticación devuelve:

```json
{
  "valid": true,
  "user": {
    "id": 1,
    "name": "Kelly",
    "email": "kelly@test.com"
  }
}
```

El Middleware extrae el `user_id` y lo inserta en el post.

---

# 📌 **4. Estructura de Puertos**

| Microservicio | Puerto | BD           |
|---------------|--------|--------------|
| Autenticación | 8000   | MySQL (XAMPP) |
| Posts (CRUD)  | 8001   | PostgreSQL   |

---

# 📌 **5. Flujo Completo**

1. El usuario se registra o inicia sesión en el microservicio de autenticación.  
2. Obtiene un **token Bearer**.  
3. Envía solicitudes al microservicio de Posts incluyendo el token.  
4. El middleware `auth.micro` valida el token con el microservicio de autenticación.  
5. Si es válido, se permite el acceso al CRUD. 
