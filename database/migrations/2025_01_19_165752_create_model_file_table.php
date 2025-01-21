<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('model_file', function (Blueprint $table) {
            $table->unsignedBigInteger('model_id');
            $table->string('model_type');
            $table->unsignedBigInteger('file_id');
            $table->string('file_role')->nullable();

            $table->unique([
                'model_id',
                'model_type',
                'file_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_file');
    }
};
