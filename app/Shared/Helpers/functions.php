<?php

if (!function_exists('requestIP')) {
    function requestIP() {
        return request()->ip();
    }
}

if (!function_exists('requestHeaders')) {
    function requestHeaders() {
        return request()->headers->all();
    }
}

if (!function_exists('requestParams')) {
    function requestParams() {
        return request()->query();
    }
}

if (!function_exists('requestBody')) {
    function requestBody() {
        return request()->all();
    }
}
