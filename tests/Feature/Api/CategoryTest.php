<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{

    use RefreshDatabase;

    /**
     * List one category
     *
     * @return void
     */
    public function test_successfully_list_one_category(): void
    {
        $category = Category::factory()->create();

        $user = User::factory()->create();

        $this->actingAs($user)->json('GET', 'api/categories/'. $category->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertSee($category->name);
    }

    /**
     * List all categories
     *
     * @return void
     */
    public function test_successfully_list_all_categories(): void
    {
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();

        $user = User::factory()->create();

        $this->actingAs($user)->json('GET', 'api/categories/', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertSee($category1->name, $category2->name);
    }

    /**
     * Create one category successfully
     *
     * @return void
     */
    public function test_successfully_create_one_category(): void
    {
        $user = User::factory()->create();

        $categoryData = [
            "name" => "Comedy"
        ];

        $this->actingAs($user)->json('POST', 'api/categories/', $categoryData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertSee($categoryData["name"]);
    }

    /**
     * Update one category successfully
     *
     * @return void
     */
    public function test_successfully_update_one_category(): void
    {
        $category = Category::factory()->create();
        $user = User::factory()->create();

        $categoryData = [
            "name" => "Comedy"
        ];

        $this->actingAs($user)->json('PUT', 'api/categories/'. $category->id, $categoryData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertSee($categoryData["name"]);

    }

    /**
     * Delete one category
     *
     * @return void
     */
    public function test_successfully_delete_one_category(): void
    {
        $category = Category::factory()->create();

        $user = User::factory()->create();

        $this->actingAs($user)->json('DELETE', 'api/categories/'. $category->id, ['Accept' => 'application/json'])
            ->assertStatus(204);

    }

}
