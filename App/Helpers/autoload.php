<?php

if (!function_exists('load_helpers')) {

    function load_helpers(): void
    {
        foreach (glob(__DIR__ . '/*_helper.php') as $helper) {
            require_once $helper;
        }
    }

}

load_helpers();