<?php
// Autoload all helper files in App/Helpers
foreach (glob(__DIR__ . '/*_helper.php') as $helper) {
    require_once $helper;
}