<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Maquina;
use App\Models\MaquinaModelo;
use Carbon\Carbon;

class MaquinaSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener algunos modelos de ejemplo
        $modeloD6T = MaquinaModelo::where('modelo', '1502')->first();
        $modeloPC200 = MaquinaModelo::where('modelo', '1504')->first();
        $modelo950H = MaquinaModelo::where('modelo', '1501')->first();

        if ($modeloD6T && $modeloPC200 && $modelo950H) {
            $maquinas = [
                [
                    'modelo_id' => $modeloD6T->id,
                    'numero_serie' => 'CAT-2024-001',
                    'año_fabricacion' => 2024,
                    'estado' => 'disponible',
                    'ubicacion_actual' => 'Bodega Central',
                    'precio_venta' => 450000,
                    'fecha_ingreso' => Carbon::now()->subDays(30),
                ],
                [
                    'modelo_id' => $modeloPC200->id,
                    'numero_serie' => 'KOM-2024-023',
                    'año_fabricacion' => 2024,
                    'estado' => 'en_transito',
                    'ubicacion_actual' => 'En Puerto',
                    'precio_venta' => 320000,
                    'fecha_ingreso' => Carbon::now()->subDays(15),
                ],
                [
                    'modelo_id' => $modelo950H->id,
                    'numero_serie' => 'CAT-2023-156',
                    'año_fabricacion' => 2023,
                    'estado' => 'orden_pendiente',
                    'ubicacion_actual' => 'Fábrica',
                    'precio_venta' => 280000,
                    'fecha_ingreso' => Carbon::now()->subDays(45),
                ],
                [
                    'modelo_id' => $modeloD6T->id,
                    'numero_serie' => 'VOL-2024-089',
                    'año_fabricacion' => 2024,
                    'estado' => 'vendida',
                    'ubicacion_actual' => 'Entregado',
                    'precio_venta' => 520000,
                    'fecha_venta' => Carbon::now()->subDays(10),
                ],
            ];

            foreach ($maquinas as $maquina) {
                Maquina::create($maquina);
            }
        }
    }
}