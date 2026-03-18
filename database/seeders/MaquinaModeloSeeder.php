<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MaquinaModelo;
use App\Models\Categoria;

class MaquinaModeloSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener IDs de categorías
        $categoriaLaser = Categoria::where('nombre', 'LASER')->first()->id;
        $categoriaBordadoras = Categoria::where('nombre', 'BORDADORAS')->first()->id;
        $categoriaTejedoras = Categoria::where('nombre', 'TEJEDORAS')->first()->id;

        $modelos = [
            // Modelos LASER
            [
                'categoria_id' => $categoriaLaser,
                'marca' => 'CHIMEX',
                'modelo' => 'GL1620-2-2A-VF',
                'tipo_maquina' => 'CORTADORA LASER DOBLE RIEL, DOBLE CAÑON',
                'especificaciones' => '1.60*1.40'
            ],
            [
                'categoria_id' => $categoriaLaser,
                'marca' => 'CHIMEX',
                'modelo' => 'ETM-AS1614-2A-VF-C',
                'tipo_maquina' => 'CORTADORA LASER DOBLE RIEL',
                'especificaciones' => '1.60*1.40'
            ],
            // Modelos BORDADORAS
            [
                'categoria_id' => $categoriaBordadoras,
                'marca' => 'ETM',
                'modelo' => '1502',
                'tipo_maquina' => 'BORDADORA 2 CABEZAS',
            ],
            [
                'categoria_id' => $categoriaBordadoras,
                'marca' => 'ETM',
                'modelo' => '1504',
                'tipo_maquina' => 'BORDADORA 4 CABEZAS',
            ],
            [
                'categoria_id' => $categoriaBordadoras,
                'marca' => 'ETM',
                'modelo' => '1501',
                'tipo_maquina' => 'BORDADORA 1 CABEZA',
            ],
            [
                'categoria_id' => $categoriaBordadoras,
                'marca' => 'FUWEI',
                'modelo' => 'FW-1501R',
                'tipo_maquina' => 'BORDADORA 1 CABEZA 15 AGUJAS',
            ],
            [
                'categoria_id' => $categoriaBordadoras,
                'marca' => 'FUWEI',
                'modelo' => 'FW-1506C',
                'tipo_maquina' => 'BORDADORA 6 CABEZAS 15 AGUJAS',
            ],
            [
                'categoria_id' => $categoriaBordadoras,
                'marca' => 'FUWEI',
                'modelo' => 'FW-1508C',
                'tipo_maquina' => 'BORDADORA 8 CABEZAS 15 AGUJAS',
            ],
            [
                'categoria_id' => $categoriaBordadoras,
                'marca' => 'BC',
                'modelo' => 'BC-1501',
                'tipo_maquina' => 'BORDADORA 1 CABEZA',
            ],
            [
                'categoria_id' => $categoriaBordadoras,
                'marca' => 'BC',
                'modelo' => 'BC-1502',
                'tipo_maquina' => 'BORDADORA 2 CABEZAS',
            ],
            [
                'categoria_id' => $categoriaBordadoras,
                'marca' => 'BC',
                'modelo' => 'BC-1504',
                'tipo_maquina' => 'BORDADORA 4 CABEZAS',
            ],
            // Modelos TEJEDORAS
            [
                'categoria_id' => $categoriaTejedoras,
                'marca' => 'ETM',
                'modelo' => 'ETM 1 52 G 14',
                'tipo_maquina' => 'TEJEDORA CUELLOS 52"',
            ],
            [
                'categoria_id' => $categoriaTejedoras,
                'marca' => 'ETM',
                'modelo' => 'ETM 60 1+1 G14',
                'tipo_maquina' => 'TEJEDORA CUELLOS 60" 2 CARROS',
            ],
            [
                'categoria_id' => $categoriaTejedoras,
                'marca' => 'ETM',
                'modelo' => 'ETM1X252S G14',
                'tipo_maquina' => 'TEJEDORA CUELLOS 52" 2 SISTEMAS SIN SINKERS',
            ],
            [
                'categoria_id' => $categoriaTejedoras,
                'marca' => 'NEW HP',
                'modelo' => 'NEW HP2-52C 5/7G',
                'tipo_maquina' => 'TEJEDORA NEW HP 2 SISTEMAS 52 PULGADAS 5.7 GG',
            ],
            [
                'categoria_id' => $categoriaTejedoras,
                'marca' => 'NEW HP',
                'modelo' => 'NEW HP2-52C 6.2G',
                'tipo_maquina' => 'TEJEDORA NEW HP 2 SISTEMAS 52 PULGADAS 6.2 GG',
            ],
            [
                'categoria_id' => $categoriaTejedoras,
                'marca' => 'NEW HP',
                'modelo' => 'NEW HP3-52C 5/7G',
                'tipo_maquina' => 'TEJEDORA NEW HP 3 SISTEMAS 52 PULGADAS 5.7 GG',
            ],
            [
                'categoria_id' => $categoriaTejedoras,
                'marca' => 'NEW HP',
                'modelo' => 'NEW HP3-52C 6.2G',
                'tipo_maquina' => 'TEJEDORA NEW HP 3 SISTEMAS 52 PULGADAS 6.2 GG',
            ],
        ];

        foreach ($modelos as $modelo) {
            MaquinaModelo::create($modelo);
        }
    }
}