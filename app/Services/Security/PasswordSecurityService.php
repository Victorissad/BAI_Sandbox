<?php

namespace App\Services\Security;

/**
 * Service dedicated to password security validation.
 *
 * This class is intentionally incomplete.
 * Students will implement ANSSI password rules here.
 */
class PasswordSecurityService
{
    /**
     * Validate password strength according to ANSSI recommendations.
     *
     * Rules applied:
     *  - Min length >= 12
     *  - At least one uppercase letter
     *  - At least one lowercase letter
     *  - At least one digit
     *  - At least one special character
     */
    public function validatePasswordStrength(string $password): bool
    {
        if (strlen($password) < 12) {
            return false;
        }

        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }

        if (!preg_match('/[a-z]/', $password)) {
            return false;
        }

        if (!preg_match('/[0-9]/', $password)) {
            return false;
        }

        if (!preg_match('/[\W_]/', $password)) {
            return false;
        }

        return true;
    }
}
