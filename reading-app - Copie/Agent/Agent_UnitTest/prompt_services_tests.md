### Stratégie de Tests Automatisés

**Commande :**
*   Exécuter les tests avec : `php artisan test`

**Principes Directeurs :**
1.  **Exploitation des Seeders :** Les tests doivent utiliser les données existantes chargées par les seeders (`UserSeeder`, `CategorySeeder`, `BookSeeder`) plutôt que de créer des données fictives ("factories") à chaque test.
2.  **Transaction Unique :** Utiliser le trait `DatabaseTransactions` (pas `RefreshDatabase`) pour envelopper chaque test dans une transaction annulable, préservant ainsi la rapidité et l'intégrité de la base peuplée.
3.  **Cible :** Valider la logique métier encapsulée dans les services (`BookService`, `CategoryService`).
4.  **Localisation :**
    *   Tests Unitaires : `tests/Unit`

**Objectif :**
Garantir que la logique métier fonctionne correctement sur le jeu de données "réel" de l'application, en testant les scénarios nominaux (liste, recherche, création, suppression) sans altérer la base de données de manière permanente.