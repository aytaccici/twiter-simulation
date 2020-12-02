<?php

use Illuminate\Database\Seeder;
use \App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = json_decode(file_get_contents('https://5fc665324931580016e3cf4e.mockapi.io/users'),true);

        $insertedUser=array();

        foreach ($users as $user) {

            $insertedUser[] = [
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'name' => $user['name'],
                'surname' => $user['surname'],
                'email' => $user['email'],
                'phone_number' => $user['phoneNumber'],
                'twitter' => $user['username'],
                'twitter_id' => $user['id'],
                'api_token' => $user['apiToken'],
                'is_verified' => true
            ];
        }

        User::insert($insertedUser);

    }
}
