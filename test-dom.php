<?php

// Test if DOMDocument is available in the global namespace
if (class_exists('DOMDocument')) {
    echo "DOMDocument exists in global namespace\n";
} else {
    echo "DOMDocument does not exist in global namespace\n";
}

// Test if DOMDocument is available with explicit namespace
if (class_exists('\DOMDocument')) {
    echo "DOMDocument exists with explicit global namespace\n";
} else {
    echo "DOMDocument does not exist with explicit global namespace\n";
}

// Try to create a DOMDocument instance
try {
    $dom = new \DOMDocument('1.0', 'UTF-8');
    echo "Successfully created DOMDocument instance\n";
} catch (\Throwable $e) {
    echo "Error creating DOMDocument instance: " . $e->getMessage() . "\n";
}
