<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('guest_id')->nullable();
            $table->bigInteger('event_id');
            $table->bigInteger('ticket_id');
            $table->bigInteger('transaction_id');
            $table->string('checkin_code')->unique()->nullable();
            $table->boolean('checked_in')->default(false);
            $table->enum('payment_channel', ['online', 'venue'])->default('online');
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
        Schema::dropIfExists('event_registrations');
    }
}
