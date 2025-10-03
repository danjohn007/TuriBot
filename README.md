# TuriBot - Sistema Administrativo
ChatBot Inteligente Turístico

## Descripción
Sistema administrativo completo para gestionar información turística destinada a un chatbot. Desarrollado con PHP puro (sin framework), MySQL 5.7 y Bootstrap 5, siguiendo arquitectura MVC.

## Características

### Módulos Implementados

1. **Autenticación y Usuarios**
   - Login con email y contraseña (hashing con password_hash)
   - Recuperación de contraseña vía token
   - Roles: Administrador, Editor, Consultor
   - Log de actividades de usuarios

2. **Hospedajes**
   - CRUD completo de hoteles, hostales y cabañas
   - Categorización por estrellas (1-5)
   - Búsqueda y filtrado por nombre, categoría y rango de precios
   - Carga de imágenes

3. **Restaurantes**
   - CRUD completo de restaurantes
   - Clasificación por tipo de comida
   - Búsqueda por nombre y tipo
   - Carga de imágenes

4. **Atracciones Turísticas**
   - CRUD completo de atracciones
   - Categorías: natural, cultural, histórica, recreativa
   - Horarios de apertura/cierre
   - Costo de acceso

5. **Eventos y Campañas**
   - CRUD completo de eventos
   - Programación por fechas
   - Enlaces de venta de boletos

6. **Contactos de Emergencia**
   - Gestión de números oficiales
   - Protección: al menos un número activo

7. **Reportes y Estadísticas**
   - Gráficas mensuales de registros
   - Exportación a CSV/Excel
   - Filtrado por fechas

8. **Configuración General**
   - Personalización de datos del sistema
   - Gestión de usuarios y permisos
   - Mensajes para ChatBot

## Tecnologías Utilizadas

- **Backend**: PHP 7.4+ (puro, sin framework)
- **Base de Datos**: MySQL 5.7+
- **Frontend**: Bootstrap 5, HTML5, CSS3
- **JavaScript**: Chart.js para gráficas
- **Arquitectura**: MVC
- **URL Rewriting**: Apache mod_rewrite para URLs amigables

## Requisitos del Sistema

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Apache 2.4 con mod_rewrite habilitado
- Extensiones PHP: PDO, PDO_MySQL, GD (para manejo de imágenes)

## Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/danjohn007/TuriBot.git
cd TuriBot
```

### 2. Configurar Apache

El sistema detecta automáticamente la URL base. Puede instalarse en cualquier directorio del servidor.

**Ejemplo de VirtualHost:**

```apache
<VirtualHost *:80>
    ServerName turibot.local
    DocumentRoot /var/www/html/TuriBot
    
    <Directory /var/www/html/TuriBot>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Asegúrate de habilitar mod_rewrite:

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### 3. Configurar Base de Datos

Edita el archivo `config/config.php` con tus credenciales:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'turibot_db');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### 4. Importar Base de Datos

```bash
mysql -u root -p < database/turibot_schema.sql
```

O desde phpMyAdmin, importa el archivo `database/turibot_schema.sql`

### 5. Configurar Permisos

```bash
chmod -R 755 /var/www/html/TuriBot
chmod -R 777 /var/www/html/TuriBot/public/uploads
```

### 6. Verificar Instalación

Accede a: `http://turibot.local/test_connection.php`

Este archivo verifica:
- Detección correcta de URL base
- Conexión a base de datos
- Extensiones PHP necesarias
- Tablas creadas

## Credenciales por Defecto

### Usuarios de Prueba

| Email | Contraseña | Rol |
|-------|------------|-----|
| admin@turibot.com | admin123 | Administrador |
| editor@turibot.com | admin123 | Editor |
| consultor@turibot.com | admin123 | Consultor |

**IMPORTANTE:** Cambia estas contraseñas en producción.

## Estructura del Proyecto

```
TuriBot/
├── app/
│   ├── controllers/      # Controladores MVC
│   ├── models/          # Modelos de datos
│   ├── views/           # Vistas (HTML/PHP)
│   └── helpers/         # Funciones auxiliares
├── config/
│   ├── config.php       # Configuración general
│   └── database.php     # Conexión a BD
├── database/
│   └── turibot_schema.sql  # Schema y datos de ejemplo
├── public/
│   ├── css/            # Estilos personalizados
│   ├── js/             # JavaScript personalizado
│   ├── img/            # Imágenes del sistema
│   └── uploads/        # Archivos subidos
├── .htaccess           # Reescritura de URLs
├── index.php           # Punto de entrada
├── test_connection.php # Test de instalación
└── README.md
```

