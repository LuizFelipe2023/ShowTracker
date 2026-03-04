<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Show;
use App\Actions\Shows\GetShows;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetShowsTest extends TestCase
{
    use RefreshDatabase;

    public function test_filters_shows_by_status()
    {
        Show::factory()->create(['status' => 'ongoing']);
        Show::factory()->create(['status' => 'finished']);

        $action = app(GetShows::class);

        $shows = $action->execute([
            'status' => 'ongoing',
        ]);

        $this->assertCount(1, $shows);
        $this->assertEquals('ongoing', $shows->first()->status);
    }

    public function test_orders_shows_by_title()
    {
        Show::factory()->create(['title' => 'B Show']);
        Show::factory()->create(['title' => 'A Show']);

        $action = app(GetShows::class);

        $shows = $action->execute([
            'sort' => 'title',
        ]);

        $this->assertEquals('A Show', $shows->first()->title);
    }

    public function test_filters_and_orders()
    {
        Show::factory()->create([
            'title' => 'Z Show',
            'status' => 'watching',
        ]);

        Show::factory()->create([
            'title' => 'A Show',
            'status' => 'watching',
        ]);

        Show::factory()->create([
            'title' => 'Other Show',
            'status' => 'finished',
        ]);

        $action = app(GetShows::class);

        $shows = $action->execute([
            'status' => 'watching',
            'sort' => 'title',
        ]);

        $this->assertCount(2, $shows);
        $this->assertEquals('A Show', $shows->first()->title);
    }
}