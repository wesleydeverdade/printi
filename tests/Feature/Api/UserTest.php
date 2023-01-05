<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Fail when create user without fields
     *
     * @return void
     */
    public function test_fail_when_create_user_without_fields(): void
    {
        $this->json('POST', 'api/register', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The name field is required. (and 2 more errors)",
                "errors" => [
                    "name" => ["The name field is required."],
                    "email" => ["The email field is required."],
                    "password" => ["The password field is required."],
                ]
            ]);
    }

    /**
     * Fail when create user with weak password
     *
     * @return void
     */
    public function test_fail_when_create_user_with_weak_password(): void
    {
        $userData = [
            "name" => "Super Admin",
            "email" => "superadmin@printi.com.br",
            "password" => "abcd1234"
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message"=> "The given password has appeared in a data leak. Please choose a different password.",
                "errors"=> [
                    "password"=> [
                        "The given password has appeared in a data leak. Please choose a different password."
                    ]
                ]
            ]);
    }

    /**
     * Fail when create user with invalid email
     *
     * @return void
     */
    public function test_fail_when_create_user_with_invalid_email(): void
    {
        $userData = [
            "name" => "Super Admin",
            "email" => "test@example.com",
            "password" => "FnVH<3,6)(;1FseP"
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message"=> "The email must be a valid email address.",
                "errors"=> [
                    "email"=> [
                        "The email must be a valid email address."
                    ]
                ]
            ]);
    }

    /**
     * Fail when create duplicate email
     *
     * @return void
     */
    public function test_fail_when_create_duplicate_email(): void
    {

        $userData = [
            "name" => "Super Admin",
            "email" => "test@printi.com.br",
            "password" => "FnVH<3,6)(;1FseP"
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json']);

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The email has already been taken.",
                "errors" => [
                    "email"=> [
                        "The email has already been taken."
                    ]
                ]
            ]);
    }

    /**
     * Successfully create one user
     *
     * @return void
     */
    public function test_successfully_registration_user(): void
    {
        $userData = [
            "name" => "Super Admin",
            "email" => "superadmin@printi.com.br",
            "password" => "FnVH<3,6)(;1FseP"
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'name',
                'email',
            ]);
    }
}
