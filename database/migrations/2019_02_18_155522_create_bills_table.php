<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->integer('amount')->default(0);
            $table->date('due');
            $table->boolean('paid')->default(0);
            $table->boolean('recurring')->default(0);
            $table->enum('recurring_period', ['weekly', 'bi-weekly', 'monthly', 'bi-monthly'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
