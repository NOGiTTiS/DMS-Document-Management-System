<?php
/*
 * PDO Database Class
 * เชื่อมต่อกับฐานข้อมูล
 * สร้าง Prepared Statements
 * Bind Values
 * คืนค่า Rows และ Results
 */
class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh; // Database Handler
    private $stmt; // Statement
    private $error;

    public function __construct(){
        // ตั้งค่า DSN (Data Source Name)
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = [
            PDO::ATTR_PERSISTENT => true, // การเชื่อมต่อแบบถาวร
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // โหมดการแจ้งเตือน Error
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, // ดึงข้อมูลเป็น Object
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' // ตั้งค่า UTF-8
        ];

        // สร้าง PDO instance
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch(PDOException $e){
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    // เตรียม Statement ด้วย Query
    public function query($sql){
        $this->stmt = $this->dbh->prepare($sql);
    }

    // Bind ค่าต่างๆ
    public function bind($param, $value, $type = null){
        if(is_null($type)){
            switch(true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    // Execute the prepared statement
    public function execute(){
        return $this->stmt->execute();
    }

    // ดึงผลลัพธ์ทั้งหมดเป็น Array of objects
    public function resultSet(){
        $this->execute();
        return $this->stmt->fetchAll();
    }

    // ดึงผลลัพธ์แค่แถวเดียวเป็น Object
    public function single(){
        $this->execute();
        return $this->stmt->fetch();
    }

    // นับจำนวนแถว
    public function rowCount(){
        return $this->stmt->rowCount();
    }
}