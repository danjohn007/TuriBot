# Guía de Pruebas - TuriBot

## Lista de Verificación para Probar los Cambios

### 1. Menú de Configuración ✓
**Objetivo:** Verificar que solo existe un ítem de configuración en el menú

**Pasos:**
1. Iniciar sesión como administrador
2. Observar el menú lateral izquierdo
3. Buscar la sección de configuración

**Resultado esperado:**
- ✅ Solo debe aparecer "Configuraciones Generales" con icono de sliders
- ✅ NO debe aparecer un ítem llamado "Configuración" con icono de engranaje

---

### 2. Actualización de Configuración ✓
**Objetivo:** Verificar que se puede guardar la configuración sin errores

**Pasos:**
1. Acceder a "Configuraciones Generales"
2. Modificar cualquier campo (ej. nombre del chatbot)
3. Hacer clic en "Guardar Configuración"

**Resultado esperado:**
- ✅ Debe mostrar mensaje "Configuración actualizada exitosamente"
- ✅ NO debe mostrar "Error al actualizar la configuración"
- ✅ Debe permanecer en la página de Configuraciones Generales

---

### 3. Configuración de Email ✓
**Objetivo:** Verificar que existe la sección de configuración de email

**Pasos:**
1. En "Configuraciones Generales", desplazarse hacia abajo
2. Buscar la sección "Configuración de Email"

**Resultado esperado:**
- ✅ Debe aparecer una sección con icono de sobre
- ✅ Debe contener campos:
  - Host SMTP
  - Puerto SMTP
  - Usuario SMTP
  - Contraseña SMTP
  - Email Remitente
  - Nombre Remitente
  - Tipo de Encriptación
- ✅ Debe haber una nota informativa sobre el uso de estos datos

---

### 4. Visualización del Chatbot Público ✓
**Objetivo:** Verificar que el logo y nombre se muestran correctamente

**Pasos:**
1. Configurar un nombre personalizado para el chatbot (ej. "Guía Turístico Virtual")
2. (Opcional) Configurar un avatar personalizado
3. Acceder a la URL pública del chatbot: `/chatbot`

**Resultado esperado:**
- ✅ El título de la página debe mostrar el nombre configurado
- ✅ El encabezado del chat debe mostrar el nombre configurado
- ✅ Si se configuró un avatar, debe mostrarse la imagen
- ✅ Si no hay avatar, debe mostrar el icono de robot
- ✅ Debe mostrar "En línea" con un punto verde

---

### 5. Enlaces en Hospedajes ✓
**Objetivo:** Verificar que aparecen enlaces de sitio web y reservación

**Pre-requisitos:**
- Tener al menos un hospedaje con `sitio_web` y/o `enlace_reservacion` configurados

**Pasos:**
1. En el chatbot público, escribir: "¿Dónde puedo hospedarme?"
2. Enviar el mensaje

**Resultado esperado:**
- ✅ Debe mostrar lista de hospedajes con información
- ✅ Para cada hospedaje con enlaces configurados, deben aparecer botones:
  - "Sitio Web" (si tiene sitio_web)
  - "Reservar" (si tiene enlace_reservacion)
- ✅ Los botones deben tener color degradado y abrir en nueva pestaña

---

### 6. Enlaces en Restaurantes ✓
**Objetivo:** Verificar que aparecen enlaces de sitio web y reservación

**Pre-requisitos:**
- Tener al menos un restaurante con `sitio_web` y/o `enlace_reservacion` configurados

**Pasos:**
1. En el chatbot público, escribir: "¿Dónde puedo comer?"
2. Enviar el mensaje

**Resultado esperado:**
- ✅ Debe mostrar lista de restaurantes con información
- ✅ Para cada restaurante con enlaces configurados, deben aparecer botones:
  - "Sitio Web" (si tiene sitio_web)
  - "Reservar" (si tiene enlace_reservacion)
- ✅ Los botones deben estar estilizados correctamente

---

### 7. Enlaces en Atracciones ✓
**Objetivo:** Verificar que aparecen enlaces de información adicional

**Pre-requisitos:**
- Tener al menos una atracción con `enlace_externo` configurado

**Pasos:**
1. En el chatbot público, escribir: "¿Qué lugares puedo visitar?"
2. Enviar el mensaje

**Resultado esperado:**
- ✅ Debe mostrar lista de atracciones con información
- ✅ Para cada atracción con enlace configurado, debe aparecer botón:
  - "Más información" (si tiene enlace_externo)
- ✅ El botón debe funcionar correctamente

---

### 8. Enlaces en Eventos ✓
**Objetivo:** Verificar que aparecen enlaces de compra de boletos

**Pre-requisitos:**
- Tener al menos un evento con `enlace_boletos` configurado

**Pasos:**
1. En el chatbot público, escribir: "¿Qué eventos hay?"
2. Enviar el mensaje

**Resultado esperado:**
- ✅ Debe mostrar lista de eventos con información
- ✅ Para cada evento con enlace configurado, debe aparecer botón:
  - "Comprar boletos" (si tiene enlace_boletos)
