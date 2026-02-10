### Stratégie de Tests Automatisés : Calculatrice

**Commande :**
*   Exécuter les tests avec : `php artisan test tests/Unit/CalculatorTest.php`

**Principes Directeurs :**
1.  **Test Unitaire Pur :**
    - **Aucun trait DB** (Pas de `DatabaseTransactions`, pas de `RefreshDatabase`).
    - Ce test ne doit pas toucher à la base de données.
2.  **Modernisation :**
    - Utiliser les attributs PHPUnit 10+ `#[Test]`.
    - Nommage des méthodes en snake_case explicite (ex: `it_adds_two_numbers`).
    - Typage strict (`declare(strict_types=1);`).
3.  **Cible :**
    - Valider la classe utilitaire `Calculator` (méthode `add`).
4.  **Localisation :**
    - `tests/Unit/CalculatorTest.php`

**Objectif :**
Avoir un test unitaire simple, rapide et moderne pour la logique métier pure, servant d'exemple pour d'autres tests unitaires sans dépendances.
