<?php use App\Enums\ConsultationStatusesEnum;?>
<!DOCTYPE html>
<html>
<head>
    <title>Статус консультации</title>
</head>
<body>
<h2>Уважаемый(ая) {{ $appointment->patient_name }},</h2>

<p>Статус вашей консультации изменен на: <strong>{{ $statusLabel }}</strong></p>

@if($appointment->status === ConsultationStatusesEnum::CONFIRMED->value)
    <p><strong>Дата и время:</strong> {{ $appointment->appointment_date->format('d.m.Y H:i') }}</p>
@endif

@if($appointment->status === ConsultationStatusesEnum::DECLINED->value && $appointment->cancel_reason)
    <p><strong>Причина отмены:</strong> {{ $appointment->cancel_reason }}</p>
@endif

@if($appointment->status === ConsultationStatusesEnum::COMPLETED->value)
    <p><strong>Заключение врача:</strong> {{ $appointment->conclusion ?? 'доступно в личном кабинете' }}</p>
@endif

<p>Для просмотра подробной информации перейдите по ссылке:</p>
<a href="{{ $consultationUrl }}" style="display: inline-block; padding: 10px 20px; background: #3490dc; color: white; text-decoration: none; border-radius: 4px;">
    Перейти к консультации
</a>

<p style="margin-top: 20px;">С уважением,<br>{{ config('app.name') }}</p>
</body>
</html>
