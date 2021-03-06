<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrowthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('growths', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();
            $table->foreignUuid('plant_id')->constrained();

            $table->float('plant_height', 4, 2)->nullable();
            $table->float('leaf_width', 4, 2)->nullable();
            $table->float('temperature', 4, 2)->nullable();
            $table->float('acidity', 4, 2)->nullable();

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
        Schema::dropIfExists('growths');
    }
}
