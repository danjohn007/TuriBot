# Referencia Rápida: Campos de Configuración del ChatBot

## 📋 Lista Completa de Campos (36 total)

### 🔧 Configuración Básica (4)
| Campo | Tipo | Valores | Defecto |
|-------|------|---------|---------|
| `chatbot_nombre` | texto | Cualquier texto | TuriBot |
| `chatbot_activado` | boolean | 0, 1 | 1 |
| `chatbot_idioma` | select | es, en, fr | es |
| `chatbot_tono_conversacion` | select | formal, amigable, casual, profesional | amigable |

### 💬 Mensajes Personalizados (7)
| Campo | Tipo | Uso |
|-------|------|-----|
| `mensaje_bienvenida` | textarea | Primer mensaje al abrir chat |
| `chatbot_respuesta_saludos` | textarea | Cuando usuario saluda |
| `chatbot_mensaje_despedida` | textarea | Al cerrar conversación |
| `chatbot_respuesta_agradecimiento` | textarea | Cuando usuario agradece |
| `chatbot_mensaje_no_entendido` | textarea | No comprende pregunta |
| `chatbot_mensaje_error` | textarea | Error técnico |
| `chatbot_mensaje_fuera_horario` | textarea | Fuera de horario |

### 🔍 Mensajes de Búsqueda (3)
| Campo | Tipo | Uso |
|-------|------|-----|
| `chatbot_mensaje_cargando` | texto | Procesando consulta |
| `chatbot_mensaje_lista_resultados` | texto | Antes de mostrar lista |
| `chatbot_mensaje_sin_resultados` | texto | Sin coincidencias |

### ⚙️ Comportamiento (6)
| Campo | Tipo | Valores | Defecto |
|-------|------|---------|---------|
| `chatbot_mostrar_sugerencias` | boolean | 0, 1 | 1 |
| `chatbot_mostrar_escribiendo` | boolean | 0, 1 | 1 |
| `chatbot_velocidad_respuesta` | select | lenta, normal, rapida, instantanea | normal |
| `chatbot_tiempo_respuesta_max` | number | 5-120 | 30 |
| `chatbot_limite_consultas_dia` | number | 0-∞ | 100 |
| `chatbot_sugerencias_iniciales` | texto | Separadas por \| | Ver defecto |

### 🕐 Horarios (4)
| Campo | Tipo | Formato | Defecto |
|-------|------|---------|---------|
| `chatbot_atencion_247` | boolean | 0, 1 | 1 |
| `chatbot_horario_inicio` | time | HH:MM | 08:00 |
| `chatbot_horario_fin` | time | HH:MM | 22:00 |
| `chatbot_dias_atencion` | texto | Separados por comas | Todos |

### ⭐ Funcionalidades (6 toggles)
| Campo | Tipo | Función |
|-------|------|---------|
| `chatbot_buscar_hospedajes` | boolean | Búsqueda de hoteles |
| `chatbot_buscar_restaurantes` | boolean | Búsqueda de restaurantes |
| `chatbot_buscar_atracciones` | boolean | Búsqueda de atracciones |
| `chatbot_buscar_eventos` | boolean | Consulta de eventos |
| `chatbot_emergencias` | boolean | Números de emergencia |
| `chatbot_recomendaciones` | boolean | Sugerencias personalizadas |

### 🎨 Apariencia (3)
| Campo | Tipo | Formato | Defecto |
|-------|------|---------|---------|
| `chatbot_avatar` | texto | nombre.ext | chatbot-avatar.png |
| `chatbot_color_primario` | color | #RRGGBB | #667eea |
| `chatbot_color_secundario` | color | #RRGGBB | #764ba2 |

### 📊 Analítica (3)
| Campo | Tipo | Propósito |
|-------|------|-----------|
| `chatbot_guardar_conversaciones` | boolean | Historial para análisis |
| `chatbot_solicitar_feedback` | boolean | Calificación usuario |
| `chatbot_aprendizaje_activo` | boolean | Machine Learning |

## 🔢 Resumen por Tipo

