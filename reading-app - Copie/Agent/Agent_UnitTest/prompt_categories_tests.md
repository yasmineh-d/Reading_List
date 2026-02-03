### Stratégie de Tests Automatisés : Catégories

**Commande :**
*   Exécuter les tests avec : `php artisan test tests/Unit/CategoryServiceTest.php`

**Principes Directeurs :**
1.  **Exploitation des Seeders :**
    - **Interdiction formelle** d'utiliser `Category::factory()->create()` dans les tests, car la base est déjà peuplée.
    - Utiliser `Category::count()` pour l'état initial.
    - Récupérer des catégories existantes (ex: `Category::first()`) pour vérifier les méthodes de lecture.
2.  **Transaction Unique :**
    - Utiliser le trait `DatabaseTransactions` pour `CategoryServiceTest`.
    - Bannir `RefreshDatabase`.
3.  **Cible :**
    - Valider `CategoryService` (méthodes `getAll`, `create`...).
4.  **Localisation :**
    - `tests/Unit/CategoryServiceTest.php`

**Objectif :**
Harmoniser `CategoryServiceTest` avec `BookServiceTest` en utilisant les données seedées et des transactions, pour un test rapide et fiable.
