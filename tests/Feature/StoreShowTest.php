<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Show;
use App\Actions\Shows\StoreShow;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StoreShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_show()
    {
        Storage::fake('public');

        $action = app(StoreShow::class);

        $data = Show::factory()->make([
            'cover_image' => null,
        ])->toArray();

        $data['cover_image'] = UploadedFile::fake()->image('cover.jpg');

        $result = $action->execute($data);

        $this->assertDatabaseHas('shows', [
            'id' => $result->id,
            'title' => $data['title'],
        ]);

        Storage::disk('public')->assertExists($result->cover_image);

        $this->assertInstanceOf(Show::class, $result);
    }
}