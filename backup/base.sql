Create table gremio (
    IDGre INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(30) NOT NULL, 
    Urls VARCHAR(70) NOT NULL, 
    Numero int(7) NOT NULL, 
    Raid VARCHAR(10) NOT NULL, 
    NMiembros TINYINT(2) NOT NULL, 
    Poder VARCHAR(15) NOT NULL, 
    Rango VARCHAR(15) NOT NULL, 
    Arena VARCHAR(10) NOT NULL, 
    Fecha DATE() NOT NULL
);
Create table miembros (
    IDMie INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(30) NOT NULL, 
    Urls VARCHAR(70) NOT NULL,
    Usuario int(7) NOT NULL, 
    Aliado VARCHAR(15) NOT NULL, 
    NPersonajes TINYINT(3) NOT NULL, 
    PoderC VARCHAR(15) NOT NULL, 
    PoderS VARCHAR(15) NOT NULL, 
    PColeccion VARCHAR(15) NOT NULL,
    Arena TINYINT(5) NOT NULL, 
    Gremmio int(5) NOT NULL,, 
    Fecha DATE() NOT NULL
);
Create table coleccionesp (
    IDCoP INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(30) NOT NULL, 
    Urls VARCHAR(70) NOT NULL,  
    Estrellas TINYINT(1) NOT NULL, 
    Nivel TINYINT(2) NOT NULL, 
    Gear VARCHAR(4) NOT NULL,
    Poder VARCHAR(15) NOT NULL, 
    Avance VARCHAR(5) NOT NULL,, 
    Usuario int(7) NOT NULL,  
    M1 VARCHAR(15), M2 VARCHAR(15), M3 VARCHAR(15), M4 VARCHAR(15), M5 VARCHAR(15), M6 VARCHAR(15),
    Fecha  DATE() NOT NULL
);
            