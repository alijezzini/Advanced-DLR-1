<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('messages');
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('message_id')->nullable();
            $table->string('sender_id')->nullable();
            $table->string('message_text')->nullable();
            $table->string('destination')->nullable();
            $table->string('delivery_status')->nullable();
            $table->string('status')->nullable();
            $table->string('terminator_message_id')->nullable();
            $table->dateTime('date_received')->nullable();
            $table->string('date_sent')->nullable();
            $table->string('date_dlr')->nullable();
            $table->boolean('fake')->default(0);
            $table->unsignedBigInteger('connection_id');
            $table->foreign('connection_id')->references('id')->on('gateway_connections');
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
        Schema::dropIfExists('messages');
    }
};
