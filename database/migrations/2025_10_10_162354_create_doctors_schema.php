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
        /**
         * 🩺 TABEL: doctors
         */
        Schema::create('doctors', function (Blueprint $table) {
            $table->uuid('id')->primary(); // 🔁 UUID
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('avatar')->nullable();
            $table->string('thumbnail_profile')->nullable();
            $table->string('thumbnail_alt_text')->nullable();
            $table->string('position')->nullable();
            $table->text('short_desc')->nullable();
            $table->text('desc')->nullable();
            $table->string('language')->nullable();


            // 🆕 SEO fields
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 255)->nullable();
            $table->string('meta_keywords', 255)->nullable();
            $table->timestamps();
        });

        /**
         * 🎓 TABEL: doctor_educations
         */
        Schema::create('doctor_educations', function (Blueprint $table) {
            $table->uuid('id')->primary(); // 🔁 UUID
            $table->foreignUuid('doctor_id')
                ->constrained('doctors')
                ->cascadeOnDelete(); // 🔗 Relasi ke doctors
            $table->integer('order')->nullable();
            $table->year('graduation_year')->nullable();
            $table->string('education_title');
            $table->timestamps();
        });

        /**
         * 📜 TABEL: doctor_certifications
         */
        Schema::create('doctor_certifications', function (Blueprint $table) {
            $table->uuid('id')->primary(); // 🔁 UUID
            $table->foreignUuid('doctor_id')
                ->constrained('doctors')
                ->cascadeOnDelete(); // 🔗 Relasi ke doctors
            $table->integer('order')->nullable();
            $table->year('certification_year')->nullable();
            $table->string('certification_title');
            $table->timestamps();
        });

        /**
         * 🤝 TABEL: doctor_associations
         */
        Schema::create('doctor_associations', function (Blueprint $table) {
            $table->uuid('id')->primary(); // 🔁 UUID
            $table->foreignUuid('doctor_id')
                ->constrained('doctors')
                ->cascadeOnDelete(); // 🔗 Relasi ke doctors
            $table->integer('order')->nullable();
            $table->string('association_name');
            $table->boolean('show_name')->default(true);
            $table->string('img')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // urutan kebalikan untuk hindari foreign key constraint error
        Schema::dropIfExists('doctor_associations');
        Schema::dropIfExists('doctor_certifications');
        Schema::dropIfExists('doctor_educations');
        Schema::dropIfExists('doctors');
    }
};
