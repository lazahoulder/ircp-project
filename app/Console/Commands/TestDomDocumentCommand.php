<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestDomDocumentCommand extends Command
{
    protected $signature = 'test:dom';
    protected $description = 'Test if DOMDocument is available in Laravel context';

    public function handle()
    {
        $this->info('Testing DOMDocument in Laravel context...');

        // Test if DOMDocument is available in the global namespace
        if (class_exists('DOMDocument')) {
            $this->info('DOMDocument exists in global namespace');
        } else {
            $this->error('DOMDocument does not exist in global namespace');
        }

        // Test if DOMDocument is available with explicit namespace
        if (class_exists('\DOMDocument')) {
            $this->info('DOMDocument exists with explicit global namespace');
        } else {
            $this->error('DOMDocument does not exist with explicit global namespace');
        }

        // Try to create a DOMDocument instance
        try {
            $dom = new \DOMDocument('1.0', 'UTF-8');
            $this->info('Successfully created DOMDocument instance');
        } catch (\Throwable $e) {
            $this->error('Error creating DOMDocument instance: ' . $e->getMessage());
        }

        return 0;
    }
}
