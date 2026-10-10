<?php

final class Database
{
    private static ?PDO $pdo = null;

    public static function connection(array $config): PDO
    {
        if (self::$pdo !== null) {
            return self::$pdo;
        }

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        if ($config['driver'] === 'mysql') {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                $config['host'],
                $config['port'],
                $config['database']
            );
            self::$pdo = new PDO($dsn, $config['username'], $config['password'], $options);
        } else {
            $dir = dirname($config['sqlite']);
            if (!is_dir($dir)) {
                mkdir($dir, 0775, true);
            }
            self::$pdo = new PDO('sqlite:' . $config['sqlite'], null, null, $options);
            self::migrateSqlite(self::$pdo);
        }

        return self::$pdo;
    }

    /** Membuat tabel otomatis untuk SQLite agar aplikasi langsung bisa dipakai. */
    private static function migrateSqlite(PDO $pdo): void
    {
        $pdo->exec(
            'CREATE TABLE IF NOT EXISTS products (
                id          INTEGER PRIMARY KEY AUTOINCREMENT,
                sku         TEXT    NOT NULL UNIQUE,
                name        TEXT    NOT NULL,
                category    TEXT,
                price       REAL    NOT NULL DEFAULT 0,
                stock       INTEGER NOT NULL DEFAULT 0,
                description TEXT,
                created_at  TEXT    NOT NULL,
                updated_at  TEXT    NOT NULL
            )'
        );
    }
}
