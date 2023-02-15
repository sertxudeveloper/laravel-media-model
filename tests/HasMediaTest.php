<?php

namespace SertxuDeveloper\Media\Tests;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;
use SertxuDeveloper\Media\Exceptions\FileDoesNotExistException;
use SertxuDeveloper\Media\Exceptions\FileTooBigException;
use SertxuDeveloper\Media\Exceptions\InvalidUrlException;
use SertxuDeveloper\Media\Tests\Models\Message;
use SertxuDeveloper\Media\Tests\Models\MessageCustom;
use SertxuDeveloper\Media\Tests\Models\User;

class HasMediaTest extends TestCase
{
    public User $user;

    /**
     * Setup the test environment.
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * Check if it can add media from content.
     */
    public function test_can_add_media_from_content(): void
    {
        $message = Message::factory()->create(['user_id' => $this->user->id]);

        $this->assertInstanceOf(MorphMany::class, $message->media());
        $this->assertCount(0, $message->media);

        Storage::fake();

        $message
            ->addMediaFromContent('<p>Hello World</p>', 'example.txt', 'content/messages', 'local')
            ->toMediaCollection();

        $message->load('media');

        $this->assertCount(1, $message->media);
        $this->assertEquals('example.txt', $message->media->first()->filename);
        $this->assertEquals('default', $message->media->first()->collection);
        $this->assertEquals('local', $message->media->first()->disk);
        $this->assertEquals('text/plain', $message->media->first()->mime_type);
        Storage::disk($message->media->first()->disk)->assertExists($message->media->first()->path);
        $this->assertEquals(strlen('<p>Hello World</p>'), $message->media->first()->size);
    }

    /**
     * Check if it can add media from a stored file.
     */
    public function test_can_add_media_from_disk(): void
    {
        $message = Message::factory()->create(['user_id' => $this->user->id]);

        $this->assertInstanceOf(MorphMany::class, $message->media());
        $this->assertCount(0, $message->media);

        Storage::fake();

        Storage::disk('local')->put('messages/example.txt', 'Hello World');

        $message
            ->addMediaFromDisk('messages/example.txt', 'local')
            ->toMediaCollection();

        $message->load('media');

        $this->assertCount(1, $message->media);
        $this->assertEquals('example.txt', $message->media->first()->filename);
        $this->assertEquals('default', $message->media->first()->collection);
        $this->assertEquals('local', $message->media->first()->disk);
        $this->assertEquals('text/plain', $message->media->first()->mime_type);
        Storage::disk($message->media->first()->disk)->assertExists($message->media->first()->path);
        $this->assertEquals(strlen('Hello World'), $message->media->first()->size);
    }

    /**
     * Check if it can add media from a URL.
     */
    public function test_can_add_media_from_url(): void
    {
        $message = Message::factory()->create(['user_id' => $this->user->id]);

        $this->assertInstanceOf(MorphMany::class, $message->media());
        $this->assertCount(0, $message->media);

        Storage::fake();

        $message
            ->addMediaFromUrl('https://www.sertxudeveloper.com/assets/logo.svg')
            ->toMediaCollection();

        $message->load('media');

        $this->assertCount(1, $message->media);
        $this->assertEquals('logo.svg', $message->media->first()->filename);
        $this->assertEquals('default', $message->media->first()->collection);
        $this->assertEquals('external', $message->media->first()->disk);
        $this->assertEquals(null, $message->media->first()->mime_type);
        $this->assertEquals(null, $message->media->first()->size);
    }

    /**
     * Check can add media to a model with a specific media table.
     */
    public function test_can_add_media_to_model_with_specific_media_table(): void
    {
        $message = MessageCustom::factory()->create(['user_id' => $this->user->id]);

        $this->assertInstanceOf(HasMany::class, $message->media());
        $this->assertCount(0, $message->media);

        Storage::fake();

        $message
            ->addMediaFromContent('<p>Hello World</p>', 'example.txt', 'custom', 'local')
            ->toMediaCollection();

        $message->load('media');

        $this->assertCount(1, $message->media);
        $this->assertEquals('example.txt', $message->media->first()->filename);
        $this->assertEquals('default', $message->media->first()->collection);
        $this->assertEquals('local', $message->media->first()->disk);
        $this->assertEquals('text/plain', $message->media->first()->mime_type);
        Storage::disk($message->media->first()->disk)->assertExists($message->media->first()->path);
        $this->assertEquals(strlen('<p>Hello World</p>'), $message->media->first()->size);
    }

