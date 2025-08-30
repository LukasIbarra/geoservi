# 📧 CONFIGURACIÓN DE EMAIL - PASO A PASO
## Sistema de Notificaciones Geoservi

---

## 🎯 OBJETIVO
Configurar el correo **pruebasgeoservi@gmail.com** para enviar notificaciones automáticas de mantenimiento.

---

## 📝 PASOS DE CONFIGURACIÓN

### PASO 1: Habilitar Verificación en 2 Pasos en Gmail

1. **Inicia sesión** en pruebasgeoservi@gmail.com
2. Ve a **Configuración de Seguridad**: https://myaccount.google.com/security
3. Busca **"Verificación en 2 pasos"**
4. Haz clic en **"Activar"**
5. Sigue los pasos para configurar tu teléfono

---

### PASO 2: Generar Contraseña de Aplicación

1. Una vez activada la verificación en 2 pasos
2. Ve a **Contraseñas de aplicación**: https://myaccount.google.com/apppasswords
3. En **"Seleccionar aplicación"** elige **"Correo"**
4. En **"Seleccionar dispositivo"** elige **"Otro (nombre personalizado)"**
5. Escribe: **"Geoservi Notificaciones"**
6. Haz clic en **"Generar"**
7. **IMPORTANTE**: Copia la contraseña de 16 caracteres que aparece
   - Ejemplo: `abcd efgh ijkl mnop`
   - Esta contraseña solo se muestra una vez

---

### PASO 3: Configurar el Archivo .env

Abre el archivo `.env` en la raíz del proyecto y agrega/modifica estas líneas:

```env
# ========================================
# CONFIGURACIÓN DE EMAIL
# ========================================
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=pruebasgeoservi@gmail.com
MAIL_PASSWORD="abcd efgh ijkl mnop"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=pruebasgeoservi@gmail.com
MAIL_FROM_NAME="Geoservi - Sistema de Mantenimiento"

# Destinatarios de notificaciones
NOTIFICATION_EMAIL_TO=pruebasgeoservi@gmail.com
```

**NOTA**: Reemplaza `"abcd efgh ijkl mnop"` con la contraseña que generaste en el Paso 2.

---

### PASO 4: Limpiar Caché de Configuración

Ejecuta estos comandos en la terminal:

```bash
php artisan config:clear
php artisan cache:clear
php artisan config:cache
```

---

### PASO 5: Probar la Configuración

Ejecuta el script de prueba:

```bash
php test_email_config.php
```

Si todo está correcto, verás:
```
✅ Email enviado exitosamente!
   Revisa la bandeja de entrada de pruebasgeoservi@gmail.com
```

---

## 🧪 PRUEBAS DEL SISTEMA

### Prueba 1: Email de Texto Simple
```bash
php artisan tinker
>>> Mail::raw('Prueba de notificación', function($m) {
>>>     $m->to('pruebasgeoservi@gmail.com')->subject('Test');
>>> });
```

### Prueba 2: Verificar Horómetros Manualmente
```bash
# Ver estado actual de máquinas
php artisan notificaciones:verificar-horometros --dry-run

# Enviar notificaciones reales
php artisan notificaciones:verificar-horometros
```

### Prueba 3: Demo Completo
```bash
php test_notificaciones_demo.php
```

---

## 🔧 SOLUCIÓN DE PROBLEMAS

### Error: "Authentication failed"
**Causa**: Contraseña incorrecta
**Solución**: 
- Verifica que copiaste bien la contraseña de aplicación
- No uses tu contraseña normal de Gmail
- Genera una nueva contraseña de aplicación si es necesario

### Error: "Connection timeout"
**Causa**: Puerto bloqueado o sin internet
**Solución**:
- Verifica tu conexión a internet
- Prueba con puerto 465 y encryption=ssl
- Verifica que tu firewall no bloquee el puerto 587

### Error: "From address not verified"
**Causa**: Dirección de envío incorrecta
**Solución**:
- Asegúrate que MAIL_FROM_ADDRESS sea pruebasgeoservi@gmail.com

---

## 📊 CONFIGURACIÓN DE NOTIFICACIONES

### Umbrales de Horómetro
En el archivo `.env` puedes configurar:

```env
# Horas para considerar crítico
NOTIFICATION_CRITICAL_HOURS=24

# Horas para advertencia
NOTIFICATION_WARNING_HOURS=50

# Horas para preventivo
NOTIFICATION_PREVENTIVE_HOURS=100
```

### Horarios de Envío
```env
# Hora de inicio (formato 24h)
NOTIFICATION_START_HOUR=6

# Hora de fin
NOTIFICATION_END_HOUR=22

# Enviar en fines de semana
NOTIFICATION_WEEKEND_ENABLED=false
```

---

## 🚀 ACTIVACIÓN AUTOMÁTICA

### Para Windows (Desarrollo)
Usa el Programador de Tareas de Windows:
1. Abre el Programador de Tareas
2. Crear tarea básica
3. Nombre: "Geoservi Notificaciones"
4. Disparador: Diariamente, cada hora
5. Acción: Iniciar programa
6. Programa: `C:\xampp\php\php.exe`
7. Argumentos: `C:\xampp\htdocs\geoservi\artisan schedule:run`

### Para Linux (Producción)
Agrega al crontab:
```bash
crontab -e
# Agregar esta línea:
* * * * * cd /var/www/geoservi && php artisan schedule:run >> /dev/null 2>&1
```

---

## 📬 TIPOS DE NOTIFICACIONES

### 1. Notificación Crítica (0-24 horas)
- **Asunto**: 🚨 ALERTA CRÍTICA - [Nombre Máquina]
- **Frecuencia**: Cada 2 horas
- **Contenido**: Alerta roja con botón de acción inmediata

### 2. Notificación Preventiva (25-50 horas)
- **Asunto**: ⚠️ Mantenimiento Preventivo - [Nombre Máquina]
- **Frecuencia**: Diaria
- **Contenido**: Advertencia amarilla con detalles

### 3. Notificación Informativa (51-100 horas)
- **Asunto**: ℹ️ Próximo Mantenimiento - [Nombre Máquina]
- **Frecuencia**: Cada 3 días
- **Contenido**: Información azul de planificación

---

## 📈 MONITOREO

### Ver Logs de Notificaciones
```bash
# Logs del sistema
tail -f storage/logs/laravel.log

# Logs específicos de horómetros
tail -f storage/logs/horometros.log
```

### Dashboard de Métricas
Accede a: http://localhost:8000/admin/dashboard
- Ver alertas críticas
- Máquinas próximas a mantenimiento
- Historial de notificaciones

---

## ✅ CHECKLIST FINAL

- [ ] Verificación en 2 pasos activada en Gmail
- [ ] Contraseña de aplicación generada
- [ ] Archivo .env configurado con credenciales
- [ ] Caché limpiado (`php artisan config:clear`)
- [ ] Email de prueba enviado exitosamente
- [ ] Notificaciones de horómetro funcionando
- [ ] Cron job o tarea programada configurada

---

## 📞 SOPORTE

Si tienes problemas con la configuración:

1. **Revisa los logs**: `storage/logs/laravel.log`
2. **Ejecuta diagnóstico**: `php test_email_config.php`
3. **Consulta documentación**: `IMPLEMENTACION_NOTIFICACIONES.md`

---

**Última actualización**: 26/08/2025
**Email configurado**: pruebasgeoservi@gmail.com
**Sistema**: Notificaciones Automáticas Geoservi v1.0
