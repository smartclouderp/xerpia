# Arquitectura hexagonal en xerpia

xerpia implementa una arquitectura hexagonal (puertos y adaptadores) para lograr un sistema desacoplado, mantenible y fácilmente extensible.

## Estructura de carpetas

```
src/
  Core/
    Database/           # Conexión y utilidades de base de datos
  Modules/
    User/               # Módulo de usuarios y roles
    Product/            # Módulo de productos
    Provider/           # Módulo de proveedores
    ...
  Plugins/              # Extensiones o integraciones externas
  Shared/               # Utilidades y código compartido
public/                 # Punto de entrada (router)
config/                 # Configuración (DB, etc)
docker/                 # Archivos Docker y docker-compose
```

## Capas principales

- **Dominio (Domain):**
  - Entidades y lógica de negocio pura
  - Interfaces de repositorio
- **Aplicación (Application):**
  - Casos de uso (servicios de aplicación)
  - Orquestación de lógica
- **Infraestructura (Infrastructure):**
  - Implementaciones concretas (ej: repositorios MariaDB)
  - Acceso a datos, servicios externos
- **Adaptadores (Adapter/Web):**
  - Controladores HTTP, DTOs, validaciones
  - Traducción entre HTTP y casos de uso

## Flujo típico de una petición

1. El router recibe la petición y la dirige al controlador adecuado.
2. El controlador adapta los datos de entrada a un DTO y valida.
3. El controlador invoca el caso de uso correspondiente.
4. El caso de uso interactúa con el dominio y los repositorios (a través de interfaces).
5. La infraestructura implementa el acceso real a la base de datos.
6. El controlador retorna la respuesta HTTP.

## Ventajas
- Bajo acoplamiento entre capas
- Fácil de testear y extender
- Permite cambiar la infraestructura sin afectar la lógica de negocio

## Ejemplo visual

```
[HTTP Request]
    |
[Adapter/Web] ---> [Application] ---> [Domain] <--- [Infrastructure]
    |
[HTTP Response]
```

---

¿Quieres agregar diagramas, ejemplos de código o recomendaciones de buenas prácticas para contribuir?
