# Guía de Despliegue en CDMON

## Tabla de Contenidos
1. [Requisitos Previos](#requisitos-previos)
2. [Preparación del Proyecto](#preparación-del-proyecto)
3. [Configuración en CDMON](#configuración-en-cdmon)
4. [Subida de Archivos](#subida-de-archivos)
5. [Configuración de la Base de Datos](#configuración-de-la-base-de-datos)
6. [Configuración PHP](#configuración-php)
7. [Configuración de Correo](#configuración-de-correo)
8. [Configuración de SSL](#configuración-de-ssl)
9. [Solución de Problemas](#solución-de-problemas)

## Requisitos Previos

- Cuenta de hosting en CDMON con soporte para PHP 8.2+
- Acceso al panel de control de CDMON
- Cliente FTP (FileZilla, WinSCP, etc.)
- Acceso SSH (recomendado pero no obligatorio)
- Base de datos MySQL/MariaDB

## Preparación del Proyecto

### 1. Configuración del Entorno

1. Asegúrate de que tu `.env` tenga estas configuraciones:

```ini
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tudominio.com

# Configuración de base de datos (se completará más adelante)
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=tu_basededatos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña

# Configuración de sesión segura
SESSION_DRIVER=database
SESSION_SECURE_COOKIE=true

# Configuración de caché
CACHE_DRIVER=file

# Configuración de correo (ajustar según CDMON)
MAIL_MAILER=smtp
MAIL_HOST=mail.tudominio.com
MAIL_PORT=587
MAIL_USERNAME=tu_correo@tudominio.com
MAIL_PASSWORD=tu_contraseña
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu_correo@tudominio.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 2. Compilar Assets para Producción

```bash
# Instalar dependencias
composer install --optimize-autoloader --no-dev
npm install --production

# Compilar assets
npm run build

# Limpiar caché
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Configuración en CDMON

### 1. Acceso al Panel de Control

1. Inicia sesión en tu cuenta de CDMON
2. Ve al apartado de "Hosting"
3. Selecciona tu plan de hosting

### 2. Configuración de PHP

1. En el panel de control, busca la opción "Configuración de PHP"
2. Establece la versión de PHP a 8.2 o superior
3. Establece las siguientes directivas PHP:
   - memory_limit = 256M
   - upload_max_filesize = 20M
   - post_max_size = 20M
   - max_execution_time = 300
   - session.cookie_secure = 1
   - session.cookie_httponly = 1

## Subida de Archivos

### 1. Configuración de FTP

1. En el panel de CDMON, ve a "FTP"
2. Crea un usuario FTP si no lo tienes
3. Usa un cliente FTP para conectarte con estos datos:
   - Servidor: ftp.tudominio.com (o la IP que te haya proporcionado CDMON)
   - Usuario: tu_usuario_ftp
   - Contraseña: tu_contraseña_ftp
   - Puerto: 21 (o el que te indique CDMON)

### 2. Estructura de Carpetas

Sube los archivos a la carpeta `public_html` o `www` (depende de la configuración de CDMON):

```
/public_html/
├── .htaccess
├── index.php
├── favicon.ico
├── robots.txt
├── web.config
└── public/
    ├── css/
    ├── js/
    └── images/
```

### 3. Archivos a Excluir

Asegúrate de NO subir estos archivos/carpetas:
- .env
- .git/
- node_modules/
- storage/framework/sessions/
- storage/framework/views/
- storage/logs/
- tests/

## Configuración de la Base de Datos

### 1. Crear Base de Datos

1. En el panel de CDMON, ve a "Bases de datos"
2. Crea una nueva base de datos MySQL
3. Anota los siguientes datos:
   - Nombre de la base de datos
   - Usuario de la base de datos
   - Contraseña
   - Servidor (generalmente localhost)

### 2. Importar la Estructura

1. Usa phpMyAdmin (disponible en el panel de CDMON)
2. Selecciona tu base de datos
3. Importa el archivo SQL con la estructura inicial

### 3. Actualizar .env

Actualiza el archivo `.env` con los datos de conexión a la base de datos proporcionados por CDMON.

## Configuración de Correo

1. En el panel de CDMON, ve a "Correo"
2. Crea una cuenta de correo (ej: info@tudominio.com)
3. Configura el correo en tu aplicación con estos datos:
   - Servidor SMTP: mail.tudominio.com
   - Puerto: 587 (o 465 para SSL)
   - Autenticación: Activada
   - Seguridad: STARTTLS (o SSL/TLS)

## Configuración de SSL

1. En el panel de CDMON, ve a "SSL"
2. Activa "SSL Automático" o instala un certificado Let's Encrypt
3. Configura la redirección de HTTP a HTTPS en tu `.htaccess`:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On
    
    # Redirigir HTTP a HTTPS
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
    
    # Manejar el enrutamiento de Laravel
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Enviar solicitudes al front controller
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

## Solución de Problemas

### Error 500 después del despliegue

1. Verifica los permisos de las carpetas:
   ```bash
   chmod -R 755 public_html/
   chmod -R 755 storage/
   chmod -R 755 bootstrap/cache/
   ```

2. Verifica el archivo de logs en `storage/logs/laravel.log`

3. Habilita temporalmente el modo debug en `.env`:
   ```
   APP_DEBUG=true
   ```

### Error de conexión a la base de datos

1. Verifica que los datos en `.env` coincidan con los de CDMON
2. Comprueba que el usuario de la base de datos tenga todos los permisos
3. Verifica que el servidor de base de datos esté accesible desde tu hosting

### Problemas con las rutas

1. Asegúrate de que el `.htaccess` esté correctamente configurado
2. Verifica que el `public/index.php` sea el punto de entrada
3. Prueba a regenerar la caché de rutas:
   ```bash
   php artisan route:clear
   php artisan route:cache
   ```

## Soporte Técnico CDMON

Si necesitas asistencia adicional, contacta con el soporte de CDMON:
- Teléfono: +34 934 98 19 22
- Email: soporte@cdmon.com
- Centro de ayuda: https://www.cdmon.com/es/ayuda

## Actualizaciones Futuras

Para actualizar tu aplicación en producción:

1. Haz los cambios en tu entorno local
2. Prueba los cambios localmente
3. Sube solo los archivos modificados
4. Ejecuta las migraciones si es necesario:
   ```bash
   php artisan migrate --force
   ```
5. Limpia las cachés:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
