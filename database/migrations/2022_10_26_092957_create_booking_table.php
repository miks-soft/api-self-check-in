<?php

use App\Enums\AgeEnum;
use App\Enums\PaymentEnum;
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
        Schema::create('booking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services')->cascadeOnUpdate()->cascadeOnDelete();
            $table->dateTime('date_from');
            $table->dateTime('date_to');
            $table->unsignedInteger('duration');
            $table->string('name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('email');
            $table->enum('age', AgeEnum::values());
            $table->string('flight');
            $table->dateTime('departure');
            $table->enum('payment', PaymentEnum::values());
            $table->unsignedInteger('count');
            $table->decimal('price', 10, 2);
            $table->decimal('total', 10, 2);
            $table->string('currency')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->string('gettsleep_id')->nullable();
            $table->string('gettsleep_status')->nullable();
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
        Schema::dropIfExists('booking');
    }
};
