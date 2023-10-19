<?php

class Navigation {
    static function redirectPage($path) {
        header("location: public/" . $path);
    }

    static function redirect($path) {
        header("location: " . $path);
    }
}