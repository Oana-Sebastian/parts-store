<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Part;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PartControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_all_parts()
    {
        Part::factory()->count(3)->create();

        $response = $this->get(route('parts.index'));

        $response->assertStatus(200);
        $response->assertViewHas('parts');
    }

    /** @test */
    public function it_displays_single_part()
    {
        $part = Part::factory()->create();

        $response = $this->get(route('parts.show', $part->id));

        $response->assertStatus(200);
        $response->assertSee($part->name);
    }

    /** @test */
    public function admin_can_create_part()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('parts.store'), [
            'name' => 'New Part',
            'code' => 'NEW-001',
            'description' => 'Test description',
            'price' => 100.00,
            'stock' => 10,
            'category' => 'Motor',
            'manufacturer' => 'Test Brand'
        ]);

        $response->assertRedirect(route('parts.index'));
        $this->assertDatabaseHas('parts', ['code' => 'NEW-001']);
    }

    /** @test */
    public function regular_user_cannot_create_part()
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get(route('parts.create'));

        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_delete_part()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $part = Part::factory()->create();

        $response = $this->actingAs($admin)
            ->delete(route('parts.destroy', $part->id));

        $response->assertRedirect(route('parts.index'));
        $this->assertDatabaseMissing('parts', ['id' => $part->id]);
    }
}