- ✅ El botón debe abrir el enlace en nueva pestaña

---

### 9. Solicitud de Datos de Contacto ✓
**Objetivo:** Verificar que aparece formulario de contacto después de mostrar resultados

**Pasos:**
1. En el chatbot público, hacer cualquier búsqueda (hospedajes, restaurantes, etc.)
2. Esperar que aparezcan los resultados
3. **Esperar 5 segundos**
4. Observar si aparece un formulario

**Resultado esperado:**
- ✅ Después de 5 segundos, debe aparecer un formulario preguntando:
  - "¿Te gustaría recibir un resumen de esta información?"
- ✅ El formulario debe tener campos para:
  - Nombre
  - Teléfono
  - Email
- ✅ Debe haber dos botones:
  - "Enviar" (azul con degradado)
  - "No, gracias" (gris)

**Probar envío de datos:**
1. Completar todos los campos
2. Hacer clic en "Enviar"
3. Debe mostrar: "¡Gracias! Te enviaremos la información a tu correo."
4. El formulario debe desaparecer

**Probar cancelación:**
1. Hacer clic en "No, gracias" sin llenar los campos
2. Debe mostrar: "¡De acuerdo! Si cambias de opinión, solo pregúntame."
3. El formulario debe desaparecer

---

### 10. Validación del Formulario de Contacto ✓
**Objetivo:** Verificar que se validan los campos requeridos

**Pasos:**
1. Aparecer el formulario de contacto (después de una búsqueda)
2. Dejar uno o más campos vacíos
3. Hacer clic en "Enviar"

**Resultado esperado:**
- ✅ Debe mostrar una alerta: "Por favor, completa todos los campos"
- ✅ El formulario no debe desaparecer

---

## Casos de Prueba con Base de Datos

### Datos de prueba recomendados:

#### Hospedaje de ejemplo:
```sql
INSERT INTO hospedajes (nombre, categoria, direccion, telefono, sitio_web, enlace_reservacion, activo, creado_por)
VALUES ('Hotel Paradise', 5, 'Av. Principal 123', '555-1234', 'https://hotelparadise.com', 'https://booking.com/hotel-paradise', 1, 1);
```

#### Restaurante de ejemplo:
```sql
INSERT INTO restaurantes (nombre, tipo_comida, direccion, telefono, sitio_web, enlace_reservacion, activo, creado_por)
VALUES ('Restaurante El Sabor', 'Comida Regional', 'Calle Centro 456', '555-5678', 'https://elsabor.com', 'https://reservas.elsabor.com', 1, 1);
```

#### Atracción de ejemplo:
```sql
INSERT INTO atracciones (nombre, descripcion, categoria, direccion, enlace_externo, activo, creado_por)
VALUES ('Museo de Arte', 'Museo con colecciones de arte regional', 'cultural', 'Plaza Mayor s/n', 'https://museoarte.com', 1, 1);
```

#### Evento de ejemplo:
```sql
INSERT INTO eventos (nombre, descripcion, fecha_inicio, fecha_fin, ubicacion, enlace_boletos, activo, creado_por)
VALUES ('Festival de Música', 'Festival anual de música regional', '2025-03-15', '2025-03-17', 'Parque Central', 'https://ticketmaster.com/festival', 1, 1);
```

---

## Checklist Final

Antes de dar por completas las pruebas, verificar:

- [ ] El menú solo tiene "Configuraciones Generales"
- [ ] Se puede guardar la configuración sin errores
- [ ] Existe la sección de configuración de email con todos los campos
- [ ] El nombre del chatbot se muestra en la vista pública
- [ ] El avatar/logo se muestra correctamente (o icono de robot si no hay)
- [ ] Los enlaces de hospedajes aparecen cuando hay datos
- [ ] Los enlaces de restaurantes aparecen cuando hay datos
- [ ] Los enlaces de atracciones aparecen cuando hay datos
- [ ] Los enlaces de eventos aparecen cuando hay datos
- [ ] El formulario de contacto aparece después de 5 segundos
- [ ] Se puede enviar el formulario con datos completos
- [ ] Se puede cancelar el formulario
- [ ] Se valida que todos los campos estén completos

---

## Notas Importantes

1. **Enlaces:** Para que aparezcan los enlaces, DEBEN existir registros con los campos correspondientes llenos en la base de datos
2. **Avatar:** El archivo de imagen debe existir en la carpeta `public/img/`
3. **Delay:** El formulario de contacto aparece exactamente 5 segundos después de mostrar resultados
4. **Navegadores:** Probar en Chrome, Firefox y Safari para compatibilidad

---

## Soporte

Si encuentras algún problema:

1. Verifica la consola del navegador para errores JavaScript
2. Verifica los logs de PHP para errores del servidor
3. Confirma que los datos existen en la base de datos
4. Verifica que los permisos de archivos son correctos

---

**Última actualización:** 2025
**Versión del sistema:** 1.0.0
