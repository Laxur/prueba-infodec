# Prueba Técnica - Analista de Soporte Nivel 1 - Infodec

Aplicación web desarrollada para Sofía Restrepo, que permite consultar la población de las ciudades de un país seleccionado, usando la base de datos **World** de MySQL.

## Descripción del proyecto

La aplicación consta de una única pantalla donde el usuario selecciona un país desde un listado desplegable, y el sistema muestra automáticamente:
- El Top 10 de ciudades con mayor población de ese país.
- El Top 10 de ciudades con menor población de ese país.

La interfaz es responsive, por lo que puede usarse desde computador, tablet o teléfono inteligente.

## Tecnologías utilizadas

- PHP 8.4
- Laravel 
- MySQL 8.0
- Docker
- Bootstrap 5
- Postman

## 📁 Estructura del proyecto

prueba-infodec/
├── docker-compose.yml       # Orquestación de contenedores (MySQL, phpMyAdmin, App)
├── Dockerfile                # Imagen personalizada de PHP para Laravel
├── world.sql                 # Base de datos World (se importa automáticamente)
├── README.md
├── respuestas.pdf            # Respuestas del formato
├── postman/
│   └── api-cambio-moneda.json   # Colección exportada de Postman
│   └── evidencia.pdf            # Doc evidencia de prueba de api
└── src/                         # Proyecto Laravel
    ├── app/
    │   ├── Models/
    │   │   ├── Country.php
    │   │   └── City.php
    │   └── Http/Controllers/
    │       └── CityController.php
    ├── routes/
    │   └── web.php
    └── resources/views/
        └── welcome.blade.php

## Requisitos previos
- Tener [Docker](https://www.docker.com/products/docker-desktop/) instalado y corriendo.

## 📝 Notas de desarrollo

El historial de commits refleja el desarrollo incremental del proyecto: configuración de entorno, modelos, controlador, rutas, vista y documentación.
