-- Base de datos TuriBot
-- Sistema Administrativo de Chatbot Turístico
-- MySQL 5.7+

CREATE DATABASE IF NOT EXISTS turibot_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE turibot_db;

-- Tabla de usuarios y roles
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'editor', 'consultor') DEFAULT 'consultor',
    activo TINYINT(1) DEFAULT 1,
    token_recuperacion VARCHAR(255) NULL,
    token_expiracion DATETIME NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_rol (rol)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de log de actividades
CREATE TABLE IF NOT EXISTS log_actividades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    accion VARCHAR(255) NOT NULL,
    modulo VARCHAR(50) NOT NULL,
    detalles TEXT NULL,
    ip_address VARCHAR(45) NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    INDEX idx_usuario (usuario_id),
    INDEX idx_modulo (modulo),
    INDEX idx_fecha (fecha_creacion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de hospedajes (hoteles, hostales, cabañas)
CREATE TABLE IF NOT EXISTS hospedajes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(200) NOT NULL,
    categoria INT DEFAULT 1 CHECK (categoria BETWEEN 1 AND 5),
    direccion TEXT NOT NULL,
    telefono VARCHAR(20) NULL,
    enlace_reservacion TEXT NULL,
    sitio_web TEXT NULL,
    imagen VARCHAR(255) NULL,
    rango_precio_min DECIMAL(10,2) NULL,
    rango_precio_max DECIMAL(10,2) NULL,
    activo TINYINT(1) DEFAULT 1,
    creado_por INT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (creado_por) REFERENCES usuarios(id),
    INDEX idx_categoria (categoria),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de restaurantes
CREATE TABLE IF NOT EXISTS restaurantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(200) NOT NULL,
    tipo_comida VARCHAR(100) NOT NULL,
    direccion TEXT NOT NULL,
    telefono VARCHAR(20) NULL,
    whatsapp VARCHAR(20) NULL,
    enlace_reservacion TEXT NULL,
    sitio_web TEXT NULL,
    imagen VARCHAR(255) NULL,
    activo TINYINT(1) DEFAULT 1,
    creado_por INT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (creado_por) REFERENCES usuarios(id),
    INDEX idx_tipo_comida (tipo_comida),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de atracciones turísticas
CREATE TABLE IF NOT EXISTS atracciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(200) NOT NULL,
    descripcion TEXT NOT NULL,
    categoria ENUM('natural', 'cultural', 'historica', 'recreativa') NOT NULL,
    direccion TEXT NOT NULL,
    horario_apertura TIME NULL,
    horario_cierre TIME NULL,
    costo_acceso DECIMAL(10,2) DEFAULT 0.00,
    enlace_externo TEXT NULL,
    contacto VARCHAR(100) NULL,
    imagen VARCHAR(255) NULL,
    activo TINYINT(1) DEFAULT 1,
    creado_por INT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (creado_por) REFERENCES usuarios(id),
    INDEX idx_categoria (categoria),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de eventos
CREATE TABLE IF NOT EXISTS eventos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(200) NOT NULL,
    descripcion TEXT NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    ubicacion TEXT NOT NULL,
    enlace_boletos TEXT NULL,
    imagen VARCHAR(255) NULL,
    activo TINYINT(1) DEFAULT 1,
    creado_por INT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (creado_por) REFERENCES usuarios(id),
    INDEX idx_fecha_inicio (fecha_inicio),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de campañas promocionales
CREATE TABLE IF NOT EXISTS campanas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    mensaje TEXT NOT NULL,
    fecha_inicio DATETIME NOT NULL,
    fecha_fin DATETIME NOT NULL,
    activo TINYINT(1) DEFAULT 1,
    creado_por INT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (creado_por) REFERENCES usuarios(id),
    INDEX idx_fechas (fecha_inicio, fecha_fin),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de contactos de emergencia
CREATE TABLE IF NOT EXISTS emergencias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    numero VARCHAR(20) NOT NULL,
    descripcion TEXT NULL,
    tipo ENUM('cruz_roja', 'bomberos', 'policia', 'proteccion_civil', 'otro') NOT NULL,
    activo TINYINT(1) DEFAULT 1,
    creado_por INT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (creado_por) REFERENCES usuarios(id),
    INDEX idx_tipo (tipo),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de configuración general
CREATE TABLE IF NOT EXISTS configuracion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    clave VARCHAR(100) UNIQUE NOT NULL,
    valor TEXT NULL,
    descripcion TEXT NULL,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_clave (clave)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar datos de ejemplo
-- Usuario administrador por defecto (contraseña: admin123)
INSERT INTO usuarios (nombre, email, password, rol, activo) VALUES
('Administrador', 'admin@turibot.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1),
('Editor TuriBot', 'editor@turibot.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'editor', 1),
('Consultor', 'consultor@turibot.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'consultor', 1);

-- Hospedajes de ejemplo
INSERT INTO hospedajes (nombre, categoria, direccion, telefono, enlace_reservacion, rango_precio_min, rango_precio_max, creado_por) VALUES
('Hotel Plaza Mayor', 5, 'Av. Principal #123, Centro', '555-0101', 'https://plazamayor.com/reservas', 1500.00, 3000.00, 1),
('Hostal del Viajero', 3, 'Calle Juárez #45, Centro', '555-0102', 'https://hostalviajero.com', 400.00, 800.00, 1),
('Cabañas Bosque Verde', 4, 'Km 5 Carretera al Bosque', '555-0103', 'https://bosqueverde.com', 900.00, 1500.00, 1),
('Hotel Colonial', 4, 'Av. Independencia #200', '555-0104', 'https://hotelcolonial.com', 1200.00, 2200.00, 1);

-- Restaurantes de ejemplo
INSERT INTO restaurantes (nombre, tipo_comida, direccion, telefono, whatsapp, creado_por) VALUES
('La Casa de las Enchiladas', 'Mexicana', 'Calle Morelos #78, Centro', '555-0201', '5550201', 1),
('Pizzería Bella Napoli', 'Italiana', 'Av. Reforma #156', '555-0202', '5550202', 1),
('El Vegetariano Feliz', 'Vegetariana', 'Calle Hidalgo #34', '555-0203', '5550203', 1),
('Mariscos del Puerto', 'Mariscos', 'Blvd. Costero #89', '555-0204', '5550204', 1),
('Café Gourmet', 'Internacional', 'Plaza Central Local 12', '555-0205', '5550205', 1);

-- Atracciones turísticas de ejemplo
INSERT INTO atracciones (nombre, descripcion, categoria, direccion, horario_apertura, horario_cierre, costo_acceso, creado_por) VALUES
('Cascada El Salto', 'Hermosa cascada natural de 30 metros de altura con área de picnic', 'natural', 'Km 12 Carretera Norte', '08:00:00', '18:00:00', 0.00, 1),
('Museo de Historia Regional', 'Museo con exposiciones de la historia local desde la época prehispánica', 'cultural', 'Av. Juárez #230, Centro', '09:00:00', '17:00:00', 50.00, 1),
('Ex Hacienda San Antonio', 'Hacienda del siglo XVIII restaurada, tours guiados disponibles', 'historica', 'Km 8 Camino Real', '10:00:00', '18:00:00', 80.00, 1),
('Parque de Aventuras', 'Parque con tirolesas, puentes colgantes y actividades extremas', 'recreativa', 'Km 15 Carretera al Bosque', '09:00:00', '19:00:00', 250.00, 1),
('Mirador del Valle', 'Vista panorámica de toda la región desde 2000 metros de altura', 'natural', 'Km 20 Carretera a la Sierra', '07:00:00', '20:00:00', 0.00, 1);

-- Eventos de ejemplo
INSERT INTO eventos (nombre, descripcion, fecha_inicio, fecha_fin, ubicacion, enlace_boletos, creado_por) VALUES
('Festival de la Primavera', 'Festival anual con música, gastronomía y artesanías locales', '2024-03-15', '2024-03-17', 'Plaza Principal', 'https://festivalprimavera.com', 1),
('Feria del Mole', 'Evento gastronómico dedicado al mole tradicional', '2024-04-20', '2024-04-21', 'Explanada Municipal', NULL, 1),
('Concierto de Verano', 'Concierto al aire libre con bandas locales', '2024-07-15', '2024-07-15', 'Parque Central', 'https://tickets.com/verano', 1);

-- Contactos de emergencia de ejemplo
INSERT INTO emergencias (nombre, numero, descripcion, tipo, creado_por) VALUES
('Cruz Roja', '065', 'Emergencias médicas y primeros auxilios', 'cruz_roja', 1),
('Bomberos', '068', 'Atención de incendios y rescates', 'bomberos', 1),
('Policía Municipal', '066', 'Seguridad pública y emergencias', 'policia', 1),
('Protección Civil', '911', 'Coordinación de emergencias y desastres', 'proteccion_civil', 1);

-- Configuración inicial del sistema
INSERT INTO configuracion (clave, valor, descripcion) VALUES
('nombre_sistema', 'TuriBot', 'Nombre oficial del sistema'),
('logo_sistema', 'logo.png', 'Nombre del archivo del logo'),
('email_contacto', 'contacto@turibot.com', 'Email de contacto del municipio'),
('telefono_contacto', '555-0000', 'Teléfono de contacto del municipio'),
('mensaje_bienvenida', '¡Bienvenido a TuriBot! Tu asistente turístico virtual.', 'Mensaje de bienvenida del ChatBot'),
('direccion_municipio', 'Av. Municipal #1, Centro', 'Dirección del municipio');
