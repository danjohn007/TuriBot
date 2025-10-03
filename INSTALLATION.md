# Guía de Instalación - TuriBot

## Pasos de Instalación Rápida

### 1. Requisitos Previos
- PHP 7.4 o superior
- MySQL 5.7 o superior
- Apache 2.4 con mod_rewrite
- Extensiones PHP: PDO, PDO_MySQL, GD

### 2. Clonar el Proyecto
```bash
git clone https://github.com/danjohn007/TuriBot.git
cd TuriBot
```

### 3. Configurar Apache

#### Opción A: VirtualHost (Recomendado)
Crear archivo `/etc/apache2/sites-available/turibot.conf`:

```apache
<VirtualHost *:80>
    ServerName turibot.local
    ServerAdmin admin@turibot.local
    DocumentRoot /var/www/html/TuriBot
    
    <Directory /var/www/html/TuriBot>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/turibot-error.log
    CustomLog ${APACHE_LOG_DIR}/turibot-access.log combined
</VirtualHost>
```

Habilitar el sitio:
```bash
sudo a2ensite turibot.conf
sudo a2enmod rewrite
sudo systemctl restart apache2
```

Agregar al archivo `/etc/hosts`:
```
127.0.0.1   turibot.local
```

#### Opción B: Subdirectorio
Simplemente copiar el proyecto a `/var/www/html/turibot/` y acceder vía `http://localhost/turibot/`

### 4. Configurar Base de Datos

Editar `config/config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'turibot_db');
define('DB_USER', 'root');
define('DB_PASS', 'tu_contraseña');
```

Importar el schema:
```bash
mysql -u root -p < database/turibot_schema.sql
```

O desde phpMyAdmin, importar `database/turibot_schema.sql`

### 5. Configurar Permisos

```bash
# Permisos generales
sudo chmod -R 755 /var/www/html/TuriBot

# Permisos de escritura para uploads
sudo chmod -R 777 /var/www/html/TuriBot/public/uploads
```

### 6. Verificar Instalación

Acceder a: `http://turibot.local/test_connection.php`

Este archivo verifica:
- ✓ Detección automática de URL base
- ✓ Conexión a base de datos
- ✓ Extensiones PHP necesarias
- ✓ Tablas de base de datos

### 7. Acceder al Sistema

URL: `http://turibot.local/`

**Credenciales por defecto:**
- Email: `admin@turibot.com`
- Contraseña: `admin123`

**IMPORTANTE:** Cambiar estas credenciales inmediatamente después del primer acceso.

## Configuración Adicional

### Configurar Envío de Emails (Opcional)
Para recuperación de contraseña, configurar SMTP en `config/config.php`:
```php
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'tu_email@gmail.com');
define('SMTP_PASS', 'tu_contraseña');
```

### Configurar Límites de Upload
Editar `php.ini`:
```ini
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 300
memory_limit = 256M
```

Reiniciar Apache:
```bash
sudo systemctl restart apache2
```

### Habilitar HTTPS (Producción)
```bash
sudo apt-get install certbot python3-certbot-apache
sudo certbot --apache -d turibot.com
```

## Solución de Problemas Comunes

### Error: "Database connection failed"
- Verificar credenciales en `config/config.php`
- Confirmar que MySQL esté corriendo: `sudo systemctl status mysql`
- Verificar que la base de datos exista: `mysql -u root -p -e "SHOW DATABASES;"`

### Error: "404 Not Found" en todas las URLs
- Verificar que mod_rewrite esté habilitado: `sudo a2enmod rewrite`
- Verificar que `.htaccess` exista en el directorio raíz
- Verificar configuración de AllowOverride en Apache

### Imágenes no se muestran
- Verificar permisos: `sudo chmod -R 777 public/uploads/`
- Verificar que los subdirectorios existan
- Revisar límites en php.ini

### URL base incorrecta
- El sistema detecta automáticamente la URL base
- Verificar en `test_connection.php` la URL detectada
- Si es incorrecta, verificar configuración de Apache

## Actualización del Sistema

```bash
cd /var/www/html/TuriBot
git pull origin main
# Hacer backup de la base de datos antes
mysql -u root -p turibot_db < database/updates.sql  # si hay updates
```

## Backup

### Backup de Base de Datos
```bash
mysqldump -u root -p turibot_db > backup_$(date +%Y%m%d).sql
```

### Backup de Archivos
```bash
tar -czf turibot_files_$(date +%Y%m%d).tar.gz public/uploads/
```

## Desinstalación

```bash
# Eliminar archivos
sudo rm -rf /var/www/html/TuriBot

# Eliminar base de datos
mysql -u root -p -e "DROP DATABASE turibot_db;"

# Deshabilitar sitio de Apache
sudo a2dissite turibot.conf
sudo systemctl reload apache2
```

## Soporte

Para asistencia adicional:
- GitHub Issues: https://github.com/danjohn007/TuriBot/issues
- Documentación: Ver README.md

## Licencia

MIT License - Ver LICENSE file para detalles.
