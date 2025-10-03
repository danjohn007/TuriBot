<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($configuraciones['chatbot_nombre'] ?? 'TuriBot'); ?> - ChatBot Turístico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: <?php echo $configuraciones['chatbot_color_primario'] ?? '#667eea'; ?>;
            --secondary-color: <?php echo $configuraciones['chatbot_color_secundario'] ?? '#764ba2'; ?>;
        }
        
        body {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .chat-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            max-width: 800px;
            width: 100%;
            height: 90vh;
            display: flex;
            flex-direction: column;
        }
        
        .chat-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 20px 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .chat-header-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .chat-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .chat-name h4 {
            margin: 0;
            font-size: 1.3rem;
            font-weight: 600;
        }
        
        .chat-status {
            font-size: 0.85rem;
            opacity: 0.9;
        }
        
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 25px;
            background: #f8f9fa;
        }
        
        .message {
            display: flex;
            margin-bottom: 20px;
            animation: slideIn 0.3s ease;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .message.bot {
            justify-content: flex-start;
        }
        
        .message.user {
            justify-content: flex-end;
        }
        
        .message-content {
            max-width: 70%;
            padding: 12px 18px;
            border-radius: 18px;
            word-wrap: break-word;
        }
        
        .message.bot .message-content {
            background: white;
            color: #333;
            border-bottom-left-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .message.user .message-content {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border-bottom-right-radius: 4px;
        }
        
        .typing-indicator {
            display: none;
            padding: 12px 18px;
            background: white;
            border-radius: 18px;
            border-bottom-left-radius: 4px;
            width: fit-content;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .typing-indicator span {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--primary-color);
            margin: 0 2px;
            animation: typing 1.4s infinite;
        }
        
        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }
        
        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }
        
        @keyframes typing {
            0%, 60%, 100% {
                transform: translateY(0);
            }
            30% {
                transform: translateY(-10px);
            }
        }
        
        .suggestions {
            display: flex;
            gap: 8px;
            margin-top: 10px;
            flex-wrap: wrap;
        }
        
        .suggestion-btn {
            background: white;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .suggestion-btn:hover {
            background: var(--primary-color);
            color: white;
        }
        
        .chat-input-area {
            padding: 20px 25px;
            background: white;
            border-top: 1px solid #e0e0e0;
        }
        
        .input-group {
            display: flex;
            gap: 10px;
        }
        
        #messageInput {
            flex: 1;
            border: 2px solid #e0e0e0;
            border-radius: 25px;
            padding: 12px 20px;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.3s;
        }
        
        #messageInput:focus {
            border-color: var(--primary-color);
        }
        
        #sendButton {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        #sendButton:hover {
            transform: scale(1.05);
        }
        
        #sendButton:active {
            transform: scale(0.95);
        }
        
        .back-to-login {
            color: white;
            text-decoration: none;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
            opacity: 0.9;
            transition: opacity 0.3s;
        }
        
        .back-to-login:hover {
            opacity: 1;
            color: white;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <div class="chat-header-info">
                <div class="chat-avatar">
                    <?php 
                    $avatar = $configuraciones['chatbot_avatar'] ?? 'chatbot-avatar.png';
                    $avatarPath = BASE_URL . 'public/img/' . $avatar;
                    // Check if avatar file is specified and not empty
                    if (!empty($avatar) && $avatar !== 'chatbot-avatar.png' && file_exists($_SERVER['DOCUMENT_ROOT'] . '/public/img/' . $avatar)):
                    ?>
                        <img src="<?php echo $avatarPath; ?>" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    <?php else: ?>
                        <i class="bi bi-robot"></i>
                    <?php endif; ?>
                </div>
                <div class="chat-name">
                    <h4><?php echo htmlspecialchars($configuraciones['chatbot_nombre'] ?? 'TuriBot'); ?></h4>
                    <div class="chat-status">
                        <i class="bi bi-circle-fill" style="font-size: 0.6rem;"></i> En línea
                    </div>
                </div>
            </div>
            <a href="<?php echo BASE_URL; ?>auth/login" class="back-to-login">
                <i class="bi bi-box-arrow-left"></i> Admin
            </a>
        </div>
        
        <div class="chat-messages" id="chatMessages">
            <div class="message bot">
                <div class="message-content">
                    <?php echo nl2br(htmlspecialchars($configuraciones['mensaje_bienvenida'] ?? '¡Bienvenido! ¿En qué puedo ayudarte?')); ?>
                    
                    <?php 
                    $sugerencias = explode('|', $configuraciones['chatbot_sugerencias_iniciales'] ?? '');
                    if (($configuraciones['chatbot_mostrar_sugerencias'] ?? '1') == '1' && !empty($sugerencias[0])): 
                    ?>
                    <div class="suggestions">
                        <?php foreach (array_filter($sugerencias) as $sugerencia): ?>
                            <button class="suggestion-btn" onclick="sendSuggestion('<?php echo htmlspecialchars($sugerencia, ENT_QUOTES); ?>')">
                                <?php echo htmlspecialchars($sugerencia); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="typing-indicator" id="typingIndicator">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        
        <div class="chat-input-area">
            <div class="input-group">
                <input type="text" id="messageInput" placeholder="Escribe tu mensaje..." autocomplete="off">
                <button id="sendButton" onclick="sendMessage()">
                    <i class="bi bi-send-fill"></i>
                </button>
            </div>
        </div>
    </div>

    <script>
        const BASE_URL = '<?php echo BASE_URL; ?>';
        const MOSTRAR_ESCRIBIENDO = <?php echo ($configuraciones['chatbot_mostrar_escribiendo'] ?? '1') == '1' ? 'true' : 'false'; ?>;
        const VELOCIDAD_RESPUESTA = '<?php echo $configuraciones['chatbot_velocidad_respuesta'] ?? 'normal'; ?>';
        
        const messageInput = document.getElementById('messageInput');
        const chatMessages = document.getElementById('chatMessages');
        const typingIndicator = document.getElementById('typingIndicator');
        
        // Enviar con Enter
        messageInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
        
        // Función para enviar mensaje
        async function sendMessage() {
            const mensaje = messageInput.value.trim();
            
            if (!mensaje) return;
            
            // Agregar mensaje del usuario
            addMessage(mensaje, 'user');
            
            // Limpiar input
            messageInput.value = '';
            
            // Mostrar indicador de escritura
            if (MOSTRAR_ESCRIBIENDO) {
                showTypingIndicator();
            }
            
            try {
                // Enviar al backend
                const response = await fetch(BASE_URL + 'chatbot/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ mensaje: mensaje })
                });
                
                const data = await response.json();
                
                // Simular delay según velocidad configurada
                const delays = {
                    'instantanea': 0,
                    'rapida': 300,
                    'normal': 800,
                    'lenta': 1500
                };
                const delay = delays[VELOCIDAD_RESPUESTA] || 800;
                
                setTimeout(() => {
                    hideTypingIndicator();
                    
                    // Procesar enlaces de los resultados
                    let todosLosEnlaces = [];
                    if (data.resultados && data.resultados.length > 0) {
                        data.resultados.forEach(resultado => {
                            if (resultado.enlaces && resultado.enlaces.length > 0) {
                                todosLosEnlaces = todosLosEnlaces.concat(resultado.enlaces);
                            }
                        });
                    }
                    
                    addMessage(data.respuesta, 'bot', data.sugerencias, todosLosEnlaces, data.solicitar_contacto);
                }, delay);
                
            } catch (error) {
                console.error('Error:', error);
                hideTypingIndicator();
                addMessage('Lo siento, hubo un error. Por favor, intenta de nuevo.', 'bot');
            }
        }
        
        // Función para agregar mensaje al chat
        function addMessage(text, sender, suggestions = [], enlaces = [], solicitarContacto = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${sender}`;
            
            let suggestionsHtml = '';
            if (suggestions && suggestions.length > 0) {
                suggestionsHtml = '<div class="suggestions">';
                suggestions.forEach(sug => {
                    suggestionsHtml += `<button class="suggestion-btn" onclick="sendSuggestion('${sug.replace(/'/g, "\\'")}')">${sug}</button>`;
                });
                suggestionsHtml += '</div>';
            }
            
            // Agregar enlaces si existen
            let enlacesHtml = '';
            if (enlaces && enlaces.length > 0) {
                enlacesHtml = '<div class="enlaces-container" style="margin-top: 10px;">';
                enlaces.forEach(enlace => {
                    enlacesHtml += `<a href="${enlace.url}" target="_blank" class="enlace-btn" style="display: inline-block; margin: 5px 5px 0 0; padding: 5px 12px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); color: white; text-decoration: none; border-radius: 15px; font-size: 0.85rem;"><i class="bi ${enlace.icono}"></i> ${enlace.texto}</a>`;
                });
                enlacesHtml += '</div>';
            }
            
            messageDiv.innerHTML = `
                <div class="message-content">
                    ${text.replace(/\n/g, '<br>')}
                    ${enlacesHtml}
                    ${suggestionsHtml}
                </div>
            `;
            
            chatMessages.insertBefore(messageDiv, typingIndicator);
            scrollToBottom();
            
            // Si se debe solicitar contacto, hacerlo después de 5 segundos
            if (solicitarContacto) {
                setTimeout(() => {
                    solicitarDatosContacto();
                }, 5000);
            }
        }
        
        // Función para enviar sugerencia
        function sendSuggestion(text) {
            messageInput.value = text;
            sendMessage();
        }
        
        // Mostrar indicador de escritura
        function showTypingIndicator() {
            typingIndicator.style.display = 'block';
            scrollToBottom();
        }
        
        // Ocultar indicador de escritura
        function hideTypingIndicator() {
            typingIndicator.style.display = 'none';
        }
        
        // Scroll al final del chat
        function scrollToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
        
        // Función para solicitar datos de contacto
        function solicitarDatosContacto() {
            const formHtml = `
                <div style="margin-top: 10px; padding: 15px; background: #f8f9fa; border-radius: 10px;">
                    <p style="margin-bottom: 10px; font-weight: 600;">¿Te gustaría recibir un resumen de esta información?</p>
                    <div style="margin-bottom: 8px;">
                        <input type="text" id="contacto_nombre" placeholder="Tu nombre" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 8px;">
                    </div>
                    <div style="margin-bottom: 8px;">
                        <input type="tel" id="contacto_telefono" placeholder="Tu teléfono" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 8px;">
                    </div>
                    <div style="margin-bottom: 8px;">
                        <input type="email" id="contacto_email" placeholder="Tu email" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 8px;">
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <button onclick="enviarDatosContacto()" style="flex: 1; padding: 8px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); color: white; border: none; border-radius: 5px; cursor: pointer;">Enviar</button>
                        <button onclick="cancelarContacto()" style="padding: 8px 15px; background: #6c757d; color: white; border: none; border-radius: 5px; cursor: pointer;">No, gracias</button>
                    </div>
                </div>
            `;
            
            const messageDiv = document.createElement('div');
            messageDiv.className = 'message bot';
            messageDiv.id = 'contacto-form-message';
            messageDiv.innerHTML = `<div class="message-content">${formHtml}</div>`;
            
            chatMessages.insertBefore(messageDiv, typingIndicator);
            scrollToBottom();
        }
        
        // Función para enviar datos de contacto
        function enviarDatosContacto() {
            const nombre = document.getElementById('contacto_nombre').value.trim();
            const telefono = document.getElementById('contacto_telefono').value.trim();
            const email = document.getElementById('contacto_email').value.trim();
            
            if (!nombre || !telefono || !email) {
                alert('Por favor, completa todos los campos');
                return;
            }
            
            // Aquí podrías enviar los datos al servidor
            // Por ahora solo mostramos un mensaje de confirmación
            const formMessage = document.getElementById('contacto-form-message');
            if (formMessage) {
                formMessage.remove();
            }
            
            addMessage('¡Gracias! Te enviaremos la información a tu correo.', 'bot');
        }
        
        // Función para cancelar solicitud de contacto
        function cancelarContacto() {
            const formMessage = document.getElementById('contacto-form-message');
            if (formMessage) {
                formMessage.remove();
            }
            addMessage('¡De acuerdo! Si cambias de opinión, solo pregúntame.', 'bot');
        }
        
        // Scroll inicial
        scrollToBottom();
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
