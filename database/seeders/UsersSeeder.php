<?php

namespace Database\Seeders;

use App\Enum\ActivationStatusEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'admin',
            'email'=>'admin@gmail.com',
            'password'=>'123456',
            'type'=>1,
            'is_active'=>ActivationStatusEnum::ACTIVE,
        ]);
        User::create([
            'name'=>'employee 1',
            'email'=>'emp1@gmail.com',
            'password'=>'123456',
            'type'=>2,
            'is_active'=>ActivationStatusEnum::ACTIVE,
        ]);
        User::create([
            'name'=>'employee 2',
            'email'=>'emp2@gmail.com',
            'password'=>'123456',
            'type'=>2,
            'is_active'=>ActivationStatusEnum::NOT_ACTIVE,
        ]);
    }
}
