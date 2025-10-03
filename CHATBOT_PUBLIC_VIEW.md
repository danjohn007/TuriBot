# Vista Pública del ChatBot - TuriBot

## 📋 Descripción

Implementación completa de una vista pública del chatbot que permite a los usuarios interactuar con el asistente turístico sin necesidad de autenticación. El chatbot responde según las configuraciones establecidas en el panel administrativo.

## 🚀 Características Implementadas

### 1. Interfaz Pública del ChatBot
- **URL de acceso**: `/chatbot`
- **Sin autenticación requerida**
- **Diseño moderno y responsive**
- **Colores configurables desde admin**

### 2. Funcionalidades del ChatBot

#### Búsquedas Inteligentes:
- 🏨 **Hospedajes**: Hoteles, hostales, alojamientos
- 🍽️ **Restaurantes**: Lugares para comer
- 🎯 **Atracciones**: Lugares turísticos y culturales
- 🎉 **Eventos**: Actividades y eventos próximos
- 🚨 **Emergencias**: Números de contacto de emergencia

#### Interacciones Naturales:
- ✅ Reconocimiento de saludos (Hola, Buenos días, etc.)
- ✅ Respuestas a agradecimientos (Gracias, etc.)
- ✅ Mensajes de despedida (Adiós, Hasta luego, etc.)
- ✅ Sugerencias de preguntas frecuentes
- ✅ Indicador de "escribiendo..."

### 3. Integración con Configuración

El chatbot lee TODAS las configuraciones del panel admin:

**Apariencia:**
- Nombre del chatbot
- Avatar/Logo
- Colores primario y secundario

**Mensajes:**
- Mensaje de bienvenida
- Respuestas personalizadas
- Mensajes de error
- Texto de resultados

**Comportamiento:**
- Velocidad de respuesta (instantánea, rápida, normal, lenta)
- Mostrar/ocultar indicador de escritura
- Mostrar/ocultar sugerencias
- Horario de atención (24/7 o personalizado)

**Funcionalidades:**
- Activar/desactivar búsquedas por categoría
- Activar/desactivar contactos de emergencia

### 4. Botón Flotante en Login

- **Ubicación**: Esquina inferior derecha
- **Diseño**: Botón con icono de robot 🤖
- **Animación**: Efecto pulsante atractivo
- **Texto**: "Prueba el ChatBot"
- **Funcionalidad**: Navega directamente a `/chatbot`

## 🔧 Archivos Creados/Modificados

### Archivos Nuevos:

1. **`app/controllers/ChatbotController.php`** (450+ líneas)
   - Controlador principal del chatbot
   - Método `index()`: Vista pública
   - Método `config()`: API de configuración
   - Método `chat()`: API de procesamiento de mensajes
   - Lógica de detección de palabras clave
   - Integración con modelos de datos

2. **`app/views/chatbot/public.php`** (400+ líneas)
   - Interfaz de usuario del chat
   - HTML, CSS y JavaScript integrados
   - Diseño responsive
   - Animaciones suaves

3. **`router.php`** (Para servidor de desarrollo)
   - Enrutador para PHP built-in server
   - Simula comportamiento de .htaccess
   - Permite URLs limpias

### Archivos Modificados:

1. **`app/views/auth/login.php`**
   - Añadido botón flotante de ChatBot
   - Estilos CSS para el botón
   - Animación pulsante

## 📡 API Endpoints

### 1. Vista Pública
```
GET /chatbot
```
Retorna la interfaz HTML del chatbot.

### 2. Obtener Configuración
```
GET /chatbot/config
```
Retorna JSON con la configuración del chatbot:
```json
{
  "nombre": "TuriBot",
  "activado": true,
  "colorPrimario": "#667eea",
  "colorSecundario": "#764ba2",
  "mensajeBienvenida": "¡Bienvenido!",
  "funcionalidades": {
    "hospedajes": true,
    "restaurantes": true,
    ...
  }
}
```

### 3. Procesar Mensaje
```
POST /chatbot/chat
Content-Type: application/json

{
  "mensaje": "¿Dónde puedo hospedarme?"
}
```

Retorna:
```json
{
  "respuesta": "Encontré estas opciones...",
  "tipo": "hospedajes",
  "resultados": [...]
}
```

## 💡 Ejemplos de Uso

### Desde el Usuario:

1. **Acceder al Chatbot:**
   - Ir a la página de login
   - Hacer clic en el botón "Prueba el ChatBot"
   - O visitar directamente: `https://tudominio.com/chatbot`

2. **Interactuar:**
   - Usar botones de sugerencias
   - Escribir mensajes naturales
   - Recibir respuestas instantáneas

### Consultas de Ejemplo:

```
Usuario: Hola
Bot: ¡Hola! Soy TuriBot, tu guía turístico virtual. ¿En qué puedo ayudarte hoy?

Usuario: ¿Dónde puedo hospedarme?
Bot: Encontré estas opciones para ti:
     🏨 Hotel Plaza Central
     📍 Av. Principal 123
     📞 555-1234
     ...

Usuario: Contactos de emergencia
Bot: 🚨 Contactos de Emergencia:
     📞 Policía: 911
     📞 Bomberos: 119
     ...

Usuario: Gracias
Bot: ¡De nada! Es un placer ayudarte. ¿Hay algo más en lo que pueda asistirte?

Usuario: Adiós
Bot: ¡Hasta pronto! Espero haberte ayudado. Vuelve cuando quieras.
```

