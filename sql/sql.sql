-- Creación de la tabla de proyectos
CREATE TABLE proyectos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    comercial VARCHAR(255),  -- Representante a cargo del proyecto
    estado VARCHAR(100),     -- Estado del proyecto (activo, finalizado, etc.)
    fecha_inicio DATE,       -- Fecha de inicio del proyecto
    fecha_fin DATE,          -- Fecha de finalización del proyecto
    descripcion TEXT,        -- Descripción breve del proyecto
    cliente VARCHAR(255)     -- Cliente o empresa asociada
    orden_compra VARCHAR(255); -- Numero de la orden de compra del cliente, es el mismo numero que se le coloca a la liquidación
    responsable VARCHAR(255); -- Responsable de la creación del proyecto en la aplicación
    vencimiento_factura DATE; -- Fecha de la factura emitida al cliente 
);

-- Creación de la tabla de tareas asociadas a los proyectos
CREATE TABLE tareas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_proyecto INT,
    nombre VARCHAR(255) NOT NULL,
    completada TINYINT(1) DEFAULT 0,  -- 0: no completada, 1: completada / revisar: completada BOOLEAN NOT NULL DEFAULT FALSE,
    descripcion TEXT, -- Falta crear este campo
    fecha_limite DATE, 
    FOREIGN KEY (id_proyecto) REFERENCES proyectos(id)
);

-- Creación de la tabla de archivos asociados a las tareas
CREATE TABLE archivos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_proyecto INT,
    id_tarea INT,
    nombre_archivo VARCHAR(255) NOT NULL,
    ruta_archivo VARCHAR(255) NOT NULL,
    nombre_tarea VARCHAR(255) NOT NULL,
    responsable VARCHAR(255),        -- Nuevo campo para el nombre de usuario
    observacion TEXT,                -- Nuevo campo para la observación
    numero_factura VARCHAR(255),     -- Nuevo campo para el número de factura
    FOREIGN KEY (id_proyecto) REFERENCES proyectos(id),
    FOREIGN KEY (id_tarea) REFERENCES tareas(id)
);
-- Creación de la tabla de historico_eliminar
CREATE TABLE historico_eliminar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_tarea VARCHAR(255) NOT NULL,
    nombre_proyecto VARCHAR(255) NOT NULL,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    responsable VARCHAR(255) NOT NULL
);

-- Creación de la tabla de clientes para los proyectos
CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    correo_electronico VARCHAR(255) UNIQUE NOT NULL,
    telefono VARCHAR(20),
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Creación de la tabla de comerciales para los proyectos
CREATE TABLE comerciales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    fecha_contratacion DATE,
    otros_datos TEXT
    cedula VARCHAR(255)
);