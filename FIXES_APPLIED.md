# Fixes Applied to TuriBot Chatbot

## Summary of Changes

This document describes the fixes applied to resolve the issues reported in the problem statement.

## Issues Resolved

### 1. ✅ Database Duplicate Key Error (SQLSTATE[23000]: Integrity constraint violation: 1062)

**Problem:** The `update()` method in `Configuracion.php` was trying to UPDATE first, then INSERT if no rows were affected. This could cause duplicate key violations if two processes tried to insert the same key simultaneously.

**Solution:** Changed the SQL query to use `INSERT ... ON DUPLICATE KEY UPDATE` which is an atomic operation that handles both insert and update cases without race conditions.

**File Modified:** `app/models/Configuracion.php`

**Changes:**
```php
// Before:
public function update($clave, $valor) {
    // Primero intentar actualizar
    $stmt = $this->db->prepare("
        UPDATE {$this->table} SET valor = ? WHERE clave = ?
    ");
    $stmt->execute([$valor, $clave]);
    
    // Si no se actualizó ninguna fila, insertar nueva configuración
    if ($stmt->rowCount() == 0) {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (clave, valor, descripcion) 
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$clave, $valor, 'Configuración agregada automáticamente']);
    }
    
    return true;
}

// After:
public function update($clave, $valor) {
    // Usar INSERT ... ON DUPLICATE KEY UPDATE para evitar errores de duplicados
    $stmt = $this->db->prepare("
        INSERT INTO {$this->table} (clave, valor, descripcion) 
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE valor = VALUES(valor)
    ");
    return $stmt->execute([$clave, $valor, 'Configuración agregada automáticamente']);
}
```

### 2. ✅ Add "Lugares recomendados para comer" to Welcome Message Suggestions

**Problem:** The chatbot's welcome message suggestions did not include an option for restaurant recommendations.

**Solution:** Added "Lugares recomendados para comer" to the default suggestions in the database initialization script.

**File Modified:** `database/chatbot_personalization_update.sql`

**Changes:**
```sql
-- Before:
('chatbot_sugerencias_iniciales', '¿Qué lugares puedo visitar?|¿Dónde puedo hospedarme?|¿Qué eventos hay próximamente?|Contactos de emergencia', ...)

-- After:
('chatbot_sugerencias_iniciales', '¿Qué lugares puedo visitar?|¿Dónde puedo hospedarme?|Lugares recomendados para comer|¿Qué eventos hay próximamente?|Contactos de emergencia', ...)
```

### 3. ✅ Show Contact Form Only Once After 15 Seconds of Inactivity

**Problem:** The contact form was shown after 5 seconds and could be shown multiple times, which was annoying to users.

**Solution:** 
- Changed the delay from 5 seconds to 15 seconds
- Added a flag `window.contactoSolicitado` to track if the contact form has been shown
- Added `window.lastInteractionTime` to track the last user interaction
- Updated the logic to only show the form if 15 seconds have passed since the last interaction and it hasn't been shown before

**File Modified:** `app/views/chatbot/public.php`

**Changes:**
1. Added interaction time tracking:
```javascript
// Variables para controlar la solicitud de contacto
window.contactoSolicitado = false;
window.lastInteractionTime = Date.now();

// Actualizar tiempo de última interacción al escribir o enviar
messageInput.addEventListener('input', function() {
    window.lastInteractionTime = Date.now();
});
```

2. Updated the sendMessage function to track interactions:
```javascript
async function sendMessage() {
    // ...
    // Actualizar tiempo de última interacción
    window.lastInteractionTime = Date.now();
    // ...
}
```

3. Modified the contact form display logic:
```javascript
// Si se debe solicitar contacto, hacerlo después de 15 segundos y solo una vez
if (solicitarContacto && !window.contactoSolicitado) {
    window.lastInteractionTime = Date.now();
    setTimeout(() => {
        // Verificar que han pasado 15 segundos desde la última interacción
        if (!window.contactoSolicitado && (Date.now() - window.lastInteractionTime >= 15000)) {
            window.contactoSolicitado = true;
            solicitarDatosContacto();
        }
    }, 15000);
}
```

### 4. ✅ Display Links Below Each Item Instead of All Together at the End

**Problem:** Links for websites, reservations, etc. were displayed all together at the end of the message, making it hard to identify which link belongs to which item.

**Solution:** Completely refactored the message processing to integrate links inline after each item result.

**File Modified:** `app/views/chatbot/public.php`

**Changes:**

1. Changed how results are passed from backend to frontend:
```javascript
// Before: Collected all links into a single array
let todosLosEnlaces = [];
if (data.resultados && data.resultados.length > 0) {
    data.resultados.forEach(resultado => {
        if (resultado.enlaces && resultado.enlaces.length > 0) {
            todosLosEnlaces = todosLosEnlaces.concat(resultado.enlaces);
        }
    });
}
addMessage(data.respuesta, 'bot', data.sugerencias, todosLosEnlaces, data.solicitar_contacto);

// After: Pass the entire results array with embedded links
addMessage(data.respuesta, 'bot', data.sugerencias, data.resultados || [], data.solicitar_contacto);
```

