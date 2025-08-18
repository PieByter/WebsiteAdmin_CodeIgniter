<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BarangsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        $data = [];

        for ($i = 0; $i < 20; $i++) {
            $data[] = [
                'nama_barang' => $faker->word . ' ' . $faker->randomNumber(2),
                'dekripsi'    => $faker->sentence(8),
                'stok'        => $faker->numberBetween(0, 1000),
                'harga'       => $faker->numberBetween(1000, 100000),
                'foto'        => null, // atau 'default.jpg'
                'created_at'  => $faker->date('Y-m-d H:i:s'),
                'updated_at'  => $faker->date('Y-m-d H:i:s'),
            ];
        }

        $this->db->table('barangs')->insertBatch($data);
    }
}
