-- Script SQL del Parcial 3 Practico - CLAVE 2
-- Carnet: AA13032
-- Base de datos para gestionar hospitales y doctores.

-- Se crea la base de datos del proyecto con un nombre personalizado.
CREATE DATABASE IF NOT EXISTS p3_aa13032_salud
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

-- Se selecciona la base de datos para crear las tablas dentro de ella.
USE p3_aa13032_salud;

-- La tabla Hospitales almacena los centros medicos disponibles.
-- IdHospital funciona como identificador principal y sera usado por Doctores.
CREATE TABLE IF NOT EXISTS Hospitales (
    IdHospital VARCHAR(15) NOT NULL,
    NomHospital VARCHAR(100) NOT NULL,
    CapacidadAtencion VARCHAR(50) NOT NULL,
    Especialidades VARCHAR(150) NOT NULL,
    PRIMARY KEY (IdHospital)
) ENGINE=InnoDB;

-- La tabla Doctores almacena los datos de cada doctor registrado.
-- IdHospital permite relacionar cada doctor con un hospital existente.
CREATE TABLE IF NOT EXISTS Doctores (
    IdDoctor VARCHAR(15) NOT NULL,
    NombresDoctor VARCHAR(100) NOT NULL,
    ApellidosDoctor VARCHAR(100) NOT NULL,
    Especialidad VARCHAR(80) NOT NULL,
    TurnoAtencion VARCHAR(30) NOT NULL,
    PacientesMinDiarios INT NOT NULL,
    Sueldo DOUBLE NOT NULL,
    IdHospital VARCHAR(15) NOT NULL,
    PRIMARY KEY (IdDoctor),
    CONSTRAINT fk_doctores_hospitales
        FOREIGN KEY (IdHospital)
        REFERENCES Hospitales (IdHospital)
) ENGINE=InnoDB;

-- Datos iniciales de hospitales para probar registros y consultas.
-- Los nombres corresponden a hospitales reales de El Salvador.
INSERT INTO Hospitales (
    IdHospital,
    NomHospital,
    CapacidadAtencion,
    Especialidades
) VALUES
    (
        'HOSP-AA01',
        'Hospital Nacional Rosales',
        'Atencion especializada nacional',
        'Medicina interna, Cirugia, Emergencias'
    ),
    (
        'HOSP-AA02',
        'Hospital Nacional de Ninos Benjamin Bloom',
        'Atencion pediatrica especializada',
        'Pediatria, Neonatologia, Emergencias infantiles'
    );

-- Datos iniciales de doctores asociados a los hospitales anteriores.
-- Estos registros permiten verificar que la llave foranea funciona correctamente.
INSERT INTO Doctores (
    IdDoctor,
    NombresDoctor,
    ApellidosDoctor,
    Especialidad,
    TurnoAtencion,
    PacientesMinDiarios,
    Sueldo,
    IdHospital
) VALUES
    (
        'DOC-AA01',
        'Valeria Sofia',
        'Menendez Rivas',
        'Medicina interna',
        'Matutino',
        12,
        1250.50,
        'HOSP-AA01'
    ),
    (
        'DOC-AA02',
        'Carlos Ernesto',
        'Aguilar Pineda',
        'Pediatria',
        'Vespertino',
        10,
        1380.75,
        'HOSP-AA02'
    );
