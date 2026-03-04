<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Show;
use App\Actions\Shows\DeleteShow;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class DeleteShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_deletes_show_and_cover_image()
    {
        Storage::fake('public');

        $action = app(DeleteShow::class);

        $imagePath = UploadedFile::fake()
            ->image('cover.jpg')
            ->store('covers', 'public');

        $show = Show::factory()->create([
            'cover_image' => $imagePath,
        ]);

        Storage::disk('public')->assertExists($imagePath);

        $action->execute($show);


        $this->assertDatabaseMissing('shows', [
            'id' => $show->id,
        ]);

        Storage::disk('public')->assertMissing($imagePath);
    }
}