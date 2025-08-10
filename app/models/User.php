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
        // เพิ่ม username เข้าไปใน SELECT list
        $sql = 'SELECT user_id, fullname, username, role FROM tbl_users';
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

    // เมธอดสำหรับเพิ่มผู้ใช้ใหม่ (ปรับปรุงจากบทเก่าๆ)
    public function register($data){
        $this->db->query('INSERT INTO tbl_users (username, password, fullname, role) VALUES (:username, :password, :fullname, :role)');
        // Bind values
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':fullname', $data['fullname']);
        $this->db->bind(':role', $data['role']);

        // Execute
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    // เมธอดสำหรับอัปเดตข้อมูลผู้ใช้
    public function updateUser($data){
        // ตรวจสอบว่ามีการส่งรหัสผ่านใหม่มาหรือไม่
        if(!empty($data['password'])){
            $this->db->query('UPDATE tbl_users SET fullname = :fullname, username = :username, password = :password, role = :role WHERE user_id = :id');
            $this->db->bind(':password', $data['password']);
        } else {
            // ถ้าไม่มีรหัสผ่านใหม่ ก็ไม่ต้องอัปเดตคอลัมน์ password
            $this->db->query('UPDATE tbl_users SET fullname = :fullname, username = :username, role = :role WHERE user_id = :id');
        }

        // Bind ค่าที่เหลือ
        $this->db->bind(':id', $data['user_id']);
        $this->db->bind(':fullname', $data['fullname']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':role', $data['role']);

        // Execute
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    // เมธอดสำหรับลบผู้ใช้
    public function deleteUser($id){
        $this->db->query('DELETE FROM tbl_users WHERE user_id = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }
}