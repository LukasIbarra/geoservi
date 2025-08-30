# Implementation Plan

## Overview
Preparar el proyecto Laravel de Geoservi para un despliegue exitoso en cPanel solucionando los problemas críticos de imágenes, login y correos electrónicos. La aplicación está desplegada en la raíz del dominio geoservi.cl y requiere correcciones exhaustivas para garantizar el funcionamiento correcto en el entorno de producción.

## Types
No se requieren cambios en tipos de datos o estructuras de datos para esta implementación.

## Files

### New files to be created
- `public/.htaccess` - Archivo de configuración Apache para Laravel en cPanel
- `storage/logs/.gitkeep` - Archivo para mantener el directorio de logs
- `public/img/logo-geoservi.ico` - Archivo de favicon faltante

### Existing files to be modified
- `resources/views/auth/login.blade.php` - Verificar rutas de imágenes
- `resources/views/layouts_pag/footer.blade.php` - Corregir rutas de imágenes
- `resources/views/layouts_pag/app.blade.php` - Corregir ruta del favicon
- `resources/views/pagina/welcome.blade.php` - Revisar rutas de imágenes
- `resources/views/layouts_pag/hero.blade.php` - Revisar rutas de imágenes
- `resources/views/layouts_pag/servicios.blade.php` - Revisar rutas de imágenes
- `resources/views/layouts_pag/representaciones.blade.php` - Revisar rutas de imágenes
- `resources/views/layouts_pag/contactos.blade.php` - Revisar rutas de imágenes
- `resources/views/pagina/contacto.blade.php` - Revisar rutas de imágenes
- `resources/views/admin/dashboard.blade.php` - Revisar rutas de imágenes
- `resources/views/pdf/dashboard.blade.php` - Revisar rutas de imágenes
- `routes/web.php` - Verificar configuración de rutas
- `config/app.php` - Verificar configuración de URL base
- `config/filesystems.php` - Verificar configuración de enlaces simbólicos
- `app/Providers/AppServiceProvider.php` - Verificar configuración de enlaces simbólicos

### Files to be deleted or moved
- Ninguno

### Configuration file updates
- `.env` - Verificar configuración completa para producción
- `public/.htaccess` - Configurar para Laravel en cPanel

## Functions

### New functions
- Ninguna

### Modified functions
- Verificar `app/Http/Controllers/Auth/AuthenticatedSessionController.php` - Asegurar redirección correcta después del login
- Verificar `app/Http/Controllers/Auth/RegisteredUserController.php` - Asegurar redirección correcta después del registro

### Removed functions
- Ninguna

## Classes

### New classes
- Ninguna

### Modified classes
- Verificar `app/Http/Middleware/Authenticate.php` - Asegurar redirección correcta al login

### Removed classes
- Ninguna

## Dependencies

### New packages
- Ninguno

### Version changes
- Verificar versiones de dependencias en `composer.json`

### Integration requirements
- Verificar configuración de enlaces simbólicos para storage
- Verificar permisos de directorios en cPanel

## Testing

### Test file requirements
- `tests/Feature/Auth/LoginTest.php` - Pruebas de login
- `tests/Feature/ImageRoutesTest.php` - Pruebas de rutas de imágenes
- `tests/Feature/EmailTest.php` - Pruebas de envío de correos

### Existing test modifications
- Actualizar pruebas existentes para entorno de producción

### Validation strategies
- Pruebas de carga de imágenes desde diferentes rutas
- Pruebas de funcionalidad de login
- Pruebas de envío de correos electrónicos
- Verificación de enlaces simbólicos

## Implementation Order

1. **Configuración de servidor (.htaccess)**
   - Crear archivo .htaccess en public/ para Laravel en cPanel
   - Configurar RewriteEngine y RewriteBase

2. **Corrección de rutas de imágenes**
   - Buscar todas las referencias de imágenes en vistas
   - Reemplazar rutas relativas con asset() helper
   - Verificar rutas absolutas que puedan causar problemas

3. **Configuración de login**
   - Verificar rutas de autenticación
   - Revisar middleware de autenticación
   - Verificar redirecciones después del login

4. **Configuración de correos electrónicos**
   - Verificar configuración SMTP en .env
   - Probar envío de correos
   - Revisar plantillas de correo

5. **Configuración de enlaces simbólicos**
   - Verificar configuración de storage:link
   - Asegurar permisos correctos en cPanel

6. **Optimización para producción**
   - Configurar APP_ENV=production
   - Deshabilitar APP_DEBUG
   - Configurar caché de configuración

7. **Pruebas finales**
   - Probar todas las funcionalidades
   - Verificar carga de imágenes
   - Verificar login y registro
   - Verificar envío de correos
