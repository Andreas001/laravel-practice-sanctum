<?php

namespace Database\Seeders;

use App\Models\Profiling\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fileName = __DIR__ . '/Data/Users.csv';
        $csvData = file_get_contents($fileName);
        $lines = explode(PHP_EOL, $csvData);

        foreach ($lines as $line) {
            $array = str_getcsv($line);

            // if (10 !== count($array)) {
            //     continue;
            // }

            User::insert([
                'id'            => $array[0],
                'username'      => $array[1],
                'password'      => Hash::make($array[2]),
            ]);
        }
    }
}