- **Texto libre**: 13 campos
- **Boolean (0/1)**: 13 campos
- **Select (opciones)**: 4 campos
- **Número**: 2 campos
- **Time (HH:MM)**: 2 campos
- **Color (#hex)**: 2 campos

**TOTAL**: 36 campos

## 📝 Plantillas Listas para Usar

### Plantilla 1: Formal Oficial
```sql
UPDATE configuracion SET valor = 'formal' WHERE clave = 'chatbot_tono_conversacion';
UPDATE configuracion SET valor = 'Buenos días. Bienvenido al sistema de información turística oficial del municipio.' WHERE clave = 'mensaje_bienvenida';
UPDATE configuracion SET valor = 'Buenos días. ¿En qué puedo asistirle?' WHERE clave = 'chatbot_respuesta_saludos';
```

### Plantilla 2: Amigable (Defecto)
```sql
UPDATE configuracion SET valor = 'amigable' WHERE clave = 'chatbot_tono_conversacion';
UPDATE configuracion SET valor = '¡Bienvenido a TuriBot! Tu asistente turístico virtual.' WHERE clave = 'mensaje_bienvenida';
UPDATE configuracion SET valor = '¡Hola! Soy TuriBot, tu guía turístico virtual. ¿En qué puedo ayudarte hoy?' WHERE clave = 'chatbot_respuesta_saludos';
```

### Plantilla 3: Casual Joven
```sql
UPDATE configuracion SET valor = 'casual' WHERE clave = 'chatbot_tono_conversacion';
UPDATE configuracion SET valor = '¡Hey! 👋 ¿Listo para descubrir lugares increíbles?' WHERE clave = 'mensaje_bienvenida';
UPDATE configuracion SET valor = '¡Hola! ¿Qué onda? ¿Buscas algo cool para hacer?' WHERE clave = 'chatbot_respuesta_saludos';
```

### Plantilla 4: Horario Limitado
```sql
UPDATE configuracion SET valor = '0' WHERE clave = 'chatbot_atencion_247';
UPDATE configuracion SET valor = '09:00' WHERE clave = 'chatbot_horario_inicio';
UPDATE configuracion SET valor = '17:00' WHERE clave = 'chatbot_horario_fin';
UPDATE configuracion SET valor = 'Lunes,Martes,Miércoles,Jueves,Viernes' WHERE clave = 'chatbot_dias_atencion';
```

### Plantilla 5: Solo Info Básica
```sql
UPDATE configuracion SET valor = '1' WHERE clave = 'chatbot_buscar_hospedajes';
UPDATE configuracion SET valor = '1' WHERE clave = 'chatbot_buscar_restaurantes';
UPDATE configuracion SET valor = '0' WHERE clave = 'chatbot_buscar_atracciones';
UPDATE configuracion SET valor = '0' WHERE clave = 'chatbot_buscar_eventos';
UPDATE configuracion SET valor = '1' WHERE clave = 'chatbot_emergencias';
UPDATE configuracion SET valor = '0' WHERE clave = 'chatbot_recomendaciones';
```

## 🔍 Consultas Útiles

### Ver todas las configuraciones del chatbot
```sql
SELECT clave, LEFT(valor, 50) as valor_resumido, descripcion 
FROM configuracion 
WHERE clave LIKE 'chatbot_%' OR clave = 'mensaje_bienvenida'
ORDER BY clave;
```

### Contar configuraciones por categoría
```sql
SELECT 
  CASE 
    WHEN clave IN ('chatbot_nombre', 'chatbot_activado', 'chatbot_idioma', 'chatbot_tono_conversacion') THEN 'Básicas'
    WHEN clave LIKE '%mensaje%' OR clave LIKE '%respuesta%' THEN 'Mensajes'
    WHEN clave LIKE '%horario%' OR clave LIKE '%atencion%' OR clave LIKE '%dias%' THEN 'Horarios'
    WHEN clave LIKE '%buscar%' OR clave = 'chatbot_emergencias' OR clave = 'chatbot_recomendaciones' THEN 'Funcionalidades'
    WHEN clave LIKE '%color%' OR clave = 'chatbot_avatar' THEN 'Apariencia'
    ELSE 'Otros'
  END as categoria,
  COUNT(*) as total
FROM configuracion
WHERE clave LIKE 'chatbot_%' OR clave = 'mensaje_bienvenida'
GROUP BY categoria;
```

### Resetear a valores por defecto
```sql
-- Solo ejecutar si necesitas restaurar valores originales
-- ADVERTENCIA: Esto sobrescribirá las configuraciones personalizadas
DELETE FROM configuracion WHERE clave LIKE 'chatbot_%';
-- Luego re-ejecutar: chatbot_personalization_update.sql
```

## 🎯 Acceso Programático

### PHP
```php
// Obtener todas las configuraciones
$config = new Configuracion();
$conf = $config->getAllAsArray();

// Usar configuraciones
$nombre = $conf['chatbot_nombre'];
$activado = $conf['chatbot_activado'] == '1';
$tono = $conf['chatbot_tono_conversacion'];

// Actualizar una configuración
$config->update('chatbot_nombre', 'MiBot Personalizado');
```

### JavaScript (Frontend)
```javascript
// Asumiendo endpoint API
fetch('/api/chatbot/config')
  .then(res => res.json())
  .then(config => {
    const chatbot = new ChatBotWidget({
      nombre: config.chatbot_nombre,
      bienvenida: config.mensaje_bienvenida,
      colorPrimario: config.chatbot_color_primario,
      colorSecundario: config.chatbot_color_secundario,
      idioma: config.chatbot_idioma
    });
  });
```

## ⚠️ Notas Importantes

1. **Valores Boolean**: Usar '0' o '1' (como string)
2. **Colores**: Formato hexadecimal con # (#667eea)
3. **Horarios**: Formato 24h (HH:MM)
4. **Separadores**: 
   - Sugerencias: usar `|` (pipe)
   - Días: usar `,` (coma)
5. **Límite consultas**: 0 = ilimitado
6. **Checkboxes**: Si no están marcados = '0'

## 🔗 Ver También

- `CHATBOT_PERSONALIZATION.md` - Documentación completa
- `database/README_CHATBOT_UPDATE.md` - Instalación SQL
- `IMPLEMENTATION_SUMMARY.md` - Resumen de implementación

---

**Última actualización**: 2024  
**Versión**: 1.0.0  
**Total de campos**: 36
