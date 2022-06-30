<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /**
    # Create a migration that creates all tables for the following user stories

    For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
    To not introduce additional complexity, please consider only one cinema.

    Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.

    ## User Stories

     **Movie exploration**
     * As a user I want to see which films can be watched and at what times
     * As a user I want to only see the shows which are not booked out

     **Show administration**
     * As a cinema owner I want to run different films at different times
     * As a cinema owner I want to run multiple films at the same time in different locations

     **Pricing**
     * As a cinema owner I want to get paid differently per show
     * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat

     **Seating**
     * As a user I want to book a seat
     * As a user I want to book a vip seat/couple seat/super vip/whatever
     * As a user I want to see which seats are still available
     * As a user I want to know where I'm sitting on my ticket
     * As a cinema owner I dont want to configure the seating for every show
     */
    public function up()
    {
        // create cinemas table...
        Schema::create('cinemas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // create shows table for store all the shows location wise for each cinema...
        Schema::create('shows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cinema_id');
            $table->string('name');
            $table->string('location');
            $table->integer('total_tickets');
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
            $table->foreign('cinema_id')->references('id')->on('cinemas')->onDelete('cascade');
        });

        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('show_id');
            $table->decimal('price', 10, 2);
            $table->string('ticket_name');
            $table->integer('how_many_percent');
            $table->timestamps();
            $table->foreign('show_id')->references('id')->on('shows')->onDelete('cascade');
        });

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('show_id');
            $table->foreignId('user_id');
            $table->foreignId('ticket_id');
            $table->integer('no_of_tickets');
            $table->timestamps();
            $table->foreign('show_id')->references('id')->on('shows')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('shows');
        Schema::dropIfExists('cinemas');
    }
}
