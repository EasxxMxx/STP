<?php

namespace Tests\Feature\Auth;

use App\Http\Controllers\studentController;
use App\Models\User;
use App\Models\stp_article;
use App\Models\stp_article_category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    public function test_confirm_password_screen_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/confirm-password');

        $response->assertStatus(200);
    }

    public function test_password_can_be_confirmed(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/confirm-password', [
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    public function test_password_is_not_confirmed_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/confirm-password', [
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();
    }

    public function test_add_article_requires_slug_field(): void
    {
        $user = User::factory()->create();
        $category = stp_article_category::factory()->create();

        Storage::fake('public');
        $image = UploadedFile::fake()->image('test.jpg');

        $response = $this->actingAs($user)->post('/api/addArticle', [
            'title' => 'Test Article Title',
            'category' => $category->id,
            'author' => 'Test Author',
            'featuredImage' => $image,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['slug']);
    }

    public function test_add_article_generates_slug_from_title(): void
    {
        $user = User::factory()->create();
        $category = stp_article_category::factory()->create();

        Storage::fake('public');
        $image = UploadedFile::fake()->image('test.jpg');

        $controller = new studentController();
        $request = new \Illuminate\Http\Request(['title' => 'Test Article Title']);
        $slugResponse = $controller->generateArticleSlug($request);
        $slugData = json_decode($slugResponse->getContent(), true);
        $slug = $slugData['slug'];

        $response = $this->actingAs($user)->post('/api/addArticle', [
            'title' => 'Test Article Title',
            'slug' => $slug,
            'category' => $category->id,
            'author' => 'Test Author',
            'featuredImage' => $image,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('stp_articles', [
            'article_title' => 'Test Article Title',
            'article_slug' => 'test-article-title',
        ]);
    }

    public function test_add_article_generates_unique_slug_when_duplicate(): void
    {
        $user = User::factory()->create();
        $category = stp_article_category::factory()->create();

        stp_article::create([
            'category_id' => $category->id,
            'article_title' => 'Test Article',
            'article_slug' => 'test-article',
            'article_author' => 'Author',
            'article_date' => now()->toDateString(),
            'article_featured' => 0,
            'article_views' => 0,
            'data_status' => 1,
            'created_by' => $user->id,
        ]);

        Storage::fake('public');
        $image = UploadedFile::fake()->image('test.jpg');

        $controller = new studentController();
        $request = new \Illuminate\Http\Request(['title' => 'Test Article']);
        $slugResponse = $controller->generateArticleSlug($request);
        $slugData = json_decode($slugResponse->getContent(), true);
        $slug = $slugData['slug'];

        $response = $this->actingAs($user)->post('/api/addArticle', [
            'title' => 'Test Article',
            'slug' => $slug,
            'category' => $category->id,
            'author' => 'Test Author',
            'featuredImage' => $image,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('stp_articles', [
            'article_title' => 'Test Article',
            'article_slug' => 'test-article-2',
        ]);
    }

    public function test_edit_article_requires_slug_field(): void
    {
        $user = User::factory()->create();
        $category = stp_article_category::factory()->create();

        $article = stp_article::create([
            'category_id' => $category->id,
            'article_title' => 'Original Title',
            'article_slug' => 'original-title',
            'article_author' => 'Author',
            'article_date' => now()->toDateString(),
            'article_featured' => 0,
            'article_views' => 0,
            'data_status' => 1,
            'created_by' => $user->id,
        ]);

        Storage::fake('public');
        $image = UploadedFile::fake()->image('test.jpg');

        $response = $this->actingAs($user)->post('/api/editArticle', [
            'id' => $article->id,
            'title' => 'Updated Title',
            'category' => $category->id,
            'author' => 'Test Author',
            'featuredImage' => $image,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['slug']);
    }

    public function test_edit_article_updates_slug_from_title(): void
    {
        $user = User::factory()->create();
        $category = stp_article_category::factory()->create();

        $article = stp_article::create([
            'category_id' => $category->id,
            'article_title' => 'Original Title',
            'article_slug' => 'original-title',
            'article_author' => 'Author',
            'article_date' => now()->toDateString(),
            'article_featured' => 0,
            'article_views' => 0,
            'data_status' => 1,
            'created_by' => $user->id,
        ]);

        Storage::fake('public');
        $image = UploadedFile::fake()->image('test.jpg');

        $controller = new studentController();
        $request = new \Illuminate\Http\Request(['title' => 'Updated Title']);
        $slugResponse = $controller->generateArticleSlug($request);
        $slugData = json_decode($slugResponse->getContent(), true);
        $slug = $slugData['slug'];

        $response = $this->actingAs($user)->post('/api/editArticle', [
            'id' => $article->id,
            'title' => 'Updated Title',
            'slug' => $slug,
            'category' => $category->id,
            'author' => 'Test Author',
            'featuredImage' => $image,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('stp_articles', [
            'id' => $article->id,
            'article_title' => 'Updated Title',
            'article_slug' => 'updated-title',
        ]);
    }

    public function test_edit_article_generates_unique_slug_when_duplicate(): void
    {
        $user = User::factory()->create();
        $category = stp_article_category::factory()->create();

        $article1 = stp_article::create([
            'category_id' => $category->id,
            'article_title' => 'First Article',
            'article_slug' => 'first-article',
            'article_author' => 'Author',
            'article_date' => now()->toDateString(),
            'article_featured' => 0,
            'article_views' => 0,
            'data_status' => 1,
            'created_by' => $user->id,
        ]);

        $article2 = stp_article::create([
            'category_id' => $category->id,
            'article_title' => 'Second Article',
            'article_slug' => 'second-article',
            'article_author' => 'Author',
            'article_date' => now()->toDateString(),
            'article_featured' => 0,
            'article_views' => 0,
            'data_status' => 1,
            'created_by' => $user->id,
        ]);

        Storage::fake('public');
        $image = UploadedFile::fake()->image('test.jpg');

        $controller = new studentController();
        $request = new \Illuminate\Http\Request(['title' => 'First Article']);
        $slugResponse = $controller->generateArticleSlug($request);
        $slugData = json_decode($slugResponse->getContent(), true);
        $slug = $slugData['slug'];

        $response = $this->actingAs($user)->post('/api/editArticle', [
            'id' => $article2->id,
            'title' => 'First Article',
            'slug' => $slug,
            'category' => $category->id,
            'author' => 'Test Author',
            'featuredImage' => $image,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('stp_articles', [
            'id' => $article2->id,
            'article_title' => 'First Article',
            'article_slug' => 'first-article-2',
        ]);
    }
}
