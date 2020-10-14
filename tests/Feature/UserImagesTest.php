<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    Storage::fake('public');
});

test('images_can_be_uploaded', function () {
    /* @var \Tests\TestCase $this */

    $this->withoutExceptionHandling();

    $this->actingAs($user = factory(User::class)->create(), 'api');
    $file = UploadedFile::fake()->image('user-image.jpg');
    $response = $this->post('/api/user-images', [
        'image' => $file,
        'width' => 850,
        'height' => 300,
        'location'=> 'cover',
    ]);

    $response->assertStatus(201);
    Storage::disk('public')->assertExists('user-images/' . $file->hashName());
    $userImage = UserImage::first();
    $this->assertEquals('user-images/' . $file->hashName(), $userImage->path);
    $this->assertEquals('850', $userImage->width);
    $this->assertEquals('300', $userImage->height);
    $this->assertEquals('cover', $userImage->location);
});
