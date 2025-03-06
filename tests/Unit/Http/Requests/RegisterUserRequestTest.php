<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\Auth\RegisterUserRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class RegisterUserRequestTest extends TestCase
{
    public function test_register_user_request_passes_with_valid_data()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $request = new RegisterUserRequest();
        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes());
    }

    public function test_register_user_request_fails_with_invalid_email()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $request = new RegisterUserRequest();
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
    }

    public function test_register_user_request_fails_when_password_confirmation_does_not_match()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'wrongpassword',
        ];

        $request = new RegisterUserRequest();
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('password', $validator->errors()->toArray());
    }
}
