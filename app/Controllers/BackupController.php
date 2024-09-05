<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;

class BackupController extends Controller
{
    public function index()
    {
        // Optionally, you can use this method to display a view or some content.
    }

    public function DownloadDatabaseSQL()
    {
        // Get database configuration from CodeIgniter
        $db = Database::connect();
        $conn = $db->getConnection();

        // Get All Table Names From the Database
        $tables = [];
        $sql = "SHOW TABLES";
        $result = $db->query($sql);
        foreach ($result->getResultArray() as $row) {
            $tables[] = $row["Tables_in_" . $db->getDatabase()];
        }

        $sqlScript = "";
        foreach ($tables as $table) {
            // Prepare SQL script for creating table structure
            $query = "SHOW CREATE TABLE $table";
            $result = $db->query($query);
            $row = $result->getRowArray();
            $sqlScript .= "\n\n" . $row['Create Table'] . ";\n\n";

            $query = "SELECT * FROM $table";
            $result = $db->query($query);
            $columnCount = $result->getFieldCount();

            // Prepare SQL script for dumping data for each table
            foreach ($result->getResultArray() as $row) {
                $sqlScript .= "INSERT INTO $table VALUES(";
                $values = [];
                foreach ($row as $value) {
                    if (is_null($value)) {
                        $values[] = 'NULL';
                    } elseif (is_string($value)) {
                        $values[] = '"' . $db->escapeString($value) . '"';
                    } else {
                        $values[] = $value;
                    }
                }
                $sqlScript .= implode(',', $values) . ");\n";
            }

            $sqlScript .= "\n";
        }

        if (!empty($sqlScript)) {
            // Save the SQL script to a backup file
            $database_name = $db->getDatabase();
            $backup_file_name = $database_name . '_backup_' . time() . '.sql';
            $fileHandler = fopen($backup_file_name, 'w+');
            fwrite($fileHandler, $sqlScript);
            fclose($fileHandler);

            // Download the SQL backup file to the browser
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($backup_file_name));
            ob_clean();
            flush();
            readfile($backup_file_name);
            unlink($backup_file_name); // Use unlink instead of exec('rm')
        }
    }
}
