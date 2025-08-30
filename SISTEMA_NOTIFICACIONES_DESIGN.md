# 📱 Sistema de Notificaciones para Mantenimiento Preventivo
## Geoservi - Sistema de Mantenimiento Minero

---

## 1. ARQUITECTURA DEL SISTEMA

### 1.1 Flujo de Notificaciones
```
[Horómetro] → [Monitor] → [Evaluador] → [Notificador] → [Destinatario]
     ↓            ↓            ↓             ↓              ↓
  Máquina    Cron Job    Reglas de    Email/SMS/Push    Supervisor
             (c/hora)     Negocio                        Técnico
```

### 1.2 Canales de Notificación
- **📧 Email**: Notificaciones detalladas con reportes
- **📱 SMS**: Alertas críticas urgentes
- **🔔 Push**: Notificaciones en tiempo real (app móvil futura)
- **💬 WhatsApp Business API**: Mensajes instantáneos con confirmación

---

## 2. TIPOS DE NOTIFICACIONES

### 2.1 Por Criticidad

#### 🔴 **CRÍTICAS** (Inmediatas)
- Horómetro excede límite de mantención
- Máquina con mantención vencida
- Falla detectada en operación
- **Canales**: SMS + Email + WhatsApp
- **Frecuencia**: Inmediata y cada 2 horas hasta acción

#### 🟡 **PREVENTIVAS** (Anticipadas)
- 100 horas antes de mantención
- 50 horas antes de mantención
- 24 horas antes de mantención
- **Canales**: Email + WhatsApp
- **Frecuencia**: Diaria

#### 🟢 **INFORMATIVAS** (Programadas)
- Resumen semanal de estado de flota
- Reporte mensual de mantenciones
- Estadísticas de cumplimiento
- **Canales**: Email
- **Frecuencia**: Semanal/Mensual

---

## 3. REGLAS DE NEGOCIO

### 3.1 Cálculo de Umbrales
```php
$horasRestantes = $proximaMantencion - $horometroActual;

if ($horasRestantes <= 0) {
    // VENCIDO - Notificación CRÍTICA cada 2 horas
} elseif ($horasRestantes <= 24) {
    // MUY PRÓXIMO - Notificación cada 4 horas
} elseif ($horasRestantes <= 50) {
    // PRÓXIMO - Notificación diaria
} elseif ($horasRestantes <= 100) {
    // PREVENTIVO - Notificación cada 3 días
}
```

### 3.2 Escalamiento
1. **Nivel 1**: Técnico asignado
2. **Nivel 2**: Supervisor de turno (si no hay respuesta en 2 horas)
3. **Nivel 3**: Jefe de mantenimiento (si no hay respuesta en 4 horas)
4. **Nivel 4**: Gerente de operaciones (mantenciones críticas sin atender)

---

## 4. IMPLEMENTACIÓN TÉCNICA

### 4.1 Base de Datos

#### Tabla: `notificacion_reglas`
```sql
- id
- maquinaria_id
- tipo_notificacion (critica/preventiva/informativa)
- horas_umbral (100, 50, 24, 0)
- canales (email,sms,whatsapp)
- activa (boolean)
- created_at
- updated_at
```

#### Tabla: `notificacion_envios`
```sql
- id
- maquinaria_id
- usuario_id
- tipo
- canal
- mensaje
- estado (pendiente/enviado/fallido/leido)
- fecha_envio
- fecha_lectura
- intentos
- metadata (JSON)
- created_at
- updated_at
```

#### Tabla: `notificacion_configuracion`
```sql
- id
- usuario_id
- canal (email/sms/whatsapp)
- direccion (email/telefono)
- horario_inicio (08:00)
- horario_fin (20:00)
- dias_semana (L,M,X,J,V,S,D)
- tipos_permitidos (JSON)
- activo (boolean)
- created_at
- updated_at
```

### 4.2 Servicios de Envío

#### Email (Laravel Mail)
```php
Mail::to($supervisor->email)
    ->cc($jefeMantenimiento->email)
    ->send(new MantenimientoCritico($maquinaria));
```

#### SMS (Twilio)
```php
$twilio->messages->create(
    $supervisor->telefono,
    [
        'from' => config('services.twilio.phone'),
        'body' => "ALERTA: {$maquinaria->nombre} requiere mantención URGENTE. Horómetro: {$horometro}"
    ]
);
```

#### WhatsApp (Twilio WhatsApp Business)
```php
$twilio->messages->create(
    "whatsapp:{$supervisor->whatsapp}",
    [
        'from' => "whatsapp:" . config('services.twilio.whatsapp'),
        'body' => $mensaje,
        'mediaUrl' => [$urlReporte] // PDF con detalles
    ]
);
```

---

## 5. AUTOMATIZACIÓN

### 5.1 Laravel Scheduler (Cron Jobs)

