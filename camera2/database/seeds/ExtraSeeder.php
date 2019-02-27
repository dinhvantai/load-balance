<?php

use App\Models\Extra;
use Illuminate\Database\Seeder;

class ExtraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Extra::create([
            'option' => json_encode([
                'title' => 'Camera',
                'logo' => 'images/icons/logo.png',
            ]),
            'position' =>  Extra::POSITION_MAIN,
        ]);
    }
}
