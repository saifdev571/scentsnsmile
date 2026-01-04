<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ExtractInserts extends Command
{
    protected $signature = 'db:extract-inserts {input} {output}';
    protected $description = 'Extract only INSERT statements from SQL file to a new file';

    public function handle()
    {
        $inputFile = $this->argument('input');
        $outputFile = $this->argument('output');
        
        if (!File::exists($inputFile)) {
            $this->error("Input file not found: {$inputFile}");
            return 1;
        }

        $this->info("Reading SQL file...");
        $sqlContent = File::get($inputFile);
        
        // Tables to extract
        $tablesToExtract = [
            'genders', 'tags', 'collections', 'categories', 'sizes',
            'testimonials', 'banners', 'highlight_notes', 'scent_families',
            'products', 'product_variants', 'product_gender', 'product_tag',
            'product_collection', 'product_size', 'bundles', 'bundle_products',
            'settings'
        ];
        
        $output = "-- Extracted INSERT statements\n";
        $output .= "SET FOREIGN_KEY_CHECKS=0;\n";
        $output .= "SET SQL_MODE=\"NO_AUTO_VALUE_ON_ZERO\";\n\n";
        
        foreach ($tablesToExtract as $table) {
            $this->info("Extracting INSERTs for table: {$table}");
            
            // Match INSERT statements for this table
            $pattern = '/INSERT\s+INTO\s+`?' . preg_quote($table, '/') . '`?\s+.*?;/is';
            preg_match_all($pattern, $sqlContent, $matches);
            
            if (!empty($matches[0])) {
                $output .= "-- Table: {$table}\n";
                foreach ($matches[0] as $insert) {
                    $output .= $insert . "\n\n";
                }
                $this->info("  Found " . count($matches[0]) . " INSERT statement(s)");
            }
        }
        
        $output .= "SET FOREIGN_KEY_CHECKS=1;\n";
        
        File::put($outputFile, $output);
        
        $this->info("Extracted SQL saved to: {$outputFile}");
        $this->info("You can now import it using: mysql -u root SCENTSNSMILE < {$outputFile}");
        
        return 0;
    }
}
