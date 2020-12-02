<?php

namespace Tests\Feature;

use App\Repositories\UserRepository;
use Illuminate\Foundation\Auth\User;
use Tests\TestCase;

class AuthTest extends TestCase
{


    private function getUserJson()
    {
        return json_decode('{
           "name": "Aytaç",
           "surname": "Cici",
           "email": "aytaccici@gmail.com",
           "phone_number": "5557494998",
           "twitter" : "aytaccici",
           "password" : "123456"
        }', true);


    }

    /**
     * Check whether email is required to login
     */
    public function test_it_requires_an_email()
    {
        $this->json('POST', 'api/v1/auth/login')
            ->assertStatus(400);
    }

    /**
     * Can Inserted a new user to database
     */
    public function test_it_register_user()
    {
        $this->json('POST', 'api/v1/auth/register', $this->getUserJson())
            ->assertStatus(201);
    }


    /** Recorded user can be login*/
    public function test_it_can_login_user()
    {
        $this->json('POST', 'api/v1/auth/login', [
            'email'    => 'Nikki.Murazik@yahoo.com',
            'password' => 'password',
        ])
            ->assertStatus(200);
    }

    /** Recorded user cant be login with wrong email or password */
    public function test_it_cant_login_wrong_info()
    {
        $this->json('POST', 'api/v1/auth/login', [
            'email'    => 'Nikki.Murazik@yahoo.com',
            'password' => '12345',
        ])
            ->assertStatus(400);
    }


    public function test_it_cant_verify_not_not_recorder_user()
    {

        $this->json('POST', 'api/v1/auth/verify', [
            'email' => 'not_recorded',
            'code'  => 'not_recorded'
        ])
            ->assertStatus(404);
    }


    /**
     * Can Verify Testing User
     */
    public function test_it_can_verify_recorder_user()
    {
        $user = factory(\App\User::class)->make();

        $user = $user->attributesToArray();

        $user['password'] = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // password

        $userRepository = new UserRepository();

        $recordedUser = $userRepository->store($user);

        $this->json('POST', 'api/v1/auth/verify', [
            'email' => $recordedUser->email,
            'code'  => $recordedUser->verification_code
        ])
            ->assertStatus(200);

        $isVerify = $userRepository->show($recordedUser->id);

        $this->assertEquals(1, $isVerify->is_verified);

    }

}
