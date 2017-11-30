<?php
namespace App;
 
/**
 * SQLite connnection
 */
class DBConnection {
    /**
     * PDO instance
     * @var type 
     */
    private $pdo;
 
    /**
     * return in instance of the PDO object that connects to the SQLite database
     * @return \PDO
    */
    public function connect() {
        if ($this->pdo == null) {
            try {
                if($this->pdo==null){
                    $this->pdo = new \PDO("sqlite:" . Config::PATH_TO_SQLITE_FILE);
                }
            } catch(\PDOException $e) {
                echo $e->getMessage();
            }
        }
        $this->pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
        return $this->pdo;
    }

    /**
     * create tables 
    */
    public function createTables() {
        $commands = ['CREATE TABLE IF NOT EXISTS user (
                        id   INTEGER PRIMARY KEY,
                        username TEXT NOT NULL,
                        email VARCHAR (255) NOT NULL
                      )',
                     'CREATE TABLE IF NOT EXISTS transactions (
                       id   INTEGER PRIMARY KEY AUTOINCREMENT,
                       user_id INTEGER,
                       transaction_detail  VARCHAR (255) NOT NULL)'];

        // Create new tables
        foreach ($commands as $command) {
            $this->pdo->exec($command);
        }
    }

    /**
     * Truncate
     */
    public function drop()
    {
        // Drop tables
        $commands = ["DROP TABLE user","DROP TABLE transactions"];
        foreach ($commands as $command) {
            $this->pdo->exec($command);
        }

        // Re-create new tables
        $this->createTables();
    }
 }