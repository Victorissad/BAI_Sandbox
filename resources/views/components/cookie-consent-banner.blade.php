{{-- Bandeau cookies CNIL - Simple et fonctionnel --}}

{{-- Overlay bloquant --}}
<div id="cookie-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9998;"></div>

{{-- Modal --}}
<div id="cookie-modal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.3); max-width: 500px; width: 90%; z-index: 9999;">
    <h2 style="margin: 0 0 15px 0; font-size: 20px; font-weight: bold;">🍪 Gestion des cookies</h2>

    <p style="margin: 0 0 15px 0; color: #333; line-height: 1.5;">
        Ce site utilise des cookies essentiels pour son fonctionnement (authentification, sécurité, session).
    </p>

    <div style="background: #fef3cd; border-left: 4px solid #f0ad4e; padding: 10px; margin-bottom: 15px;">
        <p style="margin: 0; font-size: 14px; color: #856404;">
            <strong>⚠️</strong> Vous devez faire un choix pour continuer.
        </p>
    </div>

    {{-- Info choix actuel (caché par défaut) --}}
    <div id="current-choice" style="display: none; background: #f5f5f5; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
        <p style="margin: 0; font-size: 14px;">
            <strong>Choix actuel :</strong> <span id="current-choice-text"></span>
        </p>
    </div>

    {{-- Boutons --}}
    <div style="display: flex; gap: 10px;">
        <button id="accept-btn" style="flex: 1; background: #28a745; color: white; border: none; padding: 12px; border-radius: 5px; font-weight: bold; cursor: pointer; font-size: 16px;">
            ✓ Accepter
        </button>
        <button id="refuse-btn" style="flex: 1; background: #6c757d; color: white; border: none; padding: 12px; border-radius: 5px; font-weight: 600; cursor: pointer; font-size: 16px;">
            ✗ Refuser
        </button>
    </div>

    <p style="margin: 15px 0 0 0; font-size: 12px; color: #666; text-align: center;">
        Votre choix sera conservé 13 mois
    </p>
</div>

{{-- Bouton flottant pour rouvrir --}}
<button id="manage-btn" style="display: none; position: fixed; bottom: 20px; right: 20px; background: #007bff; color: white; border: none; padding: 15px; border-radius: 50%; font-size: 24px; cursor: pointer; box-shadow: 0 2px 10px rgba(0,0,0,0.3); z-index: 9997;">
    🍪
</button>

<script>
(function() {
    const overlay = document.getElementById('cookie-overlay');
    const modal = document.getElementById('cookie-modal');
    const manageBtn = document.getElementById('manage-btn');
    const acceptBtn = document.getElementById('accept-btn');
    const refuseBtn = document.getElementById('refuse-btn');
    const currentChoice = document.getElementById('current-choice');
    const currentChoiceText = document.getElementById('current-choice-text');

    // Lire un cookie
    function getCookie(name) {
        const cookies = document.cookie.split(';');
        for (let i = 0; i < cookies.length; i++) {
            const cookie = cookies[i].trim();
            if (cookie.startsWith(name + '=')) {
                return cookie.substring(name.length + 1);
            }
        }
        return null;
    }

    // Afficher le modal
    function showModal(firstVisit) {
        overlay.style.display = 'block';
        modal.style.display = 'block';

        if (firstVisit) {
            // Première visite : bloquer tout
            document.body.style.overflow = 'hidden';
            currentChoice.style.display = 'none';
            manageBtn.style.display = 'none';
        } else {
            // Modification : montrer le choix actuel
            const consent = getCookie('cookie_consent');
            if (consent) {
                currentChoiceText.textContent = consent === 'accepted' ? '✓ Cookies acceptés' : '✗ Cookies refusés';
                currentChoiceText.style.color = consent === 'accepted' ? '#28a745' : '#dc3545';
                currentChoiceText.style.fontWeight = 'bold';
                currentChoice.style.display = 'block';
            }
        }
    }

    // Cacher le modal
    function hideModal() {
        overlay.style.display = 'none';
        modal.style.display = 'none';
        document.body.style.overflow = '';
        manageBtn.style.display = 'block';
    }

    // Enregistrer le choix
    function saveChoice(choice) {
        acceptBtn.disabled = true;
        refuseBtn.disabled = true;
        acceptBtn.style.opacity = '0.5';
        refuseBtn.style.opacity = '0.5';

        fetch('{{ route("cookie.consent") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ consent: choice })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Définir le cookie côté client aussi
                const expires = new Date();
                expires.setMonth(expires.getMonth() + 13);
                document.cookie = 'cookie_consent=' + choice + '; expires=' + expires.toUTCString() + '; path=/';

                hideModal();
            }
        })
        .catch(() => {
            hideModal();
        })
        .finally(() => {
            acceptBtn.disabled = false;
            refuseBtn.disabled = false;
            acceptBtn.style.opacity = '1';
            refuseBtn.style.opacity = '1';
        });
    }

    // Vérifier si déjà fait un choix
    const consent = getCookie('cookie_consent');
    const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};

    // Afficher le modal UNIQUEMENT si l'user est connecté ET n'a pas encore fait de choix
    if (isAuthenticated && !consent) {
        showModal(true);
    } else if (consent) {
        // Si déjà un choix fait, afficher le bouton de gestion
        manageBtn.style.display = 'block';
    }

    // Events
    acceptBtn.onclick = () => saveChoice('accepted');
    refuseBtn.onclick = () => saveChoice('refused');
    manageBtn.onclick = () => showModal(false);
})();
</script>
