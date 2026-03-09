<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginTest extends TestCase
{
    public function test_login_and_check_password_rehash()
    {
        $user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => Hash::make('123456'),
        ]);

        dump('Before login hash:', $user->password);
        dump('Before hash info:', Hash::info($user->password));

        dump('bcrypt rounds config:', config('hashing.bcrypt.rounds'));
        dump('needsRehash:', Hash::needsRehash($user->password));

        Auth::attempt([
            'email' => 'test@test.com',
            'password' => '123456'
        ]);

        $user->refresh();

        dump('After login hash:', $user->password);
        // dump('After hash info:', Hash::info($user->password));

        $this->assertTrue(true);
    }
}
