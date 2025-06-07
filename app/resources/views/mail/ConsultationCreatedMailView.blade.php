<!DOCTYPE html>
<html>
<head>
    <title>Консультация создана</title>
</head>
<body>
<h2>Уважаемый(ая) {{ $appointment->patient_name }},</h2>

<p>Ваша консультация успешно создана! 🎉</p>

<p><strong>Текущий статус:</strong> {{ $statusLabel }}</p>

<p>Мы уведомим вас о изменении статуса консультации:</p>
<ul>
    <li>По электронной почте</li>
    <li>По телефону: {{ $appointment->patient_phone }}</li>
    @if($appointment->telegram_id)
        <li>Через Telegram-уведомление</li>
    @endif
</ul>

<p>Детали консультации:</p>
<ul>
    <li><strong>Специализация:</strong> {{ $appointment->specialization->name ?? 'Не указана' }}</li>
    <li><strong>Врач:</strong> {{ $appointment->doctor->user->full_name }}</li>
    <li><strong>Дата создания:</strong> {{ $appointment->created_at->format('d.m.Y H:i') }}</li>
    <li><strong>Ваш комментарий:</strong> {{ $appointment->patient_comment ?? 'не указан' }}</li>
</ul>

<p>Вы можете отслеживать статус консультации в личном кабинете:</p>
<a href="{{ $consultationUrl }}" style="display: inline-block; padding: 10px 20px; background: #3490dc; color: white; text-decoration: none; border-radius: 4px;">
    Перейти к консультации
</a>

<p style="margin-top: 20px;">С уважением,<br>{{ config('app.name') }}</p>
</body>
</html>