```php
// Kernel.php
protected function schedule(Schedule $schedule)
{
    // Verificar horómetros cada hora
    $schedule->command('notificaciones:verificar-horometros')
             ->hourly()
             ->between('6:00', '22:00');
    
    // Enviar resumen diario
    $schedule->command('notificaciones:resumen-diario')
             ->dailyAt('07:00');
    
    // Reporte semanal
    $schedule->command('notificaciones:reporte-semanal')
             ->weeklyOn(1, '08:00'); // Lunes 8 AM
    
    // Verificar notificaciones no leídas
    $schedule->command('notificaciones:reenviar-criticas')
             ->everyTwoHours();
}
```

### 5.2 Jobs y Queues

```php
// Job para procesar notificaciones
class ProcesarNotificacionMantenimiento implements ShouldQueue
{
    public function handle()
    {
        // 1. Evaluar criticidad
        // 2. Determinar destinatarios
        // 3. Seleccionar canales
        // 4. Enviar por cada canal
        // 5. Registrar en base de datos
        // 6. Programar reenvío si es crítico
    }
}
```

---

## 6. PLANTILLAS DE MENSAJES

### 6.1 SMS (160 caracteres)
```
🔴 URGENTE: [MÁQUINA] excedió mantención por [X] hrs. 
Horómetro: [XXXX]
Acción requerida INMEDIATA
```

### 6.2 WhatsApp
```
🚨 *ALERTA DE MANTENIMIENTO*

*Máquina:* CAT 320 Excavadora
*Horómetro Actual:* 1,550 hrs
*Última Mantención:* 1,000 hrs
*Estado:* ⚠️ VENCIDO (50 hrs excedidas)

*Pauta Requerida:* Mantención 500 hrs
*Técnico Asignado:* Juan Pérez

*Acciones Requeridas:*
1. Detener operación
2. Programar mantención inmediata
3. Confirmar recepción respondiendo "OK"

Ver detalles: https://geoservi.cl/orden/123
```

### 6.3 Email
```html
<h2>Notificación de Mantenimiento Preventivo</h2>
<table>
    <tr>
        <td>Máquina:</td>
        <td><strong>CAT 320 Excavadora</strong></td>
    </tr>
    <tr>
        <td>Horómetro:</td>
        <td><strong>1,500 hrs</strong></td>
    </tr>
    <tr>
        <td>Próxima Mantención:</td>
        <td><strong>En 50 horas</strong></td>
    </tr>
</table>

<a href="[link]" class="button">Ver Detalles</a>
<a href="[link]" class="button">Programar Mantención</a>
```

---

## 7. DASHBOARD DE NOTIFICACIONES

### 7.1 Métricas a Mostrar
- Total de notificaciones enviadas (día/semana/mes)
- Tasa de lectura/respuesta
- Tiempo promedio de respuesta
- Notificaciones críticas sin atender
- Efectividad por canal

### 7.2 Configuración por Usuario
- Preferencias de canal
- Horarios de recepción
- Tipos de notificaciones
- Números/emails alternativos

---

## 8. INTEGRACIONES FUTURAS

### 8.1 App Móvil (React Native)
- Push notifications nativas
- Confirmación con geolocalización
- Fotos de evidencia
- Chat en tiempo real

### 8.2 Integración con ERP
- SAP PM (Plant Maintenance)
- Oracle EAM
- IBM Maximo

### 8.3 IoT y Telemetría
- Sensores en tiempo real
- Alertas automáticas por vibración
- Temperatura y presión
- Integración con sistemas SCADA

---

## 9. FLUJO DE IMPLEMENTACIÓN

### Fase 1: Base (Semana 1)
✅ Tablas de base de datos
✅ Modelos y relaciones
✅ Servicio de notificaciones base

### Fase 2: Email (Semana 2)
- Plantillas de email
- Configuración SMTP
- Jobs y queues

### Fase 3: SMS/WhatsApp (Semana 3)
- Integración Twilio
- Plantillas de mensajes
- Validación de números

### Fase 4: Automatización (Semana 4)
- Cron jobs
- Reglas de negocio
- Escalamiento

### Fase 5: Dashboard (Semana 5)
- Interfaz de configuración
- Reportes y métricas
- Testing y ajustes

---

## 10. CONSIDERACIONES DE SEGURIDAD

- **Encriptación**: Todos los números y emails encriptados
- **Autenticación**: 2FA para cambios de configuración
- **Logs**: Auditoría completa de envíos
- **Rate Limiting**: Prevenir spam de notificaciones
- **Opt-out**: Mecanismo para pausar notificaciones
- **GDPR**: Cumplimiento de privacidad de datos

---

## 11. COSTOS ESTIMADOS

### Mensual (1000 máquinas)
- **Email**: $0 (SMTP propio)
- **SMS**: $0.01 x 3000 = $30 USD
- **WhatsApp**: $0.005 x 5000 = $25 USD
- **Total**: ~$55 USD/mes

### Anual
- **Twilio**: $660 USD
- **SendGrid** (backup): $240 USD
- **Total**: ~$900 USD/año
