<?php
class AuthMiddleware {

    // Check if user is logged in
    public static function isAuthenticated() {
        session_start();
        if (!isset($_SESSION['user'])) {
            Flight::halt(401, 'Unauthorized – Please log in');
        }
    }

    // Check if user has a specific role
    public static function authorizeRole($role) {
        self::isAuthenticated(); // Must be logged in first

        if ($_SESSION['user']['role'] !== $role) {
            Flight::halt(403, 'Forbidden – Insufficient permissions');
        }
    }

    // Optionally get current user
    public static function currentUser() {
        session_start();
        return $_SESSION['user'] ?? null;
    }
}
?>
