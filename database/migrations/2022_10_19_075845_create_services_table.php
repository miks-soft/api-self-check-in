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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('services')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('type_id')->constrained('service_types')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('airport_id')->constrained('airports')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('terminal_id')->nullable()->constrained('terminals')->cascadeOnUpdate()->nullOnDelete();
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('count')->nullable();
            $table->string('gettsleep_id')->nullable();
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
        Schema::dropIfExists('services');
    }
};
