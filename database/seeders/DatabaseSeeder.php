<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ====================================================================
        // 1. LIMPIEZA TRANSACCIONAL COMPATIBLE CON INNODB
        // ====================================================================
        // Se desactivan temporalmente las restricciones de clave foránea
        // para poder truncar las tablas en el orden correcto sin errores.
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('prestamos_herramientas')->truncate();
        DB::table('detalle_servicios')->truncate();
        DB::table('ordenes_servicio')->truncate();
        DB::table('motos')->truncate();
        DB::table('herramientas')->truncate();
        DB::table('servicios')->truncate();
        DB::table('users')->truncate();          // Se limpia también users
        DB::table('empleados')->truncate();
        DB::table('clientes')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ====================================================================
        // 2. PERSONAL DEL TALLER FAMILIAR (5 PERSONAS REALES)
        // ====================================================================
        // El taller opera con estructura familiar: 1 propietario, 1 operario
        // de recepción y 3 técnicos mecánicos. Solo el propietario y el
        // operario tendrán credenciales de acceso al sistema.
        DB::table('empleados')->insert([
            [
                'id_empleado' => 1,
                'nombre_empleado' => 'Jaime Noco',
                'cargo' => 'propietario',
                'telefono_empleado' => '75012345',
                'estado' => 'activo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_empleado' => 2,
                'nombre_empleado' => 'Operario Familiar',
                'cargo' => 'operario',
                'telefono_empleado' => '75054321',
                'estado' => 'activo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_empleado' => 3,
                'nombre_empleado' => 'Jesus Mae',
                'cargo' => 'tecnico',
                'telefono_empleado' => '70000003',
                'estado' => 'activo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_empleado' => 4,
                'nombre_empleado' => 'Daniel Tamo',
                'cargo' => 'tecnico',
                'telefono_empleado' => '70000004',
                'estado' => 'activo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_empleado' => 5,
                'nombre_empleado' => 'Ceferino Noe',
                'cargo' => 'tecnico',
                'telefono_empleado' => '70000005',
                'estado' => 'activo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ====================================================================
        // 3. USUARIOS DEL SISTEMA (LOGIN + RBAC)
        // ====================================================================
        // Solo el propietario y el operario poseen credenciales.
        // Los técnicos NO acceden al sistema por las condiciones del área
        // de trabajo (grasa, polvo, lubricantes). Su consulta es pasiva
        // desde dispositivos móviles en una fase posterior.
        //
        // IMPORTANTE: Ajusta el campo 'rol' según tu migración real de users.
        // Si tu tabla users no tiene columna 'rol', agrega la migración
        // correspondiente o usa una tabla pivote.
       DB::table('users')->insert([
    // ---- Propietario ----
    [
        'id' => 1,
        'name' => 'Jaime Noco',
        'email' => 'jaime.noco@cirujano.local',
        'password' => Hash::make('admin123'),
        'rol' => 'propietario',
        'id_empleado' => 1,
        'email_verified_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ],
    // ---- Operario de Recepción ----
    [
        'id' => 2,
        'name' => 'Operario Familiar',
        'email' => 'operario@cirujano.local',
        'password' => Hash::make('operario123'),
        'rol' => 'operario',
        'id_empleado' => 2,
        'email_verified_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ],
    // ---- Técnico 1: Jesus Mae ----
    [
        'id' => 3,
        'name' => 'Jesus Mae',
        'email' => 'jesus.mae@cirujano.local',
        'password' => Hash::make('tecnico123'),
        'rol' => 'tecnico',
        'id_empleado' => 3,
        'email_verified_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ],
    // ---- Técnico 2: Daniel Tamo ----
    [
        'id' => 4,
        'name' => 'Daniel Tamo',
        'email' => 'daniel.tamo@cirujano.local',
        'password' => Hash::make('tecnico123'),
        'rol' => 'tecnico',
        'id_empleado' => 4,
        'email_verified_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ],
    // ---- Técnico 3: Ceferino Noe ----
    [
        'id' => 5,
        'name' => 'Ceferino Noe',
        'email' => 'ceferino.noe@cirujano.local',
        'password' => Hash::make('tecnico123'),
        'rol' => 'tecnico',
        'id_empleado' => 5,
        'email_verified_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);

        // ====================================================================
        // 4. CATÁLOGO DE MANO DE OBRA (PRECIOS EN BS.)
        // ====================================================================
        DB::table('servicios')->insert([
            ['id_servicio' => 1, 'nombre_servicio' => 'Mantenimiento preventivo / Cambio de aceite', 'precio_mano_obra' => 30.00, 'created_at' => now(), 'updated_at' => now()],
            ['id_servicio' => 2, 'nombre_servicio' => 'Afinado completo de motor y carburador', 'precio_mano_obra' => 120.00, 'created_at' => now(), 'updated_at' => now()],
            ['id_servicio' => 3, 'nombre_servicio' => 'Reparación de suspensión delantera (Baches)', 'precio_mano_obra' => 150.00, 'created_at' => now(), 'updated_at' => now()],
            ['id_servicio' => 4, 'nombre_servicio' => 'Alineación y parchado de llanta', 'precio_mano_obra' => 20.00, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ====================================================================
        // 5. HERRAMIENTAS DE PRECISIÓN (ACTIVOS FIJOS)
        // ====================================================================
        DB::table('herramientas')->insert([
            ['id_herramienta' => 1, 'codigo_herramienta' => 'HER-001', 'nombre_herramienta' => 'Juego de Llaves Socket Métrica', 'estado' => 'disponible', 'created_at' => now(), 'updated_at' => now()],
            ['id_herramienta' => 2, 'codigo_herramienta' => 'HER-002', 'nombre_herramienta' => 'Pistola Neumática de Impacto', 'estado' => 'disponible', 'created_at' => now(), 'updated_at' => now()],
            ['id_herramienta' => 3, 'codigo_herramienta' => 'HER-003', 'nombre_herramienta' => 'Compresor de Anillos de Pistón', 'estado' => 'disponible', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ====================================================================
        // 6. CLIENTE Y MOTOCICLETA DE PRUEBA
        // ====================================================================
        DB::table('clientes')->insert([
            'id_cliente' => 1,
            'nombre' => 'Carlos Mendoza',
            'telefono' => '78945612',
            'direccion' => 'Av. Principal #123, Trinidad',
            'nit_ci' => '1234567015',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('motos')->insert([
            'id_moto' => 1,
            'placa' => '2534-XYZ',
            'id_cliente' => 1,
            'marca' => 'Honda',
            'modelo' => 'XR 250 Tornado',
            'color' => 'Rojo',
            'fecha_ultimo_mantenimiento' => now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}