<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Part;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_order()
    {

        $user = User::factory()->create();
        $part = Part::factory()->create(['price' => 100.00]);

        $order = Order::create([
            'user_id' => $user->id,
            'part_id' => $part->id,
            'quantity' => 2,
            'total_price' => 200.00,
            'status' => 'pending'
        ]);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals($user->id, $order->user_id);
        $this->assertEquals(200.00, $order->total_price);
    }

    /** @test */

    public function it_calculates_total_correctly()
    {
        $part = Part::factory()->create(['price' => 50.00]);
        $user = User::factory()->create();

        $order = Order::create([
            'user_id' => $user->id,
            'part_id' => $part->id,
            'quantity' => 3,
            'total_price' => 150.00,
            'status' => 'pending'
        ]);

        $this->assertEquals(150.00, $order->calculateTotal());
    }

    /** @test */

    public function it_can_be_cancelled_when_pending()
    {
        $order = Order::factory()->create(['status' => 'pending']);

        $this->assertTrue($order->canBeCancelled());
    }

    /** @test */

    public function it_cannot_be_cancelled_when_completed()
    {
        $order = Order::factory()->create(['status' => 'completed']);

        $this->assertFalse($order->canBeCancelled());
    }

    /** @test */

    public function it_marks_order_as_completed()
    {
        $order = Order::factory()->create(['status' => 'pending']);

        $order->markAsCompleted();

        $this->assertEquals('completed', $order->fresh()->status);
    }

    /** @test */

    public function it_restores_stock_when_cancelled()
    {
        $part = Part::factory()->create(['stock' => 10]);
        $order = Order::factory()->create([
            'part_id' => $part->id,
            'quantity' => 3,
            'status' => 'pending'
        ]);

        $part->decreaseStock(3);
        $order->markAsCancelled();

        $this->assertEquals(10, $part->fresh()->stock);
        $this->assertEquals('cancelled', $order->fresh()->status);
    }
}
