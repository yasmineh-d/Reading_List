### Stratégie de Tests Automatisés : CategoryService

**Commande :**
*   Exécuter les tests avec : `php artisan test tests/Unit/CategoryServiceTest.php`

**Principes Directeurs :**
1.  **Exploitation des Seeders :**
    - Interdiction d'utiliser `Category::factory()`.
    - Compter les catégories existantes avec `Category::count()` pour vérifier `getAll()`.
2.  **Transaction Unique :**
    - Utiliser `use DatabaseTransactions;`.
3.  **Localisation :**
    - `tests/Unit/CategoryServiceTest.php`

**Objectif :**
Valider la récupération et la création de catégories sans polluer la base de données.
