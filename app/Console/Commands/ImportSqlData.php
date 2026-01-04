<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImportSqlData extends Command
{
    protected $signature = 'db:import-data {file}';
    protected $description = 'Import only INSERT statements from SQL file';

    public function handle()
    {
        $filePath = $this->argument('file');
        
        if (!File::exists($filePath)) {
            $this->error("File not found: {$filePath}");
            return 1;
        }

        $this->info("Reading SQL file...");
        $sqlContent = File::get($filePath);
        
        // Remove comments and normalize line endings
        $sqlContent = preg_replace('/^--.*$/m', '', $sqlContent);
        $sqlContent = preg_replace('/\/\*.*?\*\//s', '', $sqlContent);
        
        // Extract only INSERT statements (handle multi-line properly)
        $this->info("Extracting INSERT statements...");
        preg_match_all('/INSERT\s+INTO\s+`?[\w]+`?[^;]*;/is', $sqlContent, $matches);
        
        $insertStatements = $matches[0];
        
        // Filter out empty statements
        $insertStatements = array_filter($insertStatements, function($stmt) {
            return !empty(trim($stmt));
        });
        $totalStatements = count($insertStatements);
        
        if ($totalStatements === 0) {
            $this->error("No INSERT statements found in the file.");
            return 1;
        }
        
        $this->info("Found {$totalStatements} INSERT statements.");
        $this->info("Starting import...");
        
        $successCount = 0;
        $errorCount = 0;
        $bar = $this->output->createProgressBar($totalStatements);
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        foreach ($insertStatements as $statement) {
            try {
                DB::unprepared($statement);
                $successCount++;
            } catch (\Exception $e) {
                $errorCount++;
                // Extract table name for error reporting
                preg_match('/INSERT INTO `?(\w+)`?/i', $statement, $tableMatch);
                $tableName = $tableMatch[1] ?? 'unknown';
                $this->newLine();
                $this->warn("Error importing to table '{$tableName}': " . $e->getMessage());
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
        }
        
        return 0;
    }
}
