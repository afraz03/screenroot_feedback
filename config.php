<?php
declare(strict_types=1);

// Update these for your server. Keep this file out of public Git repos.
const DB_HOST = 'localhost';
const DB_NAME = 'screenroot_feedback';
const DB_USER = 'root';
const DB_PASS = '';
const IP_SALT = 'change-this-to-a-long-random-string';

function db(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]
        );
    }
    return $pdo;
}

// Dashboard login (admin/). CHANGE THESE before going live.
const ADMIN_USER     = 'admin';
const ADMIN_PASSWORD = 'ChangeMe@123';
