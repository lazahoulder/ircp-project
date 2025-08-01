<?php

use Illuminate\Support\Facades\Route;

Route::get('/test-dom', function () {
    $result = [
        'extensions' => get_loaded_extensions(),
        'dom_extension' => extension_loaded('dom'),
        'xml_extension' => extension_loaded('xml'),
        'dom_class_exists' => class_exists('DOMDocument'),
        'dom_class_exists_explicit' => class_exists('\DOMDocument'),
    ];

    try {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $result['dom_instance_created'] = true;
    } catch (\Throwable $e) {
        $result['dom_instance_created'] = false;
        $result['error'] = $e->getMessage();
    }

    return response()->json($result);
});
