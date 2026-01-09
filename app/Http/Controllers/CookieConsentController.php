<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cookie;
use App\Models\CookieConsent;

class CookieConsentController extends Controller
{
    /**
     * Enregistre le consentement de l'utilisateur concernant les cookies
     * Conforme aux recommandations CNIL
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Validation de la requête
        $validated = $request->validate([
            'consent' => 'required|in:accepted,refused'
        ]);

        $consent = $validated['consent'];

        // ========================================
        // 1. ENREGISTREMENT EN BASE DE DONNÉES (RGPD compliance)
        // ========================================
        $cookieConsent = CookieConsent::create([
            'user_id' => auth()->check() ? auth()->id() : null,
            'consent_type' => $consent,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'session_id' => session()->getId(),
            'consent_version' => '1.0', // Mettre à jour si politique cookies change
        ]);

        // ========================================
        // 2. CRÉATION DU COOKIE (stockage client) - SANS ENCRYPTION
        // ========================================
        // Pas de Cookie::make car Laravel crypte les cookies
        // On définit directement le cookie en JavaScript après la réponse

        // ========================================
        // 3. LOG DE L'ACTION (conformité ANSSI) - Désactivé temporairement
        // ========================================
        // Le logging est déjà fait via la table cookie_consents

        // ========================================
        // 4. RÉPONSE JSON
        // ========================================
        return response()->json([
            'success' => true,
            'message' => $consent === 'accepted'
                ? 'Cookies acceptés et enregistrés'
                : 'Cookies non essentiels refusés et enregistré',
            'consent' => $consent,
            'recorded_at' => $cookieConsent->created_at->toIso8601String(),
        ]);
    }
}
