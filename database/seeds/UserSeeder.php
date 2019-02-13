<?php

use Illuminate\Database\Seeder;
use App\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Developer',
            'gender' => 'Male',
            'address' => 'Philippines',
            'age' => '20',
            'email' => 'developer@yahoo.com.ph',
            'password' => bcrypt('qweasdzxc321'),
            'contact' => '639774414592',
            'created_at' => new Carbon(),
            'email_verified_at' => new Carbon(),
            'role' => 'ADMIN',
            'profileImage' => 'yukihira.jpg'
        ]);

        $user1 = User::create([
            'name' => 'Yukihira Souma',
            'gender' => 'Male',
            'address' => 'Philippines',
            'age' => '20',
            'email' => 'yukihirasouma@yahoo.com',
            'password' => bcrypt('1234'),
            'contact' => '639774414592',
            'created_at' => new Carbon(),
            'email_verified_at' => new Carbon(),
            'role' => 'USER',
            'profileImage' => 'yukihira.jpg'
        ]);
    }
}
