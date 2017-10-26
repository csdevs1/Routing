CREATE DATABASE router_db;
\c router_db;

CREATE TABLE IF NOT EXISTS Oficinas(
  id SERIAL PRIMARY KEY,
  nombre varchar(255) NOT NULL,
  direccion varchar(255) NOT NULL,
  rut varchar(255) NOT NULL,
  lat varchar(255) NOT NULL,
  lng varchar(255) NOT NULL,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Usuarios(
  id SERIAL PRIMARY KEY,
  nombre varchar(255) NOT NULL,
  email varchar(255) NOT NULL UNIQUE,
  password varchar(255) NOT NULL,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  id_oficina integer NOT NULL,
  CONSTRAINT oficina_id_fk_1
    FOREIGN KEY (id_oficina) 
    REFERENCES Oficinas(id)
    ON DELETE CASCADE ON UPDATE CASCADE
 );
ALTER TABLE Usuarios ADD COLUMN remember_token character varying(255);

CREATE TABLE IF NOT EXISTS Clientes(
  id SERIAL PRIMARY KEY,
  nombre varchar(255) NOT NULL,
  direccion varchar(255) NOT NULL,
  lat varchar(255) NOT NULL,
  lng varchar(255) NOT NULL,
  prioridad integer NOT NULL,
  hora_inicio time NOT NULL,
  hora_fin time NOT NULL,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  id_oficina integer NOT NULL,
  CONSTRAINT oficina_id_fk_2
    FOREIGN KEY (id_oficina) 
    REFERENCES Oficinas(id)
    ON DELETE CASCADE ON UPDATE CASCADE
 );
ALTER TABLE Clientes ADD COLUMN codigo integer;
ALTER TABLE Clientes ADD COLUMN label varchar(255);

CREATE TABLE IF NOT EXISTS GrupoVehiculos(
  id SERIAL PRIMARY KEY,
  nombre varchar(255) NOT NULL UNIQUE,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Vehiculos(
  id SERIAL PRIMARY KEY,
  nombre varchar(255) NOT NULL UNIQUE,
  patente varchar(255) NOT NULL,
  outerWidth DOUBLE PRECISION NOT NULL,
  outerLength DOUBLE PRECISION NOT NULL,
  outerDepth DOUBLE PRECISION NOT NULL,
  emptyWeight DOUBLE PRECISION NOT NULL,
  innerWidth DOUBLE PRECISION NOT NULL,
  innerLength DOUBLE PRECISION NOT NULL,
  innerDepth DOUBLE PRECISION NOT NULL,
  maxWeight DOUBLE PRECISION NOT NULL,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  id_oficina integer NOT NULL,
  CONSTRAINT oficina_id_fk_3
    FOREIGN KEY (id_oficina) 
    REFERENCES Oficinas(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  id_grupo  integer DEFAULT NULL,
  CONSTRAINT grupo_vehiculo_id_fk_1
    FOREIGN KEY (id_grupo) 
    REFERENCES GrupoVehiculos(id)
    ON DELETE CASCADE ON UPDATE CASCADE
 );
ALTER TABLE Vehiculos ADD UNIQUE (nombre,patente);
ALTER TABLE Vehiculos ADD COLUMN updated_at timestamp default current_timestamp;

CREATE TABLE IF NOT EXISTS Documentos(
   id SERIAL PRIMARY KEY,
   created_at timestamp DEFAULT CURRENT_TIMESTAMP,
   codigo varchar(255) NOT NULL UNIQUE,
   fecha_despacho timestamp,
   fecha_pactada timestamp,
   id_cliente integer NOT NULL,
   CONSTRAINT cliente_id_fk_1
     FOREIGN KEY (id_cliente) 
     REFERENCES Clientes(id)
     ON DELETE CASCADE ON UPDATE CASCADE,
   id_vehiculo integer DEFAULT NULL,
   CONSTRAINT vehiculo_id_fk_1
     FOREIGN KEY (id_vehiculo)
     REFERENCES Vehiculos(id)
     ON DELETE CASCADE ON UPDATE CASCADE
);
ALTER TABLE Documentos ADD COLUMN prioridad BOOLEAN DEFAULT false;
ALTER TABLE Documentos ADD COLUMN updated_at timestamp default current_timestamp;

CREATE TABLE IF NOT EXISTS Productos(
  id SERIAL PRIMARY KEY,
  description varchar(255) NOT NULL,
  codigo varchar(255) NOT NULL UNIQUE,
  tipo varchar(255) NOT NULL,
  width DOUBLE PRECISION NOT NULL,
  length DOUBLE PRECISION NOT NULL,
  depth DOUBLE PRECISION NOT NULL,
  weight DOUBLE PRECISION NOT NULL,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP
);
ALTER TABLE Productos ADD COLUMN updated_at timestamp default current_timestamp;
CREATE TABLE IF NOT EXISTS DocumentosItems(
   id SERIAL PRIMARY KEY,
   cantidad integer NOT NULL,
   created_at timestamp DEFAULT CURRENT_TIMESTAMP,
   id_documento integer NOT NULL,
   CONSTRAINT documento_id_fk_1
     FOREIGN KEY (id_documento) 
     REFERENCES Documentos(id)
     ON DELETE CASCADE ON UPDATE CASCADE,
   id_producto integer NOT NULL,
   CONSTRAINT producto_id_fk_1
     FOREIGN KEY (id_producto) 
     REFERENCES Productos(id)
     ON DELETE CASCADE ON UPDATE CASCADE
 );
ALTER TABLE DocumentosItems ADD COLUMN updated_at timestamp default current_timestamp;
INSERT INTO Oficinas (nombre,direccion,rut,lat,lng) VALUES ('OWL Chile','Av. Nueva Providencia 1650, Providencia, Región Metropolitana', '123456789-k','-33.4276051','-70.619202');

INSERT INTO Usuarios (nombre,email,password,id_oficina) VALUES ('Prueba','prueba@owlchile.cl', '$2y$10$scWiiDf7TBeiN4QAGHzvyuhn8A6x6lEyxUj9C9DfnaatWCBdYdREW',1);

INSERT INTO Clientes (nombre,direccion,lat,lng,hora_inicio,hora_fin,id_oficina,prioridad) VALUES ('Cliente 1','Las Begonias 5868, Maipú, Región Metropolitana', '-33.5107253','-70.7616906','09:00:00','18:30:00',1,1);


INSERT INTO Clientes (nombre,direccion,lat,lng,hora_inicio,hora_fin,id_oficina,prioridad) VALUES ('Cliente 2','Av. Américo Vespucio 1001-1069, Maipú, Región Metropolitana', '-33.4821835','-70.7536068','09:00:00','18:30:00',1,3);

INSERT INTO Clientes (nombre,direccion,lat,lng,hora_inicio,hora_fin,id_oficina,prioridad) VALUES ('Cliente 3','Av. Francisco Bilbao 4140-4146, Las Condes, Región Metropolitana', '-33.4313383','-70.5787598','09:00:00','18:30:00',1,2);
