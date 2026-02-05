<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('about_us_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul section
            $table->string('subtitle')->nullable(); // Subtitle
            $table->text('content')->nullable(); // Konten utama
            $table->string('section_type'); // hero, story, mission, values, team, stats, etc
            $table->string('position')->default('main'); // main, sidebar, footer
            $table->integer('order')->default(0); // Urutan tampilan
            $table->boolean('is_active')->default(true);
            $table->json('data')->nullable(); // Data tambahan (JSON)
            $table->string('background_color')->nullable();
            $table->string('text_color')->nullable();
            $table->string('icon')->nullable(); // Icon FontAwesome
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('section_type');
            $table->index('is_active');
            $table->index('order');
        });

        // Buat tabel untuk team members
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position');
            $table->text('bio')->nullable();
            $table->string('image')->nullable();
            $table->string('initial')->nullable(); // Untuk avatar jika tidak ada gambar
            $table->string('color_scheme')->default('#193497,#1e40af'); // Gradient colors
            $table->json('social_links')->nullable(); // JSON: {linkedin: '', instagram: ''}
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Buat tabel untuk achievements/stats
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('icon')->nullable();
            $table->string('value'); // Bisa angka atau teks
            $table->string('suffix')->nullable(); // +, %, etc
            $table->string('description')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Buat tabel untuk core values
        Schema::create('core_values', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('icon');
            $table->string('color_scheme')->default('#193497,#1e40af'); // Gradient colors
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('core_values');
        Schema::dropIfExists('achievements');
        Schema::dropIfExists('team_members');
        Schema::dropIfExists('about_us_sections');
    }
};