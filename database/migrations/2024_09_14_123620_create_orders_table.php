<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('email');
            $table->string('address');
            $table->string('phone');
            $table->text('bill')->nullable();
            $table->text('shipping_address')->nullable();
            $table->decimal('total', 8, 2);
            $table->decimal('shipping_cost', 15, 2);
            $table->text('card_details')->nullable(); // لبيانات البطاقة (يمكنك تقسيمها بشكل أفضل حسب الحاجة)
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