## 🎨 Personalización

### Desde el Panel Admin:

1. **Ir a**: Configuración → Configuraciones Generales
2. **Buscar sección**: "Configuración del ChatBot"
3. **Modificar**:
   - Nombre del bot
   - Mensajes personalizados
   - Colores
   - Horarios
   - Funcionalidades activas
4. **Guardar**: Los cambios se aplican inmediatamente

### Colores Personalizados:

Los colores se aplican en:
- Fondo del header
- Botones de envío
- Mensajes del usuario
- Botones de sugerencias

### Mensajes Personalizados:

Todos los mensajes son configurables:
- Bienvenida
- Saludos
- Despedidas
- Agradecimientos
- Errores
- Sin resultados
- Cargando
- Fuera de horario

## 🛠️ Instalación y Configuración

### Para Desarrollo (PHP Built-in Server):

```bash
cd /ruta/al/proyecto
php -S localhost:8000 router.php
```

Luego visitar: `http://localhost:8000/chatbot`

### Para Producción (Apache/Nginx):

El archivo `.htaccess` ya está configurado. Solo asegúrate de que:

1. Mod_rewrite esté activado (Apache)
2. Las rewrite rules estén configuradas (Nginx)
3. La base de datos tenga las configuraciones del chatbot

### Verificar Configuración:

```sql
-- Ver configuraciones del chatbot
SELECT * FROM configuracion WHERE clave LIKE 'chatbot%';
```

## 🧪 Testing

### Pruebas Realizadas:

✅ Navegación desde login al chatbot  
✅ Carga de configuración desde BD  
✅ Respuesta a saludos  
✅ Búsqueda de hospedajes  
✅ Búsqueda de restaurantes  
✅ Búsqueda de atracciones  
✅ Búsqueda de eventos  
✅ Contactos de emergencia  
✅ Botones de sugerencias  
✅ Input manual de texto  
✅ Indicador de escritura  
✅ Animaciones y transiciones  
✅ Responsive design

### Pruebas Recomendadas:

1. **Funcionalidad básica:**
   ```
   - Escribir "Hola"
   - Escribir "¿Dónde puedo hospedarme?"
   - Escribir "Contactos de emergencia"
   - Escribir "Gracias"
   - Escribir "Adiós"
   ```

2. **Botones de sugerencias:**
   - Hacer clic en cada botón de sugerencia
   - Verificar respuestas apropiadas

3. **Configuración:**
   - Cambiar colores en admin
   - Cambiar mensajes
   - Desactivar funcionalidades
   - Verificar que los cambios se reflejen

## 📱 Responsive Design

El chatbot es totalmente responsive:

- **Desktop**: Chat centrado, tamaño óptimo
- **Tablet**: Se adapta al ancho de pantalla
- **Mobile**: Ocupa toda la pantalla, teclado optimizado

## 🔐 Seguridad

- ✅ Validación de inputs
- ✅ Escape de HTML en outputs
- ✅ Sanitización de URLs
- ✅ Límite de caracteres en mensajes
- ✅ Protección contra XSS
- ✅ Rate limiting (configurable)

## 📊 Estadísticas y Logs

**Futuras mejoras sugeridas:**

1. Guardar conversaciones en BD
2. Analytics de preguntas frecuentes
3. Dashboard de uso del chatbot
4. Reportes de satisfacción
5. A/B testing de mensajes

## 🐛 Solución de Problemas

### Problema: El chatbot no carga

**Solución:**
1. Verificar que existe el archivo `app/controllers/ChatbotController.php`
2. Verificar permisos de archivos
3. Revisar logs de PHP

### Problema: No muestra datos

**Solución:**
1. Verificar conexión a BD
2. Verificar que existan registros en las tablas
3. Revisar configuración en tabla `configuracion`

### Problema: Colores no se aplican

**Solución:**
1. Verificar valores en BD: `chatbot_color_primario` y `chatbot_color_secundario`
2. Deben ser códigos hexadecimales válidos (ej: #667eea)
3. Limpiar caché del navegador

## 📚 Documentación Relacionada

- `CHATBOT_PERSONALIZATION.md` - Configuración completa del chatbot
- `IMPLEMENTATION_SUMMARY.md` - Resumen de implementación
- `README.md` - Documentación general del proyecto

## 🎯 Próximos Pasos Sugeridos

1. **Mejorar NLP**: Implementar procesamiento más avanzado
2. **Machine Learning**: Aprendizaje de patrones de consulta
3. **Multiidioma**: Soporte para inglés y francés
4. **Integración con APIs**: Clima, mapas, reservas
5. **Chat histórico**: Guardar conversaciones
6. **Feedback del usuario**: Sistema de calificación
7. **Notificaciones**: Alertas de eventos próximos

## 📞 Soporte

Para dudas o problemas:
- Revisar este documento
- Consultar `CHATBOT_PERSONALIZATION.md`
- Revisar logs de error de PHP
- Verificar configuración en BD

---

**Versión**: 1.0.0  
**Fecha**: Octubre 2025  
**Estado**: ✅ Implementado y Funcional  
**Desarrollado por**: GitHub Copilot
