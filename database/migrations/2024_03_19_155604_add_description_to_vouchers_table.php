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
        Schema::table('vouchers', function (Blueprint $table) {
            $table->string('code')->unique();
            $table->decimal('value', 10, 2); // Mệnh giá voucher
            $table->date('expiry_date'); // Ngày hết hạn
            $table->integer('user_role');// đối tượng sử dụng
            $table->text('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            //
        });
    }
};
