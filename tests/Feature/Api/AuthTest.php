<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Fail when authenticate withouth email and password
     *
     * @return void
     */
    public function test_fail_when_authenticate_without_email_and_password(): void
    {
        $this->json('POST', 'api/login', [], ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthorized.']);;
    }

    /**
     * Fail when authenticate with wrong fields
     *
     * @return void
     */
    public function test_fail_when_authenticate_with_wrong_fields(): void
    {
        $user = User::factory()->create();

        $loginData = [
            "email" => "superadmin@printi.com.br",
            "password" => "FnVH<3,6)(;1FseP**********"
        ];

        $this->json('POST', 'api/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthorized.']);;
    }

    /**
     * Fail when authenticate with wrong password
     *
     * @return void
     */
    public function test_fail_when_authenticate_with_wrong_password(): void
    {
        $user = User::factory()->create();

        $loginData = [
            "email" => $user->email,
            "password" => "FnVH<3,6)(;1FseP**********"
        ];

        $this->json('POST', 'api/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthorized.']);;
    }

    /**
     * Fail when authenticate with wrong email
     *
     * @return void
     */
    public function test_fail_when_authenticate_with_wrong_email(): void
    {
        $user = User::factory()->create();

        $loginData = [
            "email" => "superadmin__@printi.com.br",
            "password" => $user->password
        ];

        $this->json('POST', 'api/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthorized.']);
    }

    /**
     * Succefully auth one user
     *
     * @return void
     */
    public function test_successfully_authenticate_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->json('GET', 'api/movies', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

    /**
     * List one category unauthenticated
     *
     * @return void
     */
    public function test_fail_list_one_category_unauthenticated(): void
    {
        $this->json('GET', 'api/categories/1', ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    /**
     * List all categories unauthenticated
     *
     * @return void
     */
    public function test_fail_list_all_categories_unauthenticated(): void
    {
        $this->json('GET', 'api/categories/', ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

    }

    /**
     * Create one category unauthenticated
     *
     * @return void
     */
    public function test_fail_create_one_category_unauthenticated(): void
    {
        $this->json('POST', 'api/categories/', ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

    }

    /**
     * Update one category unauthenticated
     *
     * @return void
     */
    public function test_fail_update_one_category_unauthenticated(): void
    {
        $this->json('PUT', 'api/categories/1', ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

    }

    /**
     * Delete one category unauthenticated
     *
     * @return void
     */
    public function test_fail_delete_one_category_unauthenticated(): void
    {
        $this->json('DELETE', 'api/categories/1', ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

    }

    /**
     * List one category authenticated
     *
     * @return void
     */
    public function test_successfully_list_one_category_authenticated(): void
    {
        $category = Category::factory()->create();

        $user = User::factory()->create();

        $this->actingAs($user)->json('GET', 'api/categories/'. $category->id, ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

    /**
     * List all categories authenticated
     *
     * @return void
     */
    public function test_successfully_list_all_categories_authenticated(): void
    {
        $category = Category::factory()->create();

        $user = User::factory()->create();

        $this->actingAs($user)->json('GET', 'api/categories/', ['Accept' => 'application/json'])
            ->assertStatus(200);

    }

    /**
     * Create one category authenticated
     *
     * @return void
     */
    public function test_successfully_create_one_category_authenticated(): void
    {
        $user = User::factory()->create();

        $categoryData = [
            "name" => "Comedy"
        ];

        $this->actingAs($user)->json('POST', 'api/categories/', $categoryData, ['Accept' => 'application/json'])
            ->assertStatus(201);

    }

    /**
     * Update one category authenticated
     *
     * @return void
     */
    public function test_successfully_update_one_category_authenticated(): void
    {
        $category = Category::factory()->create();

        $user = User::factory()->create();

        $categoryData = [
            "name" => "Thriller"
        ];

        $this->actingAs($user)->json('PUT', 'api/categories/'. $category->id, $categoryData, ['Accept' => 'application/json'])
            ->assertStatus(200);

    }

    /**
     * Delete one category authenticated
     *
     * @return void
     */
    public function test_successfully_delete_one_category_authenticated(): void
    {
        $category = Category::factory()->create();

        $user = User::factory()->create();

        $this->actingAs($user)->json('DELETE', 'api/categories/'. $category->id, ['Accept' => 'application/json'])
            ->assertStatus(204);

    }

    /**
     * List one movie unauthenticated
     *
     * @return void
     */
    public function test_fail_list_one_movie_unauthenticated(): void
    {
        $this->json('GET', 'api/movies/1', ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    /**
     * List all movies unauthenticated
     *
     * @return void
     */
    public function test_fail_list_all_movies_unauthenticated(): void
    {
        $this->json('GET', 'api/movies/', ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

    }

    /**
     * Create one movie unauthenticated
     *
     * @return void
     */
    public function test_fail_create_one_movie_unauthenticated(): void
    {
        $this->json('POST', 'api/movies/', ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

    }

    /**
     * Update one movie unauthenticated
     *
     * @return void
     */
    public function test_fail_update_one_movie_unauthenticated(): void
    {
        $this->json('PUT', 'api/movies/1', ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

    }

    /**
     * Delete one movie unauthenticated
     *
     * @return void
     */
    public function test_fail_delete_one_movie_unauthenticated(): void
    {
        $this->json('DELETE', 'api/movies/1', ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

    }

    /**
     * List one movie authenticated
     *
     * @return void
     */
    public function test_successfully_list_one_movie_authenticated(): void
    {
        $movie = Movie::factory()->create();

        $user = User::factory()->create();

        $this->actingAs($user)->json('GET', 'api/movies/'. $movie->id, ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

    /**
     * List all movies authenticated
     *
     * @return void
     */
    public function test_successfully_list_all_movies_authenticated(): void
    {
        $movie = Movie::factory()->create();

        $user = User::factory()->create();

        $this->actingAs($user)->json('GET', 'api/movies/', ['Accept' => 'application/json'])
            ->assertStatus(200);

    }

    /**
     * Create one movie authenticated
     *
     * @return void
     */
    public function test_successfully_create_one_movie_authenticated(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $movieData = [
            "name" => "The Godfather",
            "category_id" => $category->id
        ];

        $this->actingAs($user)->json('POST', 'api/movies/', $movieData, ['Accept' => 'application/json'])
            ->assertStatus(201);

    }

    /**
     * Update one movie authenticated
     *
     * @return void
     */
    public function test_successfully_update_one_movie_authenticated(): void
    {
        $movie = Movie::factory()->create();
        $category = Category::factory()->create();
        $user = User::factory()->create();

        $movieData = [
            "name" => "The Godfather",
            "category_id" => $category->id
        ];

        $this->actingAs($user)->json('PUT', 'api/movies/'. $movie->id, $movieData, ['Accept' => 'application/json'])
            ->assertStatus(200);

    }

    /**
     * Delete one movie authenticated
     *
     * @return void
     */
    public function test_successfully_delete_one_movie_authenticated(): void
    {
        $movie = Movie::factory()->create();

        $user = User::factory()->create();

        $this->actingAs($user)->json('DELETE', 'api/movies/'. $movie->id, ['Accept' => 'application/json'])
            ->assertStatus(204);

    }
}
