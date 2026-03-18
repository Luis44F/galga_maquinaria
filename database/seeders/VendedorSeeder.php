<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendedor;

class VendedorSeeder extends Seeder
{
    public function run(): void
    {
        $vendedores = [
            ['nombre' => 'CHIMEX', 'email' => 'chimex@galga.com'],
            ['nombre' => 'MAFE', 'email' => 'mafe@galga.com'],
            ['nombre' => 'FABIO', 'email' => 'fabio@galga.com'],
            ['nombre' => 'KELLY', 'email' => 'kelly@galga.com'],
            ['nombre' => 'DANI', 'email' => 'dani@galga.com'],
            ['nombre' => 'LUIS', 'email' => 'luis@galga.com'],
            ['nombre' => 'DANIEL', 'email' => 'daniel@galga.com'],
            ['nombre' => 'ESTEFANY', 'email' => 'estefany@galga.com'],
            ['nombre' => 'CAMILA', 'email' => 'camila@galga.com'],
            ['nombre' => 'VICTOR', 'email' => 'victor@galga.com'],
            ['nombre' => 'SANDRA', 'email' => 'sandra@galga.com'],
            ['nombre' => 'DIEGO', 'email' => 'diego@galga.com'],
            ['nombre' => 'FELIPE', 'email' => 'felipe@galga.com'],
            ['nombre' => 'MILENA', 'email' => 'milena@galga.com'],
            ['nombre' => 'SANDRO', 'email' => 'sandro@galga.com'],
            ['nombre' => 'LUCHO', 'email' => 'lucho@galga.com'],
        ];

        foreach ($vendedores as $vendedor) {
            Vendedor::create($vendedor);
        }
    }
}