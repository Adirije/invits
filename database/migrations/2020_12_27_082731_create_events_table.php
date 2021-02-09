<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('client_id')->nullable();
            $table->string('tagline')->nullable();
            $table->decimal('budget', 9)->default(0);
            $table->enum('type', ['open', 'invite']);
            $table->string('feature_img')->nullable();
            $table->longText('desc')->nullable();
            $table->bigInteger('location_id')->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('published')->default(false);
            $table->boolean('enabled')->default(false);
            $table->boolean('major')->default(false);
            $table->timestamp('starts')->nullable();
            $table->timestamp('ends')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
