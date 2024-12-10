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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('work_date'); // Thêm trường ngày làm việc
            $table->time('total_hours')->nullable(); // Thêm trường tổng số giờ làm
            $table->text('status')->default('Chưa xác nhận'); // Thêm trường trạng thái với giá trị mặc định là 'pending'
            $table->dateTime('check_in_time');
            $table->dateTime('check_out_time')->nullable();
            $table->timestamps();
        
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
