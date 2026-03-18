<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'LASER', 'descripcion' => 'Máquinas de corte láser'],
            ['nombre' => 'BORDADORAS', 'descripcion' => 'Máquinas bordadoras de diferentes tipos'],
            ['nombre' => 'DOBLADORAS', 'descripcion' => 'Máquinas dobladoras de tela'],
            ['nombre' => 'WORLDEN', 'descripcion' => 'Máquinas de confección Worlden'],
            ['nombre' => 'MIMAKI', 'descripcion' => 'Plotters Mimaki'],
            ['nombre' => 'TEJEDORAS', 'descripcion' => 'Tejedoras de cuellos y prendas'],
            ['nombre' => 'DTF', 'descripcion' => 'Plotters DTF (Direct to Film)'],
            ['nombre' => 'CIXING', 'descripcion' => 'Tejedoras Steiger y máquinas de tejido'],
            ['nombre' => 'CIRCULARES', 'descripcion' => 'Máquinas circulares para calcetines'],
            ['nombre' => 'ENCONADORAS', 'descripcion' => 'Enconadoras y bobinadoras'],
            ['nombre' => 'SANTONI', 'descripcion' => 'Máquinas circulares Santoni'],
            ['nombre' => 'ADITAMENTOS', 'descripcion' => 'Aditamentos y accesorios'],
            ['nombre' => 'SOMAX', 'descripcion' => 'Máquinas de confección automatizadas'],
            ['nombre' => 'GUANTES', 'descripcion' => 'Máquinas para fabricación de guantes'],
            ['nombre' => 'GORROS', 'descripcion' => 'Máquinas para fabricación de gorros'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}