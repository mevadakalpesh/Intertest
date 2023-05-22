<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Seeder
{
  /**
  * Run the database seeds.
  */
  public function run(): void
  {
    
    User::updateOrCreate([
      'name' => 'admin',
      'email' => 'admin@test.com',
      ],[
      'name' => 'admin',
      'email' => 'admin@test.com',
      'password' => Hash::make(123456),
      'phone' => 0,
      'is_admin' => 1,
    ]);
    
  }
}