<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('franchise_leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('city');
            $table->string('state');
            $table->string('investment_budget'); // budget range e.g. "5-10 Lakhs", "10-20 Lakhs", etc.
            $table->string('franchise_type')->default('cart'); // cart, kiosk, outlet
            $table->text('experience')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('new'); // new, contacted, site_visit, approved, rejected, signed
            $table->text('admin_notes')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->timestamps();
        });

        Schema::create('franchise_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('franchise_lead_id')->constrained()->onDelete('cascade');
            $table->string('document_type'); // ID Proof, Address Proof, Financial Statement, Site Photo
            $table->string('file_path');
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('franchise_documents');
        Schema::dropIfExists('franchise_leads');
    }
};
