<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Reinicio automático de la Base de Datos DEMO cada 12 horas (a las 00:00 y a las 12:00)
// Se incluye el flag --force para evitar confirmaciones interactivas en producción y --seed para re-sembrar los datos base.
// runInBackground() garantiza que el proceso no bloquee el hilo principal del servidor.
Schedule::command('migrate:fresh --seed --force')
    ->twiceDaily(0, 12)
    ->runInBackground();

