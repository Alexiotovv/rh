<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {
        DB::table('users')->insert([
            'name'=>'admin',
            'email'=>'admin@gmail.com',
            'role'=>1,
            'status'=>1,
            'password'=>bcrypt('#1984'),
        ]);
        
        DB::table('agrarios_tipocreditos')->insert([
            ['nombre' => 'CRÉDITO AGRARIOS'],
            ['nombre' => 'MICROCRÉDITOS']
        ]);

        DB::table('direcciones')->insert([
            'nombre'=>'OFICINA DE PRUEBA',
        ]);
        DB::table('numerocartas')->insert([
            'numero_carta'=>1,
        ]);

        DB::table('tipo_personas')->insert([
            ['codigo' => '01','nombre' => 'NATURAL'],
            ['codigo' => '02','nombre'=>'JURÍDICO']
        ]);

        DB::table('condicion_laborals')->insert([
            ['nombre' => 'NOMBRADO', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'CAS', 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('tipo_creditos')->insert([
            ['nombre' => 'AMPLIACIÓN', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'NUEVO', 'created_at' => now(), 'updated_at' => now()],
        ]);

         DB::table('entidades')->insert([
            ['nombre' => 'BBVA', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'BCP', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'INTERBANK', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'SCOTIABANK', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'MIBANCO', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'BANCO DE LA NACIÓN', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('ingresos')->insert([
            ['nombre' => 'HABER MENSUAL', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'GUARDIA', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'BONO APS', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('egresos')->insert([
            ['nombre' => 'JUDICIAL', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'ONP', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'AFP', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'SUNAT', 'created_at' => now(), 'updated_at' => now()],
        ]);



        $procedureExists = DB::select("SHOW PROCEDURE STATUS WHERE Db = DATABASE() AND Name = 'sp_scc_pagos'");

        if (empty($procedureExists)) {

            DB::statement("
                CREATE PROCEDURE sp_scc_pagos()
                BEGIN
                    SELECT 
                        YEAR(pagos.fecha) AS anho,
                        MONTH(pagos.fecha) AS mes_numero,
                        MONTHNAME(pagos.fecha) AS mes_nombre,
                        SUM(pagos.monto) AS total_pagos
                    FROM pagos
                    WHERE pagos.fecha >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                    GROUP BY YEAR(pagos.fecha), MONTHNAME(pagos.fecha), MONTH(pagos.fecha)
                    ORDER BY YEAR(pagos.fecha), MONTH(pagos.fecha) DESC;
                END
            ");
        }

        $path = base_path('ubigeos.sql');
        DB::unprepared(File::get($path));

    }
}
