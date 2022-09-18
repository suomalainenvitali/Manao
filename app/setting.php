<?php
    namespace App;

    // Checking for ajax request
    class Setting {
        public static function isAjax(): bool {
            if (
                isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
            ) {
                return true;
            }

            return false;
        }
    }
?>