<?php
try {
    $pdo = new PDO("mysql:host=localhost;port=3306;dbname=glamora", "root", "Madhu@Sri@2717", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    $sqlExport = "-- Glamora Database Full Export for InfinityFree hosting\n";
    $sqlExport .= "-- Generated on " . date('Y-m-d H:i:s') . "\n\n";
    $sqlExport .= "SET FOREIGN_KEY_CHECKS = 0;\n\n";

    foreach ($tables as $tbl) {
        $sqlExport .= "-- Structure for table `$tbl` --\n";
        $sqlExport .= "DROP TABLE IF EXISTS `$tbl`;\n";
        $createTbl = $pdo->query("SHOW CREATE TABLE `$tbl`")->fetch(PDO::FETCH_ASSOC);
        $sqlExport .= $createTbl['Create Table'] . ";\n\n";

        // Dump data
        $rows = $pdo->query("SELECT * FROM `$tbl`")->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($rows)) {
            $sqlExport .= "-- Data for table `$tbl` --\n";
            foreach ($rows as $row) {
                $cols = array_map(function($c) { return "`$c`"; }, array_keys($row));
                $vals = array_map(function($v) use ($pdo) {
                    if ($v === null) return "NULL";
                    return $pdo->quote($v);
                }, array_values($row));

                $sqlExport .= "INSERT INTO `$tbl` (" . implode(', ', $cols) . ") VALUES (" . implode(', ', $vals) . ");\n";
            }
            $sqlExport .= "\n";
        }
    }

    $sqlExport .= "SET FOREIGN_KEY_CHECKS = 1;\n";
    file_put_contents(__DIR__ . '/glamora_infinityfree_schema.sql', $sqlExport);
    echo "✓ Exported full database to glamora_infinityfree_schema.sql (" . strlen($sqlExport) . " bytes)\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
