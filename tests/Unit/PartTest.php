<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Part;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PartTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_part()
    {
        $part = Part::create([
            'name' => 'Test Part',
            'code' => 'TST-001',
            'description' => 'Test description',
            'price' => 100.00,
            'stock' => 10,
            'category' => 'Motor',
            'manufacturer' => 'Test Brand'
        ]);

        $this->assertInstanceOf(Part::class, $part);
        $this->assertEquals('Test Part', $part->name);
        $this->assertDatabaseHas('parts', [
            'code' => 'TST-001'
        ]);
    }

    /** @test */
    public function it_checks_if_part_is_in_stock()
    {
        $part = Part::factory()->create(['stock' => 5]);

        $this->assertTrue($part->isInStock(3));
        $this->assertTrue($part->isInStock(5));
        $this->assertFalse($part->isInStock(6));
    }

    /** @test */
    public function it_can_decrease_stock()
    {
        $part = Part::factory()->create(['stock' => 10]);

        $part->decreaseStock(3);

        $this->assertEquals(7, $part->fresh()->stock);
    }

    /** @test */
    public function it_can_increase_stock()
    {
        $part = Part::factory()->create(['stock' => 5]);

        $part->increaseStock(3);

        $this->assertEquals(8, $part->fresh()->stock);
    }

    /** @test */
    public function it_casts_price_to_decimal()
    {
        $part = Part::factory()->create(['price' => 123.456]);

        $this->assertEquals('123.46', $part->price);
    }
}
