<?php

namespace Tests\Feature;

use App\Models\Shop;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the dashboard route requires authentication.
     */
    public function test_dashboard_route_requires_authentication(): void
    {
        $shop = Shop::create([
            'name' => 'Test Shop',
            'slug' => 'test-shop',
            'whatsapp_number' => '1234567890',
            'color_primary' => '#E60067',
            'color_secondary' => '#C6A100',
            'color_background' => '#0F172A',
        ]);

        $response = $this->get("/{$shop->slug}/admin/dashboard");

        $response->assertRedirect('/login');
    }

    /**
     * Test that the dashboard displays dynamic data from database.
     */
    public function test_dashboard_displays_real_dynamic_data(): void
    {
        $shop = Shop::create([
            'name' => 'Dynamic Shop',
            'slug' => 'dynamic-shop',
            'whatsapp_number' => '9876543210',
            'color_primary' => '#FF5733',
            'color_secondary' => '#33FF57',
            'color_background' => '#0F172A',
        ]);

        $user = User::create([
            'name' => 'Store Admin',
            'email' => 'admin@dynamicshop.com',
            'password' => bcrypt('password'),
            'shop_id' => $shop->id,
        ]);

        // Explicitly set the tenant config so dynamic relations are stored with the right tenant ID
        config(['current_shop_id' => $shop->id]);

        // Create some dynamic products and orders
        $category = \App\Models\Category::create([
            'name' => 'Burgers',
            'slug' => 'burgers',
            'status' => 1,
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Premium Burger',
            'description' => 'Delicious beef burger',
            'price' => 12.50,
            'is_available' => true,
        ]);

        Order::create([
            'customer_name' => 'John Doe',
            'customer_phone' => '1234567890',
            'total' => 25.00,
            'status' => 'completed',
            'order_number' => 'ORD-1001',
        ]);

        Order::create([
            'customer_name' => 'Jane Smith',
            'customer_phone' => '0987654321',
            'total' => 15.50,
            'status' => 'completed',
            'order_number' => 'ORD-1002',
        ]);

        // Clear active tenant config before request to let middleware handle it
        config(['current_shop_id' => null]);

        $response = $this->actingAs($user)
            ->get("/{$shop->slug}/admin/dashboard");

        $response->assertStatus(200);

        // Check if dynamic metrics are present in the response content
        $response->assertSee('Dynamic Shop');
        $response->assertSee('$40'); // total received ($25.00 + $15.50 = $40.50)
        $response->assertSee('.50');
        $response->assertSee('2'); // orders count
        $response->assertSee('Premium Burger'); // top product
        $response->assertSee('John Doe'); // top client
        $response->assertSee('Jane Smith'); // top client
    }
}
