<?php

use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RoleSeeder::class);
    $this->seed(PermissionSeeder::class);
});

it('customer cannot create product', function () {

    // 1. Vytvoríme používateľa
    $user = User::factory()->create();

    // 2. Priradíme mu rolu customer
    $user->assignRole('customer');

    // 3. Simulujeme prihlásenie a POST request
    $response = $this->actingAs($user)
        ->postJson('/api/products', [
            'name' => 'Paralen 500 mg',
            'product_type' => 'human_medicine',
        ]);

    // 4. Očakávame HTTP 403
    $response->assertStatus(403);

    // 5. Overíme, že produkt nevznikol
    $this->assertDatabaseMissing('products', [
        'name' => 'Paralen 500 mg',
    ]);
});

it('product manager can create product', function () {

    // 1. Vytvoríme používateľa
    $user = User::factory()->create();

    // 2. Priradíme rolu Product Manager
    $user->assignRole('product-manager');

    // 3. Pokúsime sa vytvoriť produkt
    $response = $this->actingAs($user)
        ->postJson('/api/products', [
            'name' => 'Paralen 500 mg',
            'product_type' => 'human_medicine',
        ]);

    // 4. Očakávame úspešné vytvorenie
    $response->assertStatus(201);

    // 5. Overíme uloženie produktu
    $this->assertDatabaseHas('products', [
        'name' => 'Paralen 500 mg',
    ]);
});

use App\Models\Product;

it('customer cannot update product', function () {

    $product = Product::factory()->create();

    $customer = User::factory()->create();
    $customer->assignRole('customer');

    $this->actingAs($customer)
        ->patchJson("/api/products/{$product->id}", [
            'name' => 'Updated Product',
        ])
        ->assertStatus(403);

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => $product->name,
    ]);
});

it('product manager can update product', function () {

    // 1. Vytvoríme produkt
    $product = Product::factory()->create();

    // 2. Vytvoríme Product Managera
    $user = User::factory()->create();
    $user->assignRole('product-manager');

    // 3. Upravíme produkt
    $response = $this->actingAs($user)
        ->patchJson("/api/products/{$product->id}", [
            'name' => 'Updated Product',
        ]);

    // 4. Očakávame úspešnú odpoveď
    $response->assertStatus(200);

    // 5. Overíme zmenu v databáze
    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => 'Updated Product',
        'slug' => 'updated-product',
    ]);
});


it('customer cannot delete product', function () {

    $product = Product::factory()->create();

    $customer = User::factory()->create();
    $customer->assignRole('customer');

    $this->actingAs($customer)
        ->deleteJson("/api/products/{$product->id}")
        ->assertStatus(403);

    // Produkt musí zostať v databáze
    $this->assertDatabaseHas('products', [
        'id' => $product->id,
    ]);
});

it('product manager can delete product', function () {

    $product = Product::factory()->create();

    $manager = User::factory()->create();
    $manager->assignRole('product-manager');

    $this->actingAs($manager)
        ->deleteJson("/api/products/{$product->id}")
        ->assertStatus(200);

    // Produkt už nesmie existovať
    $this->assertDatabaseMissing('products', [
        'id' => $product->id,
    ]);
});
