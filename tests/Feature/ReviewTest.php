<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    protected $category;
    protected $product;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a Category first as Product might require it
        $this->category = Category::create([
            'name' => 'Momo',
            'slug' => 'momo',
            'is_active' => true,
        ]);

        // Create a Product
        $this->product = Product::create([
            'category_id' => $this->category->id,
            'name' => 'Steamed Veg Momos',
            'slug' => 'steamed-veg-momos',
            'description' => 'Delicious veg momos steamed to perfection',
            'base_price' => 120.00,
            'is_veg' => true,
            'is_available' => true,
        ]);

        // Create a User
        $this->user = User::factory()->create();
    }

    public function test_guest_cannot_submit_review()
    {
        $response = $this->post(route('product.review.store', $this->product->id), [
            'rating' => 5,
            'comment' => 'This is an amazing dish!',
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseEmpty('reviews');
    }

    public function test_authenticated_user_can_submit_review_without_image()
    {
        $response = $this->actingAs($this->user)->post(route('product.review.store', $this->product->id), [
            'rating' => 4,
            'comment' => 'Very good momos!',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('reviews', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'rating' => 4,
            'comment' => 'Very good momos!',
            'image' => null,
        ]);
    }

    public function test_authenticated_user_can_submit_review_with_image()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('my_momo_review.jpg');

        $response = $this->actingAs($this->user)->post(route('product.review.store', $this->product->id), [
            'rating' => 5,
            'comment' => 'Incredible food and presentation!',
            'image' => $file,
        ]);

        $response->assertRedirect();

        $review = Review::first();
        $this->assertNotNull($review->image);
        $this->assertDatabaseHas('reviews', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'rating' => 5,
            'comment' => 'Incredible food and presentation!',
            'image' => $review->image,
        ]);

        Storage::disk('public')->assertExists($review->image);
    }

    public function test_review_validation_rating_required_and_within_range()
    {
        // Test invalid low rating
        $response = $this->actingAs($this->user)->post(route('product.review.store', $this->product->id), [
            'rating' => 0,
            'comment' => 'Bad rating',
        ]);
        $response->assertSessionHasErrors('rating');

        // Test invalid high rating
        $response = $this->actingAs($this->user)->post(route('product.review.store', $this->product->id), [
            'rating' => 6,
            'comment' => 'Too high rating',
        ]);
        $response->assertSessionHasErrors('rating');

        // Test missing rating
        $response = $this->actingAs($this->user)->post(route('product.review.store', $this->product->id), [
            'comment' => 'No rating',
        ]);
        $response->assertSessionHasErrors('rating');
    }

    public function test_home_page_shows_reviews()
    {
        // Create an approved review
        $review = Review::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'rating' => 5,
            'comment' => 'This is showcased dynamically on the homepage!',
            'is_approved' => true,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee($this->user->name);
        $response->assertSee('This is showcased dynamically on the homepage!');
        $response->assertSee($this->product->name);
    }
}
