<?php

namespace SertxuDeveloper\Media\Tests;

use Illuminate\Support\Carbon;
use SertxuDeveloper\Media\Tests\Models\MessageCustom;

class MediaManagerTest extends TestCase
{
    /**
     * Check if it can create a media table using a model via the command.
     *
     * @return void
     */
    public function test_it_can_create_a_custom_media_table_using_model(): void {
        $this->freezeTime(function (Carbon $date) {
            $this->artisan('media:create-table', [
                'name' => MessageCustom::class,
            ])->assertExitCode(0);

            $time = $date->format('Y_m_d_His');

            $path = database_path("migrations/{$time}_create_message_custom_media_table.php");
            $this->assertFileExists($path);

            $contents = file_get_contents($path);
            $this->assertStringContainsString("Schema::create('message_custom_media', function (Blueprint \$table)",
                $contents);
        });
    }

    /**
     * Check if it can create a media table using a name via the command.
     *
     * @return void
     */
    public function test_it_can_create_a_custom_media_table_using_name(): void {
        $this->freezeTime(function (Carbon $date) {
            $this->artisan('media:create-table', [
                'name' => 'message_custom',
            ])->assertExitCode(0);

            $time = $date->format('Y_m_d_His');

            $path = database_path("migrations/{$time}_create_message_custom_media_table.php");
            $this->assertFileExists($path);

            $contents = file_get_contents($path);
            $this->assertStringContainsString("Schema::create('message_custom_media', function (Blueprint \$table)",
                $contents);
        });
    }

    /**
     * Check if it can create a media table using a table name via the command.
     *
     * @return void
     */
    public function test_it_can_create_a_custom_media_table_using_table_name(): void {
        $this->freezeTime(function (Carbon $date) {
            $this->artisan('media:create-table', [
                'name' => 'message_custom_media',
            ])->assertExitCode(0);

            $time = $date->format('Y_m_d_His');

            $path = database_path("migrations/{$time}_create_message_custom_media_table.php");
            $this->assertFileExists($path);

            $contents = file_get_contents($path);
            $this->assertStringContainsString("Schema::create('message_custom_media', function (Blueprint \$table)",
                $contents);
        });
    }
}
