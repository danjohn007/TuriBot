# 🤖 Módulo de Personalización del ChatBot - TuriBot

## 📋 Índice

1. [Introducción](#introducción)
2. [Instalación Rápida](#instalación-rápida)
3. [Documentación](#documentación)
4. [Características](#características)
5. [Estructura del Módulo](#estructura-del-módulo)
6. [Configuraciones Disponibles](#configuraciones-disponibles)
7. [Ejemplos de Uso](#ejemplos-de-uso)
8. [Soporte](#soporte)

---

## 🎯 Introducción

Este módulo permite la **personalización completa** del ChatBot turístico de TuriBot. Incluye 36 campos de configuración organizados en 8 categorías, permitiendo ajustar desde mensajes hasta comportamiento y apariencia del bot.

### ✨ Características Principales

- ✅ **36 campos configurables** para personalización total
- ✅ **8 categorías organizadas** para fácil gestión
- ✅ **Interfaz administrativa intuitiva** con Bootstrap 5
- ✅ **Valores por defecto funcionales** listos para usar
- ✅ **Script SQL seguro** con INSERT IGNORE
- ✅ **Documentación completa** con ejemplos

---

## 🚀 Instalación Rápida

### Paso 1: Ejecutar Script SQL

```bash
# Opción A: Línea de comandos
mysql -u usuario -p base_datos < database/chatbot_personalization_update.sql

# Opción B: phpMyAdmin
# Importar archivo: database/chatbot_personalization_update.sql
```

### Paso 2: Acceder a la Configuración

1. Iniciar sesión como **administrador**
2. Ir a: **Configuración** → **Configuraciones Generales**
3. Desplazarse a la sección **"Configuración del ChatBot"**

### Paso 3: Personalizar

¡Listo! Ahora puedes personalizar todos los aspectos del ChatBot.

---

## 📚 Documentación

El módulo incluye **5 documentos técnicos completos**:

### 1. 📘 [CHATBOT_PERSONALIZATION.md](CHATBOT_PERSONALIZATION.md) (9.3 KB)
**Documentación técnica completa del módulo**
- Descripción detallada de todas las características
- Tabla completa de campos de base de datos
- Guía de integración con frontend
- Ejemplos de uso práctico
- Casos de uso por tipo de municipio

### 2. 📗 [CHATBOT_FIELDS_REFERENCE.md](CHATBOT_FIELDS_REFERENCE.md) (8.1 KB)
**Referencia rápida de campos**
- Lista completa de 36 campos con tipos y valores
- Resumen por categoría
- Plantillas listas para usar (5 plantillas)
- Consultas SQL útiles
- Acceso programático (PHP/JavaScript)

### 3. 📙 [IMPLEMENTATION_SUMMARY.md](IMPLEMENTATION_SUMMARY.md) (9.4 KB)
**Resumen ejecutivo de implementación**
- Estadísticas del desarrollo
- Arquitectura del módulo
- Checklist de implementación
- Métricas y validaciones
- Estado del proyecto

### 4. 📕 [database/README_CHATBOT_UPDATE.md](database/README_CHATBOT_UPDATE.md) (3.4 KB)
**Guía de instalación SQL**
- Instrucciones paso a paso
- Verificaciones automáticas
- Troubleshooting
- Procedimientos de rollback

### 5. 📄 [database/chatbot_personalization_update.sql](database/chatbot_personalization_update.sql) (5.7 KB)
**Script SQL de actualización**
- 35 configuraciones nuevas
- INSERT IGNORE para seguridad
- Verificaciones incluidas
- Comentarios descriptivos

---

## 🎨 Características

### Organización por Categorías

#### 1️⃣ Configuración Básica (4 campos)
Configure el nombre, estado, idioma y tono del ChatBot.

#### 2️⃣ Mensajes Personalizados (7 campos)
Personalice todos los mensajes del bot: bienvenida, despedida, saludos, etc.

#### 3️⃣ Mensajes de Búsqueda (3 campos)
Configure mensajes de carga, resultados y sin resultados.

#### 4️⃣ Comportamiento (6 campos)
Controle velocidad, sugerencias, límites y tiempo de respuesta.

#### 5️⃣ Horarios (4 campos)
Configure atención 24/7 o establezca horarios personalizados.

#### 6️⃣ Funcionalidades (6 toggles)
Active/desactive búsqueda de hospedajes, restaurantes, atracciones, eventos, emergencias y recomendaciones.

#### 7️⃣ Apariencia (3 campos)
Personalice avatar y colores del ChatBot.

#### 8️⃣ Analítica (3 campos)
Configure historial, feedback y aprendizaje automático.

---

## 🏗️ Estructura del Módulo

```
TuriBot/
│
├── app/
│   ├── controllers/
│   │   └── ConfiguracionController.php    [Modificado: +22 líneas]
│   │       └── Manejo de checkboxes y validaciones
│   │
│   ├── models/
│   │   └── Configuracion.php              [Modificado: +11 líneas]
│   │       └── Upsert automático (UPDATE o INSERT)
│   │
│   └── views/
│       └── configuracion/
│           ├── general.php                [Modificado: 485 líneas]
│           │   └── Vista completa con 36 campos
│           └── index.php                  [Modificado: 89 líneas]
│               └── Vista simplificada
│
├── database/
│   ├── chatbot_personalization_update.sql [NUEVO: 5.7 KB]
│   │   └── Script SQL con 35 configuraciones
│   └── README_CHATBOT_UPDATE.md           [NUEVO: 3.4 KB]
│       └── Guía de instalación
│
├── CHATBOT_PERSONALIZATION.md             [NUEVO: 9.3 KB]
├── CHATBOT_FIELDS_REFERENCE.md            [NUEVO: 8.1 KB]
├── IMPLEMENTATION_SUMMARY.md              [NUEVO: 9.4 KB]
└── CHATBOT_MODULE_README.md               [NUEVO: Este archivo]
```

---

## ⚙️ Configuraciones Disponibles

### Resumen por Tipo de Campo

| Tipo de Campo | Cantidad | Ejemplos |
|---------------|----------|----------|
| Texto libre | 13 | Mensajes, descripciones |
| Boolean (0/1) | 13 | Toggles, activaciones |
| Select | 4 | Idioma, tono, velocidad |
| Numérico | 2 | Tiempo máximo, límite |
| Time (HH:MM) | 2 | Horario inicio/fin |
| Color (#hex) | 2 | Colores primario/secundario |

**Total: 36 campos**

### Ejemplos de Campos

```sql
-- Configuración básica
'chatbot_nombre' => 'TuriBot'
'chatbot_activado' => '1'
'chatbot_idioma' => 'es'
'chatbot_tono_conversacion' => 'amigable'

-- Mensajes
'mensaje_bienvenida' => '¡Bienvenido a TuriBot!'
'chatbot_respuesta_saludos' => '¡Hola! Soy TuriBot...'

-- Comportamiento
'chatbot_velocidad_respuesta' => 'normal'
'chatbot_tiempo_respuesta_max' => '30'

-- Funcionalidades (toggles)
'chatbot_buscar_hospedajes' => '1'
'chatbot_emergencias' => '1'

-- Apariencia
'chatbot_color_primario' => '#667eea'
'chatbot_color_secundario' => '#764ba2'
```

---

## 💡 Ejemplos de Uso

### Caso 1: ChatBot Formal para Gobierno

```sql
UPDATE configuracion SET valor = 'formal' WHERE clave = 'chatbot_tono_conversacion';
UPDATE configuracion SET valor = 'Buenos días. Bienvenido al sistema de información turística oficial del municipio.' WHERE clave = 'mensaje_bienvenida';
```

### Caso 2: ChatBot Casual para Jóvenes

```sql
UPDATE configuracion SET valor = 'casual' WHERE clave = 'chatbot_tono_conversacion';
UPDATE configuracion SET valor = '¡Hey! 👋 ¿Listo para descubrir lugares increíbles?' WHERE clave = 'mensaje_bienvenida';
```

### Caso 3: Horario Limitado (Oficina)

```sql
UPDATE configuracion SET valor = '0' WHERE clave = 'chatbot_atencion_247';
UPDATE configuracion SET valor = '09:00' WHERE clave = 'chatbot_horario_inicio';
UPDATE configuracion SET valor = '17:00' WHERE clave = 'chatbot_horario_fin';
UPDATE configuracion SET valor = 'Lunes,Martes,Miércoles,Jueves,Viernes' WHERE clave = 'chatbot_dias_atencion';
```

### Caso 4: Solo Información Básica

```sql
UPDATE configuracion SET valor = '1' WHERE clave = 'chatbot_buscar_hospedajes';
UPDATE configuracion SET valor = '1' WHERE clave = 'chatbot_buscar_restaurantes';
UPDATE configuracion SET valor = '0' WHERE clave = 'chatbot_buscar_atracciones';
UPDATE configuracion SET valor = '0' WHERE clave = 'chatbot_buscar_eventos';
```

### Acceso Programático (PHP)

```php
// Obtener configuraciones
require_once APP_PATH . '/models/Configuracion.php';
$config = new Configuracion();
$conf = $config->getAllAsArray();

// Usar en el código
$nombreBot = $conf['chatbot_nombre'];
$activado = ($conf['chatbot_activado'] == '1');
$tono = $conf['chatbot_tono_conversacion'];
$colorPrimario = $conf['chatbot_color_primario'];

// Actualizar configuración
$config->update('chatbot_nombre', 'Mi Bot Personalizado');
```

---

## 🔍 Verificación Post-Instalación

### SQL: Ver todas las configuraciones

```sql
SELECT clave, LEFT(valor, 50) as valor_resumido, descripcion 
FROM configuracion 
WHERE clave LIKE 'chatbot_%' OR clave = 'mensaje_bienvenida'
ORDER BY clave;
```

**Resultado esperado:** ~36 registros

### PHP: Verificar sintaxis

```bash
php -l app/controllers/ConfiguracionController.php
php -l app/models/Configuracion.php
```

**Resultado esperado:** "No syntax errors detected"

---

## 🆘 Troubleshooting

### Error: "Table 'configuracion' doesn't exist"
**Solución:** Ejecutar primero el schema principal
```bash
mysql -u usuario -p base_datos < database/turibot_schema.sql
```

### Error: Configuración no se guarda
**Solución:** Verificar permisos de usuario. Solo **admin** puede modificar configuraciones.

### Los checkboxes no se guardan correctamente
**Solución:** Ya está manejado automáticamente en el controlador. Los checkboxes no marcados se guardan como '0'.

---

## 📊 Estadísticas del Módulo

- **36 campos** de configuración
- **8 categorías** organizadas
- **~900 líneas** de código agregadas
- **35.9 KB** de documentación
- **5 archivos** nuevos creados
- **4 archivos** modificados

---

## 🔮 Integración Futura

### Con API REST

```javascript
// Endpoint para obtener configuración
fetch('/api/chatbot/config')
  .then(response => response.json())
  .then(config => {
    // Inicializar ChatBot con configuración
    const chatbot = new ChatBotWidget({
      nombre: config.chatbot_nombre,
      bienvenida: config.mensaje_bienvenida,
      colorPrimario: config.chatbot_color_primario,
      idioma: config.chatbot_idioma
    });
  });
```

### Con Framework de ChatBot

```php
// Crear instancia con configuración
$configuraciones = $configuracionModel->getAllAsArray();
$chatbot = new ChatBotEngine($configuraciones);
$chatbot->procesarMensaje($mensajeUsuario);
```

---

## 📱 Capturas de Pantalla

El formulario incluye:
- ✅ 8 secciones con cards de Bootstrap
- ✅ Iconos descriptivos de Bootstrap Icons
- ✅ Campos agrupados lógicamente
- ✅ Ayuda contextual bajo cada campo
- ✅ Switches visuales para toggles
- ✅ Color pickers integrados
- ✅ Validaciones HTML5
- ✅ Diseño responsive

---

## 🎓 Recursos Adicionales

### Documentación Oficial
- [Bootstrap 5](https://getbootstrap.com/docs/5.0/)
- [Bootstrap Icons](https://icons.getbootstrap.com/)
- [PHP PDO](https://www.php.net/manual/es/book.pdo.php)
- [MySQL 5.7](https://dev.mysql.com/doc/refman/5.7/en/)

### Archivos del Proyecto
- `PROJECT_SUMMARY.md` - Resumen general del proyecto
- `README.md` - Instalación y uso general
- `INSTALLATION.md` - Guía de instalación detallada

---

## 👥 Soporte

### Documentación Incluida
1. **CHATBOT_PERSONALIZATION.md** - Guía técnica completa
2. **CHATBOT_FIELDS_REFERENCE.md** - Referencia rápida
3. **IMPLEMENTATION_SUMMARY.md** - Resumen de implementación
4. **database/README_CHATBOT_UPDATE.md** - Instalación SQL

### Contacto
- **Email:** admin@turibot.com
- **Proyecto:** [GitHub - TuriBot](https://github.com/danjohn007/TuriBot)

---

## ✅ Checklist de Implementación

- [x] Script SQL creado y probado
- [x] Interfaz administrativa completa
- [x] Backend con validaciones
- [x] Modelo con upsert automático
- [x] Manejo de checkboxes
- [x] Documentación completa (5 archivos)
- [x] Ejemplos de uso
- [x] Plantillas predefinidas
- [x] Validaciones de sintaxis
- [x] Listo para producción

---

## 🏆 Estado del Módulo

```
╔══════════════════════════════════════════════════════════╗
║                                                          ║
║          ✅ MÓDULO COMPLETAMENTE IMPLEMENTADO           ║
║                                                          ║
║         Estado: PRODUCCIÓN - LISTO PARA USO             ║
║         Cobertura: 100% de requisitos cumplidos         ║
║                                                          ║
║     🌟 PERSONALIZACIÓN COMPLETA DEL CHATBOT 🌟          ║
║                                                          ║
╚══════════════════════════════════════════════════════════╝
```

---

**Versión:** 1.0.0  
**Fecha:** 2024  
**Autor:** TuriBot Development Team  
**Licencia:** MIT  
**Estado:** ✅ Producción