## Uso del Sistema

### Acceso al Sistema

1. Visita: `http://turibot.local/` (o tu URL configurada)
2. Inicia sesión con las credenciales por defecto
3. Explora los módulos desde el menú lateral

### Gestión de Módulos

Cada módulo tiene funcionalidades CRUD completas:
- **Listar**: Ver todos los registros con paginación
- **Crear**: Agregar nuevos registros
- **Editar**: Modificar registros existentes
- **Eliminar**: Borrar registros (con confirmación)
- **Buscar/Filtrar**: Encontrar registros específicos

### Exportar Reportes

1. Ve a **Reportes** en el menú
2. Selecciona el tipo de reporte
3. Haz clic en **Exportar CSV**
4. El archivo se descargará automáticamente

## Roles y Permisos

| Funcionalidad | Admin | Editor | Consultor |
|--------------|-------|--------|-----------|
| Dashboard | ✓ | ✓ | ✓ |
| Ver registros | ✓ | ✓ | ✓ |
| Crear/Editar | ✓ | ✓ | ✗ |
| Eliminar | ✓ | ✓ | ✗ |
| Reportes | ✓ | ✗ | ✗ |
| Usuarios | ✓ | ✗ | ✗ |
| Configuración | ✓ | ✗ | ✗ |

## Seguridad

- Contraseñas hasheadas con `password_hash()`
- Protección CSRF en formularios
- Validación de entrada en servidor
- SQL preparado (PDO) contra inyección SQL
- Sesiones seguras con httponly
- Validación de permisos por rol

## Características Destacadas

### URL Base Automática
El sistema detecta automáticamente la URL base, permitiendo instalación en cualquier directorio sin configuración manual.

### Arquitectura MVC
- **Models**: Lógica de negocio y acceso a datos
- **Views**: Presentación HTML
- **Controllers**: Coordinación entre modelo y vista

### URLs Amigables
```
http://turibot.local/hospedaje
http://turibot.local/hospedaje/create
http://turibot.local/restaurante/edit/5
```

### Responsive Design
Interfaz completamente adaptable a dispositivos móviles gracias a Bootstrap 5.

### Log de Actividades
Todas las acciones importantes quedan registradas con:
- Usuario que realizó la acción
- Fecha y hora
- IP del usuario
- Detalles de la acción

## Solución de Problemas

### Error: "No se puede conectar a la base de datos"
- Verifica credenciales en `config/config.php`
- Confirma que MySQL esté ejecutándose
- Verifica que la base de datos exista

### Error: "Página no encontrada" o "404"
- Verifica que mod_rewrite esté habilitado
- Confirma que `.htaccess` existe en el directorio raíz
- Revisa permisos del archivo `.htaccess`

### Imágenes no se cargan
- Verifica permisos en `public/uploads/` (777)
- Confirma que los subdirectorios existan
- Revisa el tamaño máximo de upload en php.ini

### URLs no funcionan correctamente
- El sistema detecta automáticamente la URL base
- Accede a `test_connection.php` para verificar la detección
- Verifica configuración de Apache

## Desarrollo y Personalización

### Agregar nuevo módulo

1. Crear modelo en `app/models/`
2. Crear controlador en `app/controllers/`
3. Crear vistas en `app/views/`
4. Agregar tabla en base de datos
5. Agregar enlace en `app/views/layouts/header.php`

### Personalizar estilos

Modifica variables CSS en `app/views/layouts/header.php`:

```css
:root {
    --primary-color: #667eea;
    --secondary-color: #764ba2;
}
```

## Contribución

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## Licencia

Este proyecto está bajo licencia MIT.

## Soporte

Para reportar problemas o solicitar características:
- Abre un issue en GitHub
- Contacta al equipo de desarrollo

## Autor

Desarrollado por [danjohn007](https://github.com/danjohn007)

## Versión

**1.0.0** - Versión inicial con todos los módulos funcionales
