# Guía de Despliegue en Producción

## Requisitos Previos

- PHP 8.2 o superior
- Composer 2.0 o superior
- Node.js 18+ y npm 9+
- MySQL 8.0 o superior
- Servidor web (Nginx/Apache)
- Certificado SSL (recomendado)

## 1. Configuración del Servidor

### 1.1. Requisitos del Sistema

```bash
# Paquetes necesarios en Ubuntu/Debian
sudo apt update
sudo apt install -y php8.2-fpm php8.2-mysql php8.2-mbstring php8.2-xml php8.2-curl \
    php8.2-zip php8.2-gd php8.2-intl php8.2-bcmath
```

### 1.2. Configuración de PHP

Asegúrate de que tu `php.ini` tenga estos ajustes:

```ini
upload_max_filesize = 20M
post_max_size = 20M
memory_limit = 256M
max_execution_time = 300
session.cookie_secure = 1
session.cookie_httponly = 1
session.cookie_samesite = "Lax"
```

## 2. Despliegue del Código

### 2.1. Clonar el Repositorio

```bash
git clone [URL_DEL_REPOSITORIO] /var/www/interelectricosfa
cd /var/www/interelectricosfa
```

### 2.2. Instalar Dependencias

```bash
# Instalar dependencias de PHP
composer install --optimize-autoloader --no-dev

# Instalar dependencias de Node.js
npm install --production
```

### 2.3. Configuración del Entorno

1. Copiar el archivo .env.example a .env
2. Configurar las variables de entorno:
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - Configurar credenciales de base de datos
   - Configurar `APP_URL` con tu dominio
   - Configurar credenciales de correo

### 2.4. Generar Clave de la Aplicación

```bash
php artisan key:generate
```

## 3. Configuración de Base de Datos

### 3.1. Crear Base de Datos

```sql
CREATE DATABASE interelectricosfa CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'db_user'@'localhost' IDENTIFIED BY 'tu_contraseña_segura';
GRANT ALL PRIVILEGES ON interelectricosfa.* TO 'db_user'@'localhost';
FLUSH PRIVILEGES;
```

### 3.2. Migraciones y Semillas

```bash
php artisan migrate --force
php artisan db:seed --class=DatabaseSeeder
```

## 4. Configuración del Sistema de Archivos

### 4.1. Permisos

```bash
# Propietario del directorio web (ajusta según tu configuración)
sudo chown -R www-data:www-data /var/www/interelectricosfa

# Permisos de directorios
sudo find /var/www/interelectricosfa -type d -exec chmod 755 {} \;
sudo find /var/www/interelectricosfa -type f -exec chmod 644 {} \;

# Permisos especiales
sudo chmod -R 775 storage/
sudo chmod -R 775 bootstrap/cache/
```

### 4.2. Enlace Simbólico de Almacenamiento

```bash
php artisan storage:link
```

## 5. Compilación de Assets

```bash
# Instalar dependencias de desarrollo
npm install

# Compilar assets para producción
npm run build
```

## 6. Configuración del Servidor Web

### 6.1. Nginx (recomendado)

```nginx
server {
    listen 80;
    server_name tudominio.com www.tudominio.com;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    server_name tudominio.com www.tudominio.com;

    ssl_certificate /ruta/a/tu/certificado.crt;
    ssl_certificate_key /ruta/a/tu/llave-privada.key;

    root /var/www/interelectricosfa/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

## 7. Programación de Tareas

### 7.1. Configurar Cron Job

```bash
# Editar el crontab del usuario web
sudo -u www-data crontab -e

# Añadir esta línea
* * * * * cd /var/www/interelectricosfa && php artisan schedule:run >> /dev/null 2>&1
```

## 8. Monitoreo y Mantenimiento

### 8.1. Configurar Logrotate

```
/var/www/interelectricosfa/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    delaycompress
    notifempty
    create 0640 www-data www-data
    sharedscripts
    postrotate
        kill -USR1 `cat /run/php/php8.2-fpm.pid 2>/dev/null` 2>/dev/null || true
    endscript
}
```

### 8.2. Configurar Backups

```bash
# Ejemplo de script de respaldo
#!/bin/bash

# Variables
DB_USER="db_user"
DB_PASS="tu_contraseña"
DB_NAME="interelectricosfa"
BACKUP_DIR="/backups/interelectricosfa"
DATE=$(date +"%Y%m%d_%H%M%S")

# Crear directorio de respaldos
mkdir -p $BACKUP_DIR

# Respaldar base de datos
mysqldump -u$DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/db_backup_$DATE.sql

# Comprimir respaldo
tar -czf $BACKUP_DIR/backup_$DATE.tar.gz $BACKUP_DIR/db_backup_$DATE.sql /var/www/interelectricosfa/storage/app/public

# Eliminar archivos temporales
rm $BACKUP_DIR/db_backup_$DATE.sql

# Eliminar respaldos antiguos (más de 30 días)
find $BACKUP_DIR -type f -mtime +30 -delete
```

## 9. Puesta en Marcha

1. Reiniciar servicios:
   ```bash
   sudo systemctl restart nginx
   sudo systemctl restart php8.2-fpm
   ```

2. Verificar que el sitio esté accesible en https://tudominio.com

## 10. Mantenimiento

### 10.1. Actualizaciones

```bash
# Actualizar código
git pull origin main

# Actualizar dependencias
composer install --optimize-autoloader --no-dev
npm install --production
npm run build

# Limpiar caché
php artisan optimize:clear
php artisan optimize
php artisan view:cache
```

### 10.2. Monitoreo de Errores

Se recomienda configurar un servicio de monitoreo como:
- Laravel Telescope
- Sentry
- Bugsnag

## Solución de Problemas Comunes

### Error 500 después del despliegue

1. Verificar permisos de archivos
2. Verificar logs en `storage/logs/laravel.log`
3. Ejecutar:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   php artisan route:clear
   ```

### Error de conexión a la base de datos

1. Verificar credenciales en `.env`
2. Verificar que el usuario de la base de datos tenga los permisos necesarios
3. Verificar que el servidor MySQL esté en ejecución

## Contacto de Soporte

Para problemas técnicos, contactar al equipo de desarrollo en:
- Email: soporte@tudominio.com
- WhatsApp: +1234567890
