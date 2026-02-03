### Stratégie de Tests Automatisés : BookService

**Commande :**
*   Exécuter les tests avec : `php artisan test tests/Unit/BookServiceTest.php`

**Principes Directeurs :**
1.  **Exploitation des Seeders :**
    - Ne jamais utiliser de Factories (`Book::factory()`).
    - Utiliser `Book::count()` et récupérer des livres existants (`Book::first()`).
2.  **Transaction Unique :**
    - Utiliser `use DatabaseTransactions;`.
3.  **Localisation :**
    - `tests/Unit/BookServiceTest.php`

**Objectif :**
Générer 5 cas de tests précis pour `BookService` (getAll, search, category, create, delete) en n'utilisant que des données pré-chargées.