    /**
     * Check can delay media attachment until the model has been created.
     */
    public function test_can_delay_media_attachment_until_model_has_been_created(): void
    {
        $message = Message::factory()->make(['user_id' => $this->user->id]);

        $this->assertInstanceOf(MorphMany::class, $message->media());
        $this->assertCount(0, $message->media);

        Storage::fake();

        Storage::disk('local')->put('messages/example.txt', 'Hello World');

        $message
            ->addMediaFromDisk('messages/example.txt', 'local')
            ->toMediaCollection();

        $this->assertFalse($message->exists, 'Model should not be saved yet');

        $message->load('media');

        $this->assertCount(0, $message->media);

        $message->save();
        $message->load('media');

        $this->assertCount(1, $message->media);
        $this->assertEquals('example.txt', $message->media->first()->filename);
        $this->assertEquals('default', $message->media->first()->collection);
        $this->assertEquals('local', $message->media->first()->disk);
        $this->assertEquals('text/plain', $message->media->first()->mime_type);
        Storage::disk($message->media->first()->disk)->assertExists($message->media->first()->path);
        $this->assertEquals(strlen('Hello World'), $message->media->first()->size);
    }

    /**
     * Check cannot add media from a URL with invalid URL.
     */
    public function test_cannot_add_media_from_invalid_url(): void
    {
        $message = Message::factory()->create(['user_id' => $this->user->id]);

        $this->assertInstanceOf(MorphMany::class, $message->media());
        $this->assertCount(0, $message->media);

        Storage::fake();

        $this->expectException(InvalidUrlException::class);

        $message
            ->addMediaFromUrl('file://www.sertxudeveloper.com/assets/logo.svg')
            ->toMediaCollection();

        $message->load('media');

        $this->assertCount(0, $message->media);
    }

    /**
     * Check cannot attach local file if it does not exist.
     */
    public function test_cannot_attach_local_file_if_it_does_not_exist(): void
    {
        $message = Message::factory()->create(['user_id' => $this->user->id]);

        $this->assertInstanceOf(MorphMany::class, $message->media());
        $this->assertCount(0, $message->media);

        Storage::fake();

        $this->expectException(FileDoesNotExistException::class);

        $message
            ->addMediaFromDisk('messages/example.txt', 'local')
            ->toMediaCollection();

        $message->load('media');

        $this->assertCount(0, $message->media);
    }

    /**
     * Check cannot attach local file larger than the max allowed size.
     */
    public function test_cannot_attach_local_file_larger_than_max_allowed_size(): void
    {
        $message = Message::factory()->create(['user_id' => $this->user->id]);

        $this->assertInstanceOf(MorphMany::class, $message->media());
        $this->assertCount(0, $message->media);

        Storage::fake();

        $this->expectException(FileTooBigException::class);

        $content = str_repeat('a', config('media.max_file_size') + 1);
        Storage::disk('local')->put('messages/example.txt', $content);

        $message
            ->addMediaFromDisk('messages/example.txt', 'local')
            ->toMediaCollection();

        $message->load('media');

        $this->assertCount(0, $message->media);
    }

    /**
     * Check cannot upload content larger than the max allowed size.
     */
    public function test_cannot_upload_content_larger_than_max_allowed_size(): void
    {
        $message = Message::factory()->create(['user_id' => $this->user->id]);

        $this->assertInstanceOf(MorphMany::class, $message->media());
        $this->assertCount(0, $message->media);

        Storage::fake();

        $this->expectException(FileTooBigException::class);

        $content = str_repeat('a', config('media.max_file_size') + 1);

        $message
            ->addMediaFromContent($content, 'example.txt', 'messages', 'local')
            ->toMediaCollection();

        $message->load('media');

        $this->assertCount(0, $message->media);
    }

    /**
     * Check TemporaryFile keeps the original name.
     */
    public function test_it_keeps_the_original_name(): void
    {
        $message = Message::factory()->create(['user_id' => $this->user->id]);

        $this->assertInstanceOf(MorphMany::class, $message->media());
        $this->assertCount(0, $message->media);

        Storage::fake();

        $message
            ->addMediaFromContent('<p>Hello World</p>', 'example.txt', 'messages', 'local', true)
            ->toMediaCollection();

        $message->load('media');

        $this->assertCount(1, $message->media);
        $this->assertEquals('example.txt', $message->media->first()->filename);
        Storage::disk('local')->assertExists('messages/example.txt');
    }
}
