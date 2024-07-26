CREATE DATABASE login;
USE login;

CREATE TABLE user
(
    codUser     INT AUTO_INCREMENT PRIMARY KEY,
    usuario     VARCHAR(30),
    contrasenia VARCHAR(10),
    estado      BOOL,
    cargo       VARCHAR(30)
);

INSERT INTO user(usuario, contrasenia, estado, cargo)
VALUES ('admin', 'admin', true, 'administrator'),
       ('pablo', '123456', true, 'standard'),
       ('usuario3', '456789', true, 'standard');

SELECT * FROM user;
INSERT INTO user(usuario, contrasenia, estado, cargo)
VALUES('usuario4', '123456', false, 'standard');
