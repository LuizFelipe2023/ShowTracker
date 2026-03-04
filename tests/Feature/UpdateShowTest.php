<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Show;
use App\Actions\Shows\UpdateShow;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UpdateShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_updates_show_and_replaces_cover_image()
    {
        Storage::fake('public');

        $action = app(UpdateShow::class);

        $oldImage = UploadedFile::fake()->image('old.jpg')
            ->store('covers', 'public');

        $show = Show::factory()->create([
            'cover_image' => $oldImage,
        ]);

        $data = [
            'title' => 'Updated Title',
            'cover_image' => UploadedFile::fake()->image('new.jpg'),
        ];

        $updatedShow = $action->execute($show, $data);

        $this->assertDatabaseHas('shows', [
            'id' => $show->id,
            'title' => 'Updated Title',
        ]);

        Storage::disk('public')->assertExists(
            $updatedShow->cover_image
        );

        Storage::disk('public')->assertMissing($oldImage);
    }
}