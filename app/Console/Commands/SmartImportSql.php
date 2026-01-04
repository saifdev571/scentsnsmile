<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SmartImportSql extends Command
{
    protected $signature = 'db:smart-import {file}';
    protected $description = 'Smart import SQL data - handles missing columns';

    // Tables to skip during import
    protected $skipTables = ['migrations', 'password_reset_tokens', 'sessions', 'cache', 'cache_locks', 'jobs', 'job_batches', 'failed_jobs'];

    public function handle()
    {
        $file = $this->argument('file');
        
        if (!file_exists($file)) {
            $this->error("File not found: $file");
            return 1;
        }

        $this->info("Reading SQL file...");
        $content = file_get_contents($file);
        
        // Extract INSERT statements
        preg_match_all('/INSERT INTO `(\w+)` \(([^)]+)\) VALUES\s*\n?(.*?);/s', $content, $matches, PREG_SET_ORDER);
        
        $this->info("Found " . count($matches) . " INSERT statements");
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        $imported = 0;
        $skipped = 0;
        $errors = [];

        foreach ($matches as $match) {
            $tableName = $match[1];
            $columnsStr = $match[2];
            $valuesStr = $match[3];
            
            // Skip certain tables
            if (in_array($tableName, $this->skipTables)) {
                $this->line("Skipping table: $tableName");
                $skipped++;
                continue;
            }
            
            // Check if table exists
            if (!Schema::hasTable($tableName)) {
                $this->warn("Table does not exist: $tableName");
                $skipped++;
                continue;
            }
            
            // Parse columns from SQL
            $sqlColumns = array_map(function($col) {
                return trim($col, '` ');
            }, explode(',', $columnsStr));
            
            // Get actual table columns
            $tableColumns = Schema::getColumnListing($tableName);
            
            // Find which columns exist
            $validColumns = [];
            $validIndices = [];
            foreach ($sqlColumns as $index => $col) {
                if (in_array($col, $tableColumns)) {
                    $validColumns[] = $col;
                    $validIndices[] = $index;
                }
            }
            
            if (empty($validColumns)) {
                $this->warn("No valid columns for table: $tableName");
                $skipped++;
                continue;
            }
            
            // Parse values - handle multi-row inserts
            $rows = $this->parseValues($valuesStr, count($sqlColumns));
            
            foreach ($rows as $row) {
                // Filter values to only include valid columns
                $filteredValues = [];
                foreach ($validIndices as $idx) {
                    if (isset($row[$idx])) {
                        $filteredValues[] = $row[$idx];
                    }
                }
                
                if (count($filteredValues) !== count($validColumns)) {
                    continue;
                }
                
                // Build insert query
                $placeholders = implode(',', array_fill(0, count($validColumns), '?'));
                $columnsList = implode(',', array_map(fn($c) => "`$c`", $validColumns));
                
                try {
                    DB::insert("INSERT INTO `$tableName` ($columnsList) VALUES ($placeholders)", $filteredValues);
                    $imported++;
                } catch (\Exception $e) {
                    // Try with IGNORE
                    try {
                        DB::insert("INSERT IGNORE INTO `$tableName` ($columnsList) VALUES ($placeholders)", $filteredValues);
                        $imported++;
                    } catch (\Exception $e2) {
                        $errors[] = "$tableName: " . $e2->getMessage();
                    }
                }
            }
            
            $this->info("Imported data for: $tableName");
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        $this->info("\n=== Import Complete ===");
        $this->info("Imported: $imported rows");
        $this->info("Skipped: $skipped tables");
        
        if (!empty($errors)) {
            $this->warn("\nErrors (" . count($errors) . "):");
            foreach (array_slice($errors, 0, 10) as $error) {
                $this->error($error);
            }
        }
        
        return 0;
    }


    protected function parseValues($valuesStr, $expectedCount)
    {
        $rows = [];
        $currentRow = [];
        $currentValue = '';
        $inString = false;
        $stringChar = '';
        $depth = 0;
        $escaped = false;
        
        $valuesStr = trim($valuesStr);
        
        for ($i = 0; $i < strlen($valuesStr); $i++) {
            $char = $valuesStr[$i];
            $prevChar = $i > 0 ? $valuesStr[$i - 1] : '';
            
            if ($escaped) {
                $currentValue .= $char;
                $escaped = false;
                continue;
            }
            
            if ($char === '\\') {
                $escaped = true;
                $currentValue .= $char;
                continue;
            }
            
            if (!$inString && ($char === "'" || $char === '"')) {
                $inString = true;
                $stringChar = $char;
                $currentValue .= $char;
                continue;
            }
            
            if ($inString && $char === $stringChar) {
                // Check for escaped quote
                if ($i + 1 < strlen($valuesStr) && $valuesStr[$i + 1] === $stringChar) {
                    $currentValue .= $char;
                    continue;
                }
                $inString = false;
                $currentValue .= $char;
                continue;
            }
            
            if ($inString) {
                $currentValue .= $char;
                continue;
            }
            
            if ($char === '(') {
                $depth++;
                if ($depth === 1) {
                    $currentValue = '';
                    continue;
                }
            }
            
            if ($char === ')') {
                $depth--;
                if ($depth === 0) {
                    // End of row
                    $currentRow[] = $this->cleanValue($currentValue);
                    $rows[] = $currentRow;
                    $currentRow = [];
                    $currentValue = '';
                    continue;
                }
            }
            
            if ($depth === 1 && $char === ',') {
                $currentRow[] = $this->cleanValue($currentValue);
                $currentValue = '';
                continue;
            }
            
            if ($depth > 0) {
                $currentValue .= $char;
            }
        }
        
        return $rows;
    }
    
    protected function cleanValue($value)
    {
        $value = trim($value);
        
        if ($value === 'NULL' || $value === 'null') {
            return null;
        }
        
        // Remove surrounding quotes
        if ((str_starts_with($value, "'") && str_ends_with($value, "'")) ||
            (str_starts_with($value, '"') && str_ends_with($value, '"'))) {
            $value = substr($value, 1, -1);
            // Unescape
            $value = str_replace(["''", '\"', "\\'"], ["'", '"', "'"], $value);
            $value = stripslashes($value);
        }
        
        return $value;
    }
}
