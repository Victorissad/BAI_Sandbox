<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Table pour stocker les consentements aux cookies (RGPD/CNIL compliance)
     */
    public function up(): void
    {
        Schema::create('cookie_consents', function (Blueprint $table) {
            $table->id();

            // Utilisateur (nullable pour les visiteurs non authentifiés)
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Type de consentement
            $table->enum('consent_type', ['accepted', 'refused'])
                ->comment('Type de consentement donné par l\'utilisateur');

            // Informations de traçabilité (RGPD)
            $table->string('ip_address', 45)->nullable()
                ->comment('Adresse IP de l\'utilisateur (IPv4 ou IPv6)');

            $table->text('user_agent')->nullable()
                ->comment('User-Agent du navigateur');

            // Identifiant de session pour les visiteurs non authentifiés
            $table->string('session_id', 255)->nullable()
                ->comment('ID de session Laravel pour tracer les visiteurs anonymes');

            // Version des conditions (pour tracer les évolutions)
            $table->string('consent_version', 50)->default('1.0')
                ->comment('Version des CGU/politique cookies au moment du consentement');

            // Timestamp de création et mise à jour
            $table->timestamps();

            // Index pour les recherches fréquentes
            $table->index('user_id');
            $table->index('session_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cookie_consents');
    }
};
