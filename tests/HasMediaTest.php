<?php

namespace SertxuDeveloper\Media\Tests;

use SertxuDeveloper\Media\Tests\Models\Message;

class HasMediaTest extends TestCase {

    /**
     * Check if it can add media from content.
     *
     * @return void
     */
    public function test_can_add_media_from_content(): void {
        $message = Message::factory()->create();

        dd($message);
    }

    /**
     * Check if it can add media from a stored file.
     *
     * @return void
     */
    public function test_can_add_media_from_disk(): void {

    }

    /**
     * Check if it can add media from a URL.
     *
     * @return void
     */
    public function test_can_add_media_from_url(): void {

    }

    /**
     * Check if it can get the attached media.
     *
     * @return void
     */
    public function test_can_get_attached_media(): void {

    }
}
