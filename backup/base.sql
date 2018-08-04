Create table gremio (
    IDGre INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(30) NOT NULL, 
    Urls VARCHAR(70) NOT NULL, 
    Numero int(7) NOT NULL, 
    Raid TINYINT(3) NOT NULL, 
    NMiembros TINYINT(2) NOT NULL, 
    Poder int(9) NOT NULL, 
    Rango VARCHAR(3) NOT NULL, 
    Arena DECIMAL(6,2) NOT NULL, 
    Fecha DATE() NOT NULL
);
Create table miembros (
    IDMie INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(30) NOT NULL, 
    Urls VARCHAR(70) NOT NULL,
    Usuario int(7) NOT NULL, 
    Aliado VARCHAR(12) NOT NULL, 
    NPersonajes TINYINT(3) NOT NULL, 
    PoderC int(8) NOT NULL, 
    PoderS int(8) NOT NULL, 
    PColeccion DECIMAL(4,2) NOT NULL,
    Arena TINYINT(3) NOT NULL, 
    Gremio int(7) NOT NULL, 
    Fecha DATE() NOT NULL
);
Create table coleccionesp (
    IDCoP INT() UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(30) NOT NULL, 
    Urls VARCHAR(70) NOT NULL,  
    Estrellas TINYINT(1) NOT NULL, 
    Nivel TINYINT(2) NOT NULL, 
    Gear VARCHAR(4) NOT NULL,
    Poder int(8) NOT NULL, 
    Avance DECIMAL(4,2) NOT NULL,  
    M1 VARCHAR(15), M2 VARCHAR(15), M3 VARCHAR(15), M4 VARCHAR(15), M5 VARCHAR(15), M6 VARCHAR(15),
    Usuario int(7) NOT NULL,
    Gremio int(7) NOT NULL, 
    Fecha  DATE() NOT NULL
);
            