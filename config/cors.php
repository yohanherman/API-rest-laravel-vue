<?php

return [
    'paths' => ['api/*'], // Ajustez les chemins si nécessaire
    'allowed_methods' => ['*'], // Spécifiez les méthodes HTTP permises
    'allowed_origins' => ['*'], // Spécifiez les origines permises, ou utilisez `'*'` pour toutes les origines
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'], // Spécifiez les en-têtes HTTP permis
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // Permet les requêtes avec des informations d'identification
];
