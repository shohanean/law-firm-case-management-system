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
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->boolean('open_project')->default(false);
            $table->foreignId('project_type_id')->constrained('project_types');
            $table->longText('description');
            $table->foreignId('status_id')->constrained('statuses');
            $table->foreignId('assigned_to')->constrained('users');
            $table->integer('added_by');
            $table->boolean('urgency')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};
