<?php

use App\Models\User;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

beforeEach(function () {
    $this->app['router']->pushMiddlewareToGroup(
        'api',
        StartSession::class
    );
});

it('registers a new customer successfully', function () {

    $this->withMiddleware(
        \Illuminate\Session\Middleware\StartSession::class
    );

    $response = $this->postJson('/api/auth/register', ([
        'first_name' => "Test Customer First Name",
        'last_name' => "Test Customer Last Name",
        'email' => 'customer@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]));

    $response->assertStatus(201);

    $response->assertJson([
        'message' => 'User registered successfully.',
    ]);

    $this->assertDatabaseHas('users', [
        'email' => 'customer@example.com',
    ]);

    $user = User::where('email', 'customer@example.com')->firstOrFail();

    expect(Hash::check('Password123!', $user->password))
        ->toBeTrue();
});


it('logs in a customer successfully', function () {

    $user = User::factory()->create(['password' => Hash::make('Password123!')]);

    $response = $this->postJson('api/auth/login', ([
        'email' => $user->email,
        'password' => 'Password123!'
    ]));

    $response->assertStatus(200);

    $response->assertJson(['message' => 'User logged in successfully.']);

    $this->assertAuthenticatedAs($user, 'web');
});

it('blocks login after five failed attempts', function () {



    $user = User::factory()->create([
        'password' => Hash::make('Password123!'),
    ]);

    RateLimiter::clear(
        'login:' . Str::lower($user->email) . '|127.0.0.1'
    );

    // Simulate five failed login attempts
    for ($i = 0; $i < 5; $i++) {

        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'WrongPassword123!',
        ]);

        $response->assertStatus(401);
    }

    // Sixth attempt should be blocked
    $response = $this->postJson('/api/auth/login', [
        'email' => $user->email,
        'password' => 'WrongPassword123!',
    ]);

    $response->assertStatus(429)
        ->assertJsonStructure([
            'message',
            'retry_after',
        ]);
});

it('returns authenticated customer', function () {

    $user = User::factory()->create();

    $response = $this
        ->actingAs($user, 'web')
        ->getJson('/api/auth/me');

    $response->assertStatus(200)
        ->assertJsonPath('user.id', $user->id)
        ->assertJsonPath('user.email', $user->email);
});

it('rejects unauthenticated customer', function () {

    $response = $this->getJson('/api/auth/me');

    $response->assertStatus(401);
});

it('logs out authenticated customer successfully', function () {

    $user = User::factory()->create();

    $this->actingAs($user, 'web');

    // Verify customer is authenticated
    $this->assertAuthenticatedAs($user, 'web');

    // Perform logout
    $response = $this->postJson('/api/auth/logout');

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'User logged out successfully.',
        ]);

    // Verify customer is logged out
    $this->assertGuest('web');
});

it('completes the full authentication lifecycle', function () {

    // 1. Create a test customer
    $user = User::factory()->create([
        'password' => Hash::make('Password123!'),
    ]);

    // 2. Login
    $loginResponse = $this->postJson('/api/auth/login', [
        'email' => $user->email,
        'password' => 'Password123!',
    ]);

    $loginResponse->assertOk()
        ->assertJsonPath('user.id', $user->id);

    $this->assertAuthenticatedAs($user, 'web');

    // 3. Get authenticated customer
    $meResponse = $this->getJson('/api/auth/me');

    $meResponse->assertOk()
        ->assertJsonPath('user.id', $user->id)
        ->assertJsonPath('user.email', $user->email);

    // 4. Logout
    $logoutResponse = $this->postJson('/api/auth/logout');

    $logoutResponse->assertOk()
        ->assertJson([
            'message' => 'User logged out successfully.',
        ]);

    $this->assertGuest('web');
    // Reset cached authentication guards between simulated requests
    Auth::forgetGuards();

    dump([
        'web_authenticated' => Auth::guard('web')->check(),
        'sanctum_authenticated' => Auth::guard('sanctum')->check(),
    ]);

    // 5. Try accessing protected route after logout
    $afterLogoutResponse = $this->getJson('/api/auth/me');

    $afterLogoutResponse->assertUnauthorized();
});
