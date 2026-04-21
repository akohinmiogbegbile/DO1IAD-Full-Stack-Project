<?php
/*
 * functions.php
 *
 * This file contains reusable helper functions used across the application.
 */

/**
 * Sanitize output to prevent XSS attacks
 */
function e($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}