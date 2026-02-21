<?php

namespace Tests\Feature\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_can_create_order(): void
    {
        $product1 = Product::factory()->create(['status' => 'active', 'price' => 50.00]);
        $product2 = Product::factory()->create(['status' => 'active', 'price' => 25.00]);

        $orderData = [
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'items' => [
                ['product_id' => $product1->id, 'qty' => 2],
                ['product_id' => $product2->id, 'qty' => 1],
            ],
        ];

        $response = $this->postJson('/api/orders', $orderData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'customer_name',
                    'customer_email',
                    'status',
                    'total_price',
                    'order_items' => [
                        '*' => [
                            'id',
                            'product_id',
                            'qty',
                            'price',
                            'subtotal',
                            'product',
                        ],
                    ],
                    'created_at',
                    'updated_at',
                ],
            ]);

        $this->assertDatabaseHas('orders', [
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'status' => 'pending',
            'total_price' => 125.00,
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_id' => $product1->id,
            'qty' => 2,
            'price' => 50.00,
            'subtotal' => 100.00,
        ]);
    }

    public function test_order_fails_with_inactive_product(): void
    {
        $inactiveProduct = Product::factory()->create(['status' => 'inactive']);

        $orderData = [
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'items' => [
                ['product_id' => $inactiveProduct->id, 'qty' => 1],
            ],
        ];

        $response = $this->postJson('/api/orders', $orderData);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'Product with ID ' . $inactiveProduct->id . ' is not available',
            ]);
    }

    public function test_admin_can_get_all_orders(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $token = $admin->createToken('admin-token')->plainTextToken;
        
        Order::factory()->count(3)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/orders');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'customer_name',
                        'customer_email',
                        'status',
                        'total_price',
                        'order_items',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);
    }

    public function test_user_cannot_get_all_orders(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $token = $user->createToken('user-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/orders');

        $response->assertStatus(403)
            ->assertJson([
                'message' => 'Unauthorized. Admin access required.',
            ]);
    }

    public function test_admin_can_get_single_order(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $token = $admin->createToken('admin-token')->plainTextToken;
        $order = Order::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson("/api/orders/{$order->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'customer_name',
                    'customer_email',
                    'status',
                    'total_price',
                    'order_items',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    public function test_order_validation_fails_with_missing_data(): void
    {
        $response = $this->postJson('/api/orders', []);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'customer_name',
                    'customer_email',
                    'items',
                ],
            ]);
    }

    public function test_order_validation_fails_with_invalid_items(): void
    {
        $response = $this->postJson('/api/orders', [
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'items' => [
                ['product_id' => 999, 'qty' => 0],
            ],
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'items.0.product_id',
                    'items.0.qty',
                ],
            ]);
    }
}
