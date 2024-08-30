<?php
require_once 'core/db.php';
$db = new db();
$pdo = $db->connect();

// Get the list of migration files
$migrations = glob('migrations/*.php');
sort($migrations);

// Track which migrations have been run (in a migrations table)
$pdo->exec("
    CREATE TABLE IF NOT EXISTS migrations (
        migration VARCHAR(255) NOT NULL,
        PRIMARY KEY (migration)
    );
");

foreach ($migrations as $migration) {
    $migrationName = basename($migration, '.php');

    // Check if the migration has already been run
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM migrations WHERE migration = :migration");
    $stmt->execute([':migration' => $migrationName]);
    
    if ($stmt->fetchColumn() == 0) {
        // Include and run the migration
        require_once $migration;
        $className = str_replace('_', '', ucwords($migrationName, '_'));
        $migrationInstance = new $className();

        try {
            $pdo->exec($migrationInstance->up());

            // Mark migration as run
            $stmt = $pdo->prepare("INSERT INTO migrations (migration) VALUES (:migration)");
            $stmt->execute([':migration' => $migrationName]);

            echo "Migration {$migrationName} ran successfully.\n";
        } catch (PDOException $e) {
            echo "Failed to run migration {$migrationName}: " . $e->getMessage() . "\n";
        }
    } else {
        echo "Migration {$migrationName} has already been run.\n";
    }
}


?>