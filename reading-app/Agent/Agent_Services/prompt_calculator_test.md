### Stratégie de Tests Automatisés : Calculator

**Commande :**
*   Exécuter les tests avec : `php artisan test tests/Unit/CalculatorTest.php`

**Principes Directeurs :**
1.  **Test Unitaire Pur :**
    - Pas de base de données (pas de traits DB).
2.  **Modernisation :**
    - Attributs `#[Test]`.
    - Strict Types.
3.  **Localisation :**
    - `tests/Unit/CalculatorTest.php`

**Objectif :**
Test simple et rapide pour la logique métier pure.
