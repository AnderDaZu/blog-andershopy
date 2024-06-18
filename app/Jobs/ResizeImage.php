<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as ImageIntervention;

class ResizeImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $image_path;

    /**
     * Create a new job instance.
     */
    public function __construct($image_path)
    {
        $this->image_path = $image_path;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {   
        // ini_set('memory_limit', "2000M"); // para asignar cantidad de memoria

        $file_path = public_path('storage/' . $this->image_path);
        list($width) = getimagesize($file_path);
        $size = filesize($file_path);
        $filesize = round(($size / 1048576), 2);

        // si el ancho de la imagen es mayor a 1200 o el tamaño del archivo es mayor a 0.2 MB
        // se redimensiona la imagen
        if ($width > 1200 || $filesize > 0.2) 
        {    
            // cuando se trabaja desde jobs tanto para obtener como para guardar la imagen cambia de acuerdo a como se hizo en el controlador
            $image = Storage::get($this->image_path);

            // $path_img = 'storage/' . $this->image_path;
            // $img = ImageIntervention::make($path_img);
            $img = ImageIntervention::make($image);

            if ($width > 1200) {
                $img->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }

            if ($filesize > 0.2) {
                // $img->save($path_img, 80, 'jpg');
                $img->stream('jpg', 80);
            } else {
                // $img->save();
                $img->stream();
            }

            Storage::put($this->image_path, $img);
        }

    }
}
