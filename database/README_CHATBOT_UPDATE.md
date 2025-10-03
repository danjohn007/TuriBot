# Actualización de Base de Datos: Módulo ChatBot

## 📋 Descripción

Este script SQL agrega 35+ configuraciones nuevas para la personalización completa del ChatBot de TuriBot.

## 🚀 Instalación

### Opción 1: MySQL Command Line

```bash
mysql -u root -p turibot_db < chatbot_personalization_update.sql
```

### Opción 2: phpMyAdmin

1. Acceder a phpMyAdmin
2. Seleccionar la base de datos `turibot_db`
3. Ir a la pestaña **Importar**
4. Seleccionar el archivo `chatbot_personalization_update.sql`
5. Hacer clic en **Continuar**

### Opción 3: MySQL Workbench

1. Abrir MySQL Workbench
2. Conectar a la base de datos
3. File → Open SQL Script → Seleccionar `chatbot_personalization_update.sql`
4. Ejecutar (⚡ icono o Ctrl+Shift+Enter)

## ✅ Verificación

El script incluye verificaciones automáticas al final que muestran:

```sql
-- Cuenta total de configuraciones del chatbot
SELECT COUNT(*) as total_configuraciones_chatbot 
FROM configuracion 
WHERE clave LIKE 'chatbot_%' OR clave = 'mensaje_bienvenida';

-- Muestra todas las configuraciones
SELECT clave, valor, descripcion 
FROM configuracion 
WHERE clave LIKE 'chatbot_%' OR clave = 'mensaje_bienvenida'
ORDER BY clave;
```

**Resultado esperado**: Debe mostrar aproximadamente 35 configuraciones relacionadas con el chatbot.

## 🔒 Seguridad

- El script usa `INSERT IGNORE` para evitar duplicados
- No elimina ni modifica datos existentes
- Solo agrega nuevos registros de configuración
- Es seguro ejecutarlo múltiples veces

## 📊 Configuraciones Agregadas

### Categorías:

1. **Configuración Básica** (4 campos)
   - Nombre, estado, idioma, tono

2. **Mensajes Personalizados** (7 campos)
   - Bienvenida, despedida, saludos, error, etc.

3. **Mensajes de Búsqueda** (3 campos)
   - Carga, resultados, sin resultados

4. **Comportamiento** (6 campos)
   - Sugerencias, velocidad, límites, etc.

5. **Horarios** (4 campos)
   - Inicio, fin, días, 24/7

6. **Funcionalidades** (7 campos)
   - Hospedajes, restaurantes, atracciones, etc.

7. **Apariencia** (3 campos)
   - Avatar, colores

8. **Analítica** (3 campos)
   - Historial, feedback, aprendizaje

## 🔄 Rollback

Si necesitas revertir los cambios:

```sql
DELETE FROM configuracion 
WHERE clave LIKE 'chatbot_%' 
AND clave != 'mensaje_bienvenida';
```

⚠️ **Advertencia**: Esto eliminará todas las configuraciones del chatbot excepto el mensaje de bienvenida.

## 📝 Notas

- Las configuraciones se pueden editar desde el panel administrativo
- Los valores por defecto son amigables y funcionales
- Se recomienda revisar y ajustar según las necesidades
- La actualización es compatible con la versión 1.0.0 de TuriBot

## 🆘 Solución de Problemas

### Error: "Table 'configuracion' doesn't exist"

La tabla base no existe. Ejecutar primero:
```bash
mysql -u root -p turibot_db < turibot_schema.sql
```

### Error: "Access denied"

Verificar credenciales de acceso a MySQL en `config/config.php`

### Error: "Database doesn't exist"

Crear la base de datos primero:
```sql
CREATE DATABASE turibot_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## 📚 Documentación Adicional

- Ver: `CHATBOT_PERSONALIZATION.md` para documentación completa
- Ver: `PROJECT_SUMMARY.md` para información del proyecto
- Ver: `README.md` para guía de instalación general

---

**Versión**: 1.0.0  
**Compatibilidad**: TuriBot 1.0.0+  
**Base de Datos**: MySQL 5.7+