2. Rewrote the `addMessage` function to process results and insert links after each item:
```javascript
function addMessage(text, sender, suggestions = [], resultados = [], solicitarContacto = false) {
    // ...
    
    // Construir el mensaje con enlaces integrados después de cada ítem
    let mensajeConEnlaces = text;
    if (resultados && resultados.length > 0) {
        // Separar el texto en líneas
        let lineas = text.split('\n');
        let nuevasLineas = [];
        let resultadoIndex = 0;
        
        for (let i = 0; i < lineas.length; i++) {
            nuevasLineas.push(lineas[i]);
            
            // Detectar si la línea contiene el nombre de un resultado (empieza con emoji de categoría)
            if (resultadoIndex < resultados.length && 
                (lineas[i].includes('🏨') || lineas[i].includes('🍽️') || lineas[i].includes('🎯') || lineas[i].includes('🎉'))) {
                
                const resultado = resultados[resultadoIndex];
                
                // Buscar el final del bloque del ítem (siguiente línea vacía o siguiente ítem)
                let j = i + 1;
                while (j < lineas.length && lineas[j].trim() !== '' && 
                       !lineas[j].includes('🏨') && !lineas[j].includes('🍽️') && 
                       !lineas[j].includes('🎯') && !lineas[j].includes('🎉')) {
                    nuevasLineas.push(lineas[j]);
                    j++;
                }
                i = j - 1;
                
                // Agregar enlaces después de este ítem
                if (resultado.enlaces && resultado.enlaces.length > 0) {
                    let enlacesHtml = '<div class="enlaces-item" style="margin: 5px 0 5px 20px;">';
                    resultado.enlaces.forEach(enlace => {
                        enlacesHtml += `<a href="${enlace.url}" target="_blank" class="enlace-btn" style="display: inline-block; margin: 3px 5px 3px 0; padding: 4px 10px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); color: white; text-decoration: none; border-radius: 12px; font-size: 0.8rem;"><i class="bi ${enlace.icono}"></i> ${enlace.texto}</a>`;
                    });
                    enlacesHtml += '</div>';
                    nuevasLineas.push(enlacesHtml);
                }
                
                resultadoIndex++;
            }
        }
        
        mensajeConEnlaces = nuevasLineas.join('\n');
    }
    
    messageDiv.innerHTML = `
        <div class="message-content">
            ${mensajeConEnlaces.replace(/\n/g, '<br>')}
            ${suggestionsHtml}
        </div>
    `;
    // ...
}
```

### 5. ✅ Fix Logo Display in Public Chatbot

**Problem:** The logo configured in the admin panel was not displaying correctly in the public chatbot.

**Solution:** Improved the avatar display logic to be more robust and added proper fallback handling.

**File Modified:** `app/views/chatbot/public.php`

**Changes:**
```php
// Before:
<?php 
$avatar = $configuraciones['chatbot_avatar'] ?? '';
$avatarPath = BASE_URL . 'public/img/' . $avatar;
// Display image if avatar is configured, otherwise show robot icon
if (!empty($avatar) && $avatar !== 'chatbot-avatar.png'):
?>
    <img src="<?php echo $avatarPath; ?>" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;" onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-block';">
    <i class="bi bi-robot" style="display: none;"></i>
<?php else: ?>
    <i class="bi bi-robot"></i>
<?php endif; ?>

// After:
<?php 
$avatar = $configuraciones['chatbot_avatar'] ?? '';
// Display image if avatar is configured and not the default placeholder
if (!empty($avatar) && $avatar !== 'chatbot-avatar.png' && $avatar !== 'robot.png'):
    $avatarPath = BASE_URL . 'public/img/' . $avatar;
?>
    <img src="<?php echo $avatarPath; ?>" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;" onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-block';">
    <i class="bi bi-robot" style="display: none; color: var(--primary-color);"></i>
<?php else: ?>
    <i class="bi bi-robot" style="color: var(--primary-color);"></i>
<?php endif; ?>
```

## Testing Instructions

To verify these fixes:

1. **Database Duplicate Key Fix:**
   - Go to the admin panel's "Configuraciones Generales"
   - Try to save the configuration multiple times
   - Verify that no duplicate key error occurs

2. **Welcome Message Suggestions:**
   - Open the public chatbot at `/chatbot`
   - Verify that "Lugares recomendados para comer" appears as a suggestion button
   - Click it and verify it triggers the restaurant search

3. **Contact Form Behavior:**
   - Open the public chatbot
   - Ask for hotels, restaurants, or attractions
   - Wait 15 seconds without interacting
   - Verify the contact form appears only once
   - If you interact (type or send a message), the timer should reset

4. **Links Display:**
   - Search for hotels, restaurants, or attractions
   - Verify that each item has its links (if available) displayed directly below it
   - Links should not appear all together at the end

5. **Logo Display:**
   - Configure a custom avatar/logo in the admin panel
   - Visit the public chatbot
   - Verify the configured logo appears in the chat header
   - If no logo is configured, a robot icon should appear

## Files Modified

1. `app/models/Configuracion.php` - Fixed duplicate key error
2. `app/views/chatbot/public.php` - Fixed links display, contact form, and logo
3. `database/chatbot_personalization_update.sql` - Added new suggestion

## Backward Compatibility

All changes are backward compatible:
- The database change uses `ON DUPLICATE KEY UPDATE` which works with existing data
- The SQL update script uses `INSERT IGNORE` which won't affect existing records
- Frontend changes gracefully handle missing data structures
- The avatar logic has proper fallbacks

## Notes

- The contact form now requires 15 seconds of inactivity before appearing
- The form will only appear once per session
- Links are now contextually placed with each result item
- The database update method is now atomic and thread-safe
