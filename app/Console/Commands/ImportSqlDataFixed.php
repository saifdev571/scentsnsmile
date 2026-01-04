<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImportSqlDataFixed extends Command
{
    protected $signature = 'db:import-data-fixed {file}';
    protected $description = 'Import only INSERT statements from SQL file (improved version)';

    public function handle()
    {
        $filePath = $this->argument('file');
        
        if (!File::exists($filePath)) {
            $this->error("File not found: {$filePath}");
            return 1;
        }

        $this->info("Reading SQL file...");
        $sqlContent = File::get($filePath);
        
        // Extract only INSERT statements for specific tables we want
        $this->info("Extracting INSERT statements...");
        
        // Tables to import (excluding system tables like migrations, sessions, etc.)
        $tablesToImport = [
            'genders', 'tags', 'collections', 'categories', 'sizes',
            'testimonials', 'banners', 'highlight_notes', 'scent_families',
            'products', 'product_variants', 'product_gender', 'product_tag',
            'product_collection', 'product_size', 'bundles', 'bundle_products',
            'settings'
        ];
        
        $insertStatements = [];
        
        foreach ($tablesToImport as $table) {
            // Match INSERT statements for this table
            $pattern = '/INSERT\s+INTO\s+`?' . preg_quote($table, '/') . '`?\s+.*?;/is';
            preg_match_all($pattern, $sqlContent, $matches);
            
            if (!empty($matches[0])) {
                $this->info("Found " . count($matches[0]) . " INSERT statement(s) for table: {$table}");
                $insertStatements = array_merge($insertStatements, $matches[0]);
            }
        }
        
        $totalStatements = count($insertStatements);
        
        if ($totalStatements === 0) {
            $this->error("No INSERT statements found for specified tables.");
            return 1;
        }
        
        $this->info("Total INSERT statements to import: {$totalStatements}");
        $this->info("Starting import...");
        
        $successCount = 0;
        $errorCount = 0;
        $bar = $this->output->createProgressBar($totalStatements);
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement('SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";');
        
        foreach ($insertStatements as $statement) {
            try {
                DB::unprepared($statement);
                $successCount++;
            } catch (\Exception $e) {
                $errorCount++;
                // Extract table name for error reporting
                preg_match('/INSERT\s+INTO\s+`?(\w+)`?/i', $statement, $tableMatch);
                $tableName = $tableMatch[1] ?? 'unknown';
                
                // Only show first few errors to avoid spam
                if ($errorCount <= 5) {
                    $this->newLine();
                    $this->warn("Error importing to table '{$tableName}': " . substr($e->getMessage(), 0, 150));
                }
            }
            $bar->advance();
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $bar->finish();
        $this->newLine(2);
        
        $this->info("Import completed!");
        $this->info("Successful: {$successCount}");
        if ($errorCount > 0) {
            $this->warn("Failed: {$errorCount}");
            if ($errorCount > 5) {
                $this->warn("(Only first 5 errors shown)");
            }
        }
        
        return 0;
    }
}
