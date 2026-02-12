# CRUD MySQL + phpMyAdmin + PHP-Apache (Docker Compose)

Instrucciones rápidas:

- Levantar los contenedores:

```bash
docker compose up --build -d
```

- Acceder a la app PHP: http://localhost:8080
- Acceder a phpMyAdmin: http://localhost:8081 (usuario: `root`, contraseña: `rootpass`)

Detalles:
- `docker-compose.yml` define 3 servicios en la misma red: `db` (MySQL), `phpmyadmin` y `web` (PHP + Apache).
- `db` usa volumen llamado `db_data` para persistencia y monta `db/init.sql` para inicializar la base de datos.
- `web` se construye desde `php/Dockerfile` y usa un bind-mount (`./src`) para el código (esto permite editar localmente).

Credenciales por defecto (puedes cambiarlas en `docker-compose.yml`):
- MySQL root: `rootpass`
- Base de datos: `app_db` / usuario `appuser` / contraseña `apppass`
# crud-mysql-phpmyadmin
creando con jeronimo
