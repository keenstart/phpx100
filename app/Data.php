<?php

namespace App;

use App\DBConnection;

class Data 
{
	  /**
     * db instance
     * @var type 
     */
    private $pdo;
  
    /**
     * db instance
     * @var type 
     */
    private $db;

     /**
     * data array
     * @var type 
     */
    private $dataUser;

    /**
     * data array
     * @var type 
     */
    private $dataTransaction;   

    public function __construct($db) 
    {
    	$this->db = $db;
      $this->pdo = $db->connect();
    }

    /**
     * Get progress
    */
    public  function getProgress()
    {
      $filename = "db/progress.txt";

      $myfile = fopen($filename, "r") or die("Unable to open file!");
      $progres = fread($myfile,filesize($filename));
      fclose($myfile); 

      return trim($progres);
    }

    /**
     * Stop loading
    */
    public function stopLoading()
    {
      $filename = "db/stopStart.txt";

      if (file_exists($filename)) {
        unlink($filename);
      } 
    }

    /**
     * Launch Loading
    */    
    public function insertData()
    {
        return $this->loadUserWithDataArray();
    }

    /**
     * Load 1 million user to array pass it for storage db
    */
    private function loadUserWithDataArray()
    {
        $this->db->drop();
        
        set_time_limit(0);

        $filename = "db/stopStart.txt";
        if (!file_exists($filename)) {
          $myfile = fopen($filename, "w") or die("Unable to open file!");
          fclose($myfile);
        }        

        for ($x = 1; $x <= 1000000; $x++) {
            $array = ['id' => $x,
                      'username' => uniqid('user_'),
                      'email' => uniqid().'@mail.com'];

            $this->dataUser[] = $array;

            $progress = ($x / 1000000) * 100;
            $file = "db/progress.txt";      
            $myfile = fopen($file, "w+") or die("Unable to open file!");
            fwrite($myfile, $progress);
            fclose($myfile);

            if($x % 10000 === 0) {
                $this->saveToDatabase();
                $this->dataUser = []; 
            }
            if (!file_exists($filename)) {
              return false;
            }
        }
    }

    /**
     * Load 1 million user from array to db
    */
    private function saveToDatabase()
    {
      foreach ($this->dataUser as $key => $value) {
          $this->insertUser($value['id'], $value['username'], $value['email']);
      }
    }   

    /**
    * insert into User tables 
    */
    private function insertUser($id,$username, $email) {
        $sql = "INSERT INTO user(id, username, email) VALUES(:id, :username, :email)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':id' => $id,
            ':username' => $username,
            ':email' => $email,
        ]);
 
        return $this->pdo->lastInsertId();
    }

    /**
     * Load user transaction to array pass it for storage db
    */
    public function loadTransaction()
    {
      $this->db->createTables();
      $this->db->drop();
      $this->dataUser = [];  
      
      // Create an hundred user
      for ($x = 1; $x <= 100; $x++) {
        $this->dataUser[] = ['id' => $x,
                    'username' => uniqid('user_'),
                    'email' => uniqid().'@mail.com'];

        for ($y = 1; $y <= 10; $y++) {
          $array = [];
          $array = ['user_id' => $x,
                'transaction_detail' => uniqid('Tran_')];

          $this->insertTransaction($array['user_id'], $array['transaction_detail']);
        }   
      }  

      // Save the user to db
      $this->saveToDatabase();   
    }    

    /**
    * insert into Transaction tables 
    */
    public function insertTransaction($user_id, $transaction_detail) {
        $sql = 'INSERT INTO transactions(user_id,transaction_detail) '
                . 'VALUES(:user_id,:transaction_detail)';
 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id,
            ':transaction_detail' => $transaction_detail,
        ]);
 
        return $this->pdo->lastInsertId();
    }

    /**
    * insert into Transaction tables 
    */
    public function getUserTransaction($user_id) {
        $stmt = $this->pdo->query('SELECT user.id as userid, user.username, user.email, transactions.id, transactions.transaction_detail '
                . ' FROM user LEFT JOIN transactions on user.id = transactions.user_id where user.id = ' . $user_id);

        $result = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result[] = [
                'id' => $row['id'],
                'userid' => $row['userid'],
                'username' => $row['username'],
                'email' => $row['email'],
                'transaction_detail' => $row['transaction_detail']
            ];
           
        }
        return $result;
    }
}