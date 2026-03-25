<?php

if (!function_exists('public_html_path')) {
    function public_html_path(string $path = ''): string
    {
        return base_path('public_html') . ($path ? DIRECTORY_SEPARATOR . $path : '');
    }
}
