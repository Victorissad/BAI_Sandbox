@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">Politique de confidentialité</h1>
    <p class="text-sm text-gray-500 mb-8">Dernière mise à jour : mars 2026 — Version 1.0</p>

    {{-- 1. Responsable du traitement --}}
    <section class="mb-8">
        <h2 class="text-xl font-semibold mb-2">1. Responsable du traitement</h2>
        <p>Le responsable du traitement des données personnelles collectées sur cette application est :</p>
        <ul class="list-disc ml-6 mt-2">
            <li><strong>Société :</strong> BTSSIOBloc3.com</li>
            <li><strong>Contact :</strong> <a href="mailto:contact@btsssiobloc3.com" class="text-blue-600 underline">contact@btsssiobloc3.com</a></li>
        </ul>
    </section>

    {{-- 2. Données collectées --}}
    <section class="mb-8">
        <h2 class="text-xl font-semibold mb-2">2. Données collectées</h2>
        <p>Dans le cadre de l'utilisation de la Boîte À Idées (BAI), les données suivantes sont collectées :</p>
        <ul class="list-disc ml-6 mt-2">
            <li>Nom d'utilisateur</li>
            <li>Adresse e-mail</li>
            <li>Mot de passe (stocké sous forme de hachage, jamais en clair)</li>
            <li>Idées et commentaires soumis</li>
            <li>Journaux d'actions (logs) : adresse IP, agent navigateur, actions effectuées</li>
            <li>Consentement aux cookies : date, adresse IP, agent navigateur, choix effectué</li>
        </ul>
    </section>

    {{-- 3. Finalités du traitement --}}
    <section class="mb-8">
        <h2 class="text-xl font-semibold mb-2">3. Finalités du traitement</h2>
        <p>Les données collectées sont utilisées pour :</p>
        <ul class="list-disc ml-6 mt-2">
            <li>Permettre l'authentification et la gestion des comptes utilisateurs</li>
            <li>Assurer le fonctionnement de la boîte à idées (création, modification, suppression d'idées et commentaires)</li>
            <li>Assurer la sécurité de l'application (traçabilité des actions)</li>
            <li>Respecter les obligations légales (preuve de consentement)</li>
        </ul>
        <p class="mt-2">Conformément au RGPD, les données ne sont pas utilisées à d'autres fins que celles déclarées ci-dessus.</p>
    </section>

    {{-- 4. Durée de conservation --}}
    <section class="mb-8">
        <h2 class="text-xl font-semibold mb-2">4. Durée de conservation</h2>
        <ul class="list-disc ml-6 mt-2">
            <li><strong>Données de compte :</strong> conservées pendant toute la durée d'utilisation du service</li>
            <li><strong>Logs de connexion et de sécurité :</strong> 6 mois à 1 an maximum</li>
            <li><strong>Données après suppression du compte :</strong> suppression ou anonymisation rapide</li>
            <li><strong>Preuves de consentement cookies :</strong> durée du traitement + délai légal de contestation</li>
        </ul>
    </section>

    {{-- 5. Droits des utilisateurs --}}
    <section class="mb-8">
        <h2 class="text-xl font-semibold mb-2">5. Vos droits</h2>
        <p>Conformément au RGPD, vous disposez des droits suivants concernant vos données personnelles :</p>
        <ul class="list-disc ml-6 mt-2">
            <li><strong>Droit à l'information :</strong> être informé sur le traitement de vos données</li>
            <li><strong>Droit d'accès :</strong> obtenir une copie des données vous concernant</li>
            <li><strong>Droit de rectification :</strong> corriger des données inexactes ou incomplètes</li>
            <li><strong>Droit à l'effacement (droit à l'oubli) :</strong> demander la suppression de vos données</li>
            <li><strong>Droit à la limitation du traitement :</strong> suspendre temporairement l'utilisation de vos données</li>
            <li><strong>Droit d'opposition :</strong> vous opposer à un traitement de vos données</li>
            <li><strong>Droit à la portabilité :</strong> récupérer vos données dans un format structuré et lisible</li>
        </ul>
    </section>

    {{-- 6. Contact --}}
    <section class="mb-8">
        <h2 class="text-xl font-semibold mb-2">6. Exercer vos droits</h2>
        <p>Pour exercer vos droits ou pour toute question relative à la protection de vos données personnelles, vous pouvez contacter le responsable du traitement :</p>
        <ul class="list-disc ml-6 mt-2">
            <li>Par e-mail : <a href="mailto:contact@btsssiobloc3.com" class="text-blue-600 underline">contact@btsssiobloc3.com</a></li>
        </ul>
        <p class="mt-2">Vous disposez également du droit d'introduire une réclamation auprès de la <a href="https://www.cnil.fr" class="text-blue-600 underline" target="_blank">CNIL</a> si vous estimez que vos droits ne sont pas respectés.</p>
    </section>

    {{-- 7. Cookies --}}
    <section class="mb-8">
        <h2 class="text-xl font-semibold mb-2">7. Cookies</h2>
        <p>Cette application utilise des cookies essentiels au fonctionnement du service (session, sécurité CSRF). Aucun cookie de suivi ou publicitaire n'est utilisé sans votre consentement explicite.</p>
        <p class="mt-2">Vous pouvez accepter ou refuser les cookies non essentiels via le bandeau présenté lors de votre première visite.</p>
    </section>
</div>
@endsection
