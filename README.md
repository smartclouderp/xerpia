# Xerpia ERP

ERP modular en PHP 8.2, arquitectura hexagonal, SOLID, MariaDB, Docker, Composer plugins.

## Estructura
- src/Core: Dominio y lógica central
- src/Modules: Módulos funcionales (ej: Inventario, Ventas)
- src/Shared: Utilidades y recursos compartidos
- src/Plugins: Plugins vía Composer
- config: Configuración
- public: Punto de entrada web
- docker: Docker y docker-compose
- tests: Pruebas

## Docker
- PHP 8.2 + Apache
- MariaDB

## Composer
- PSR-4 autoload
- Plugins y dependencias

## Escalabilidad
- Modularidad por paquetes
- Hexagonal: separación de dominio, aplicación, infraestructura y adaptadores

## Ejecución
1. Instala dependencias:
   ```powershell
   composer install
   ```
2. Levanta el entorno:
   ```powershell
   docker-compose -f docker/docker-compose.yml up --build
   ```
3. Accede a http://localhost:8080
