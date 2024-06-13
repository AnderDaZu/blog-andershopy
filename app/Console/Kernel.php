<?php

namespace App\Console;

use App\Models\Image;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Storage;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        // Limpieza de imagenes
        $schedule->call(function(){
            $files = Storage::files('images');
            $images = Image::pluck('path')->toArray();
            Storage::delete(array_diff($files, $images));
        })->daily();

        // para ejecutar esta tarea programada desde línea de comandos
        // php artisan schedule:work
    }

}