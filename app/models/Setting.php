<?php
class Setting {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    // เมธอดสำหรับดึงค่า Setting ทั้งหมด
    public function getAllSettings(){
        $this->db->query('SELECT * FROM tbl_settings');
        $results = $this->db->resultSet();
        
        // แปลง array of objects ให้เป็น associative array (key => value)
        $settings_assoc = [];
        foreach ($results as $row) {
            $settings_assoc[$row->setting_key] = $row->setting_value;
        }
        return $settings_assoc;
    }

    // เมธอดสำหรับอัปเดตค่า Setting
    public function updateSetting($key, $value){
        $this->db->query('UPDATE tbl_settings SET setting_value = :value WHERE setting_key = :key');
        $this->db->bind(':key', $key);
        $this->db->bind(':value', $value);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }
}