<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MovieTest extends TestCase
{

    use RefreshDatabase;

    /**
     * List one movie
     *
     * @return void
     */
    public function test_successfully_list_one_movie(): void
    {
        $movie = Movie::factory()->create();

        $user = User::factory()->create();

        $this->actingAs($user)->json('GET', 'api/movies/'. $movie->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertSee($movie->name);
    }

    /**
     * List all movies
     *
     * @return void
     */
    public function test_successfully_list_all_movies(): void
    {
        $movie1 = Movie::factory()->create();
        $movie2 = Movie::factory()->create();

        $user = User::factory()->create();

        $this->actingAs($user)->json('GET', 'api/movies/', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertSee($movie1->name, $movie2->name);
    }

    /**
     * Create one movie successfully
     *
     * @return void
     */
    public function test_successfully_create_one_movie(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $movieData = [
            "name" => "The Godfather",
            "category_id" => $category->id
        ];

        $this->actingAs($user)->json('POST', 'api/movies/', $movieData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertSee($movieData["name"]);
    }

    /**
     * Update one movie successfully
     *
     * @return void
     */
    public function test_successfully_update_one_movie(): void
    {
        $movie = Movie::factory()->create();
        $category = Category::factory()->create();
        $user = User::factory()->create();

        $movieData = [
            "name" => "The Godfather",
            "category_id" => $category->id
        ];

        $this->actingAs($user)->json('PUT', 'api/movies/'. $movie->id, $movieData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertSee($movieData["name"]);

    }

    /**
     * Delete one movie
     *
     * @return void
     */
    public function test_successfully_delete_one_movie(): void
    {
        $movie = Movie::factory()->create();

        $user = User::factory()->create();

        $this->actingAs($user)->json('DELETE', 'api/movies/'. $movie->id, ['Accept' => 'application/json'])
            ->assertStatus(204);

    }
}
