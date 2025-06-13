# Registro de Cambios

Todos los cambios notables en `friendly-fpdf` serán documentados en este archivo.

## [2.0.0] - 2024-11-19

### Añadido - Compatibilidad 
- **Compatibilidad completa **
- Nueva clase `Fpdf` para inyección de dependencias
- Facade `Fpdf` adicional para compatibilidad con Laravel
- Soporte para inyección de dependencias en rutas y controladores
- Archivo de ejemplos completos (`examples/usage_examples.php`)
- Documentación extendida con múltiples formas de uso

### Mejorado
- ServiceProvider mejorado para soportar múltiples formas de uso
- README actualizado con ejemplos de ambos estilos
- Configuración mejorada con mejor documentación
- Tres formas de uso disponibles:
  1. Inyección de dependencias ()
  2. Interfaz fluida (estilo original)
  3. Facades simples

### Cambiado

- Mejor compatibilidad con Laravel Vapor
- Documentación completa en español

## [1.0.0] - 2024-11-19

### Añadido
- Versión inicial del paquete
- Soporte para generación básica de PDFs
- Métodos fluidos para manipulación de documentos
- Configuración personalizable
- Integración con Laravel 