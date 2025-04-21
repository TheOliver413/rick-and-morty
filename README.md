# Rick and Morty Explorer

![Rick and Morty Logo](https://rickandmortyapi.com/icons/icon-512x512.png)

Una aplicación web desarrollada con Laravel que permite explorar y gestionar personajes del universo de Rick and Morty, utilizando la [API oficial de Rick and Morty](https://rickandmortyapi.com/).

## 📋 Características

- Visualización de personajes desde la API oficial de Rick and Morty
- Almacenamiento de personajes en base de datos local
- Edición de información de personajes guardados
- Visualización detallada de cada personaje
- Interfaz responsiva y moderna con Bootstrap 5

## 🔧 Requisitos

- PHP >= 8.0
- Composer
- PostgreSQL o cualquier base de datos compatible con Laravel
- Node.js y NPM (para compilar assets)

## 🚀 Instalación

1. Clona el repositorio:
   ```bash
   git clone https://github.com/TheOliver413/rick-and-morty
   cd rick-and-morty

## 🚀 Base de Datos
CREATE DATABASE rick_and_morty;

\q

Edita el archivo `.env` para usar PostgreSQL:

DB_CONNECTION=pgsql
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=rick_and_morty
DB_USERNAME=postgres
DB_PASSWORD=admin

### 5. Configurar sesiones

Este proyecto utiliza sesiones basadas en base de datos. Genera la migración para la tabla de sesiones:

php artisan session:table

### 6. Ejecutar migraciones
php artisan migrate

### 7. Compilar assets (opcional)
npm install
npm run dev

### 8. Iniciar el servidor de desarrollo
php artisan serve
