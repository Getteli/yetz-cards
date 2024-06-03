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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->boolean('is_active');
            $table->timestamps();
            $table->softDeletes();
        });

		Schema::create('user_has_team', function (Blueprint $table) {
            $table->id();
            $table->boolean('presence')->default(0);
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('team_id');
            $table->timestamps();

			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('team_id', 'user_id')->references('id')->on('teams')->onDelete('cascade');
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_has_team');
        Schema::dropIfExists('teams');
    }
};
