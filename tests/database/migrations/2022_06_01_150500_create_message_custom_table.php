<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use SertxuDeveloper\Media\Tests\Models\User;

return new class extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void {
        Schema::create('message_custom', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignIdFor(User::class);
            $table->string('subject');
            $table->text('message');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void {
        Schema::dropIfExists('message_custom');
    }
};
