<?php
class User {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    // ค้นหาผู้ใช้ด้วย Username
    public function findUserByUsername($username){
        $this->db->query('SELECT * FROM tbl_users WHERE username = :username');
        // Bind value
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        // ตรวจสอบว่ามีแถวข้อมูลหรือไม่
        if($this->db->rowCount() > 0){
            return $row;
        } else {
            return false;
        }
    }

    public function login($username, $password){
        $row = $this->findUserByUsername($username);

        if($row === false){
            return false;
        }

        $hashed_password = $row->password;
        if(password_verify($password, $hashed_password)){
            return $row; // คืนค่าข้อมูล user ทั้งหมดถ้า password ถูก
        } else {
            return false;
        }
    }

    // เมธอดสำหรับดึงรายชื่อผู้ใช้ทั้งหมด (ยกเว้นตัวเอง)
    public function getAllUsers($excludeUserId = null){
        $sql = 'SELECT user_id, fullname, role FROM tbl_users';
        if ($excludeUserId) {
            $sql .= ' WHERE user_id != :exclude_id';
        }
        $this->db->query($sql);
        if ($excludeUserId) {
            $this->db->bind(':exclude_id', $excludeUserId);
        }
        return $this->db->resultSet();
    }

    public function findUserById($id){
        $this->db->query('SELECT * FROM tbl_users WHERE user_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
}