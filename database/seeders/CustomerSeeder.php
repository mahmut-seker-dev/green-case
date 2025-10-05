<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('tr_TR');

        $userIds = DB::table('users')->pluck('id')->toArray(); // 3 user id’sini al

        $total = 10000;
        $batchSize = 100;

        for ($b = 0; $b < $total / $batchSize; $b++) {
            $rows = [];

            for ($i = 0; $i < $batchSize; $i++) {
                $index = $b * $batchSize + $i + 1;

                $rows[] = [
                    'code'       => 'CMP' . str_pad($index, 6, '0', STR_PAD_LEFT),
                    'name'       => $faker->company(),
                    'address'    => $faker->address(),
                    'phone'      => $faker->phoneNumber(),
                    'email'      => $faker->unique()->companyEmail(),
                    'created_by' => $faker->randomElement($userIds), // her zaman 3 kullanıcıdan biri
                    'updated_by' => $faker->boolean(30) ? null : $faker->randomElement($userIds), // %30 null
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('customers')->insert($rows);

            $this->command->info("Inserted " . (($b + 1) * $batchSize) . " / $total");
        }
    }
}
