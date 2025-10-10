<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1️⃣ Category Treatments
        Schema::create('category_treatments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('slug')->unique(); // 🆕 slug
            $table->string('thumbnail')->nullable();
            $table->text('desc')->nullable();
            $table->timestamps();
        });

        // 2️⃣ Treatments
        Schema::create('treatments', function (Blueprint $table) {
            $table->uuid('id')->primary(); // 🔁 UUID
            $table->foreignUuid('category_treatment_id')
                ->constrained('category_treatments')
                ->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique(); // 🆕 slug
            $table->string('thumbnail')->nullable();
            $table->string('thumbnail_alt_text')->nullable();
            $table->longText('desc')->nullable();
            $table->string('contact')->nullable();
            $table->longText('maintenance')->nullable();

            // 🆕 SEO fields
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 255)->nullable();
            $table->string('meta_keywords', 255)->nullable();

            $table->timestamps();
        });

        // 3️⃣ Treatments Who Need
        Schema::create('treatment_who_needs', function (Blueprint $table) {
            $table->uuid('id')->primary(); // 🔁 UUID
            $table->foreignUuid('treatment_id')
                ->constrained('treatments')
                ->cascadeOnDelete();
            $table->integer('order')->nullable();
            $table->string('thumbnail')->nullable();
            $table->text('desc')->nullable();
            $table->timestamps();
        });

        // 4️⃣ Treatment Time Frames
        Schema::create('treatment_time_frames', function (Blueprint $table) {
            $table->uuid('id')->primary(); // ✅ UUID
            $table->foreignUuid('treatment_id')
                ->constrained('treatments')
                ->cascadeOnDelete();

            $table->text('stage')->nullable(); // contoh: "Stage 1"
            $table->boolean('show_stage')->default(true);
            $table->enum('frame', ['line', 'arrow'])->default('line');
            $table->integer('order')->nullable();
            $table->timestamps();
        });

        // 5️⃣ Treatment Treatment Stage Items
        Schema::create('treatment_stage_items', function (Blueprint $table) {
            $table->uuid('id')->primary(); // ✅ UUID
            $table->foreignUuid('treatment_time_frame_id')
                ->constrained('treatment_time_frames')
                ->cascadeOnDelete();

            $table->integer('order')->default(1);
            $table->string('thumbnail')->nullable();
            $table->string('title')->nullable();
            $table->text('desc')->nullable();
            $table->timestamps();
        });

        // 6️⃣ Treatment Additionals
        Schema::create('treatment_additionals', function (Blueprint $table) {
            $table->uuid('id')->primary(); // 🔁 UUID
            $table->foreignUuid('treatment_id')
                ->constrained('treatments')
                ->cascadeOnDelete();
            $table->integer('order')->nullable();
            $table->text('desc')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // 🔄 Hapus dulu tabel anak (punya foreign key ke treatments)
        Schema::dropIfExists('treatment_additionals');
        Schema::dropIfExists('treatment_stage_items');
        Schema::dropIfExists('treatment_time_frames');
        Schema::dropIfExists('treatment_who_needs'); // ✅ sudah diperbaiki

        // 🔄 Baru hapus tabel induk
        Schema::dropIfExists('treatments');
        Schema::dropIfExists('category_treatments');
    }
};
