<?php

if (!function_exists('formatNamaIklan')) {
    function formatNamaIklan(string $tipe, ?string $slug = null, string $posisi = 'Header'): string
    {
        $nama = str_replace('-', ' ', $slug);
        $nama = ucwords($nama);
        return "$tipe - $nama - $posisi";
    }
}
