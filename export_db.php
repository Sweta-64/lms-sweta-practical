<?php
// Database export script
$host = '127.0.0.1';
$db = 'lms_sweta_practical';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    
    // Get all tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    $sql = "-- Employee Leave Management System Database Export\n";
    $sql .= "-- Exported on: " . date('Y-m-d H:i:s') . "\n";
    $sql .= "-- Database: $db\n\n";
    
    $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";
    
    foreach ($tables as $table) {
        // Drop table if exists
        $sql .= "DROP TABLE IF EXISTS `$table`;\n";
        
        // Get create table statement
        $createStmt = $pdo->query("SHOW CREATE TABLE `$table`");
        $createResult = $createStmt->fetch(PDO::FETCH_ASSOC);
        $sql .= $createResult['Create Table'] . ";\n\n";
        
        // Get table data
        $dataStmt = $pdo->query("SELECT * FROM `$table`");
        $rows = $dataStmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($rows)) {
            $columns = array_keys($rows[0]);
            $columnList = '`' . implode('`, `', $columns) . '`';
            
            $sql .= "INSERT INTO `$table` ($columnList) VALUES\n";
            
            foreach ($rows as $index => $row) {
                $values = array_map(function($val) {
                    if ($val === null) {
                        return 'NULL';
                    }
                    return "'" . str_replace("'", "''", $val) . "'";
                }, $row);
                
                $sql .= "(" . implode(", ", $values) . ")";
                $sql .= ($index < count($rows) - 1) ? ",\n" : ";\n";
            }
            $sql .= "\n";
        }
    }
    
    $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
    
    // Save to file
    file_put_contents(__DIR__ . '/database_export.sql', $sql);
    
    echo "✅ Database exported successfully!\n";
    echo "File: database_export.sql\n";
    echo "Tables: " . count($tables) . "\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
