<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modèle pour stocker les consentements aux cookies (RGPD/CNIL compliance)
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $consent_type
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string|null $session_id
 * @property string $consent_version
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class CookieConsent extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cookie_consents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'consent_type',
        'ip_address',
        'user_agent',
        'session_id',
        'consent_version',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation : Un consentement appartient à un utilisateur (optionnel)
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope pour récupérer les consentements acceptés
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAccepted($query)
    {
        return $query->where('consent_type', 'accepted');
    }

    /**
     * Scope pour récupérer les consentements refusés
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRefused($query)
    {
        return $query->where('consent_type', 'refused');
    }

    /**
     * Récupère le dernier consentement d'un utilisateur authentifié
     *
     * @param int $userId
     * @return CookieConsent|null
     */
    public static function getLatestForUser(int $userId): ?CookieConsent
    {
        return static::where('user_id', $userId)
            ->latest()
            ->first();
    }

    /**
     * Récupère le dernier consentement d'un visiteur anonyme via session_id
     *
     * @param string $sessionId
     * @return CookieConsent|null
     */
    public static function getLatestForSession(string $sessionId): ?CookieConsent
    {
        return static::where('session_id', $sessionId)
            ->whereNull('user_id')
            ->latest()
            ->first();
    }
}
