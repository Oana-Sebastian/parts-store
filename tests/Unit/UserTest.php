<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Part;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_user()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com'
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com'
        ]);
    }

    /** @test */
    public function it_identifies_admin_users()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($user->isAdmin());
    }

    /** @test */
    public function it_checks_if_user_can_manage_parts()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);

        $this->assertTrue($admin->canManageParts());
        $this->assertFalse($user->canManageParts());
    }

    /** @test */
    public function it_has_orders_relationship()
    {
        $user = User::factory()->create();
        $part = Part::factory()->create();
        
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'part_id' => $part->id
        ]);

        $this->assertCount(1, $user->orders);
        $this->assertEquals($order->id, $user->orders->first()->id);
    }
}