<?php
class Navigation {
    static function redirect($path) {
        header($path);
    }
}