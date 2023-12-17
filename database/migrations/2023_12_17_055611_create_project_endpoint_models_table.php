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
        Schema::create('project_endpoint_models', function (Blueprint $table) {
            $table->id();
            $table->integer("project_id");
            $table->string("name_url")->nullable();
            $table->string("method");
            $table->string("url");
            $table->string("post_data")->nullable();
            $table->string("headers")->nullable();
            $table->string("taskID");
            $table->boolean("is_active")->default(true);
            $table->timestamps();   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_endpoint_models');
    }
};
