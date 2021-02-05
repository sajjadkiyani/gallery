<?php
/**
 * include plugins helpers
 */
    if ( file_exists( __DIR__ )) {
        foreach (scandir(__DIR__) as $file) {
            if (pathinfo($file , PATHINFO_EXTENSION) == "php")
            include_once $file;
        }
    }
