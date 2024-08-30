<?php

class CreateUsersTable {
    public function up() {
        return "
            CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
        ";
    }

    public function down() {
        return "DROP TABLE IF EXISTS users;";
    }
}


?>