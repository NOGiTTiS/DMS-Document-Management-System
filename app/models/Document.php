<?php
class Document {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getAllDocuments(){
        // เราจะ JOIN ตารางเพื่อดึงชื่อผู้สร้างเอกสารมาด้วย
        $this->db->query('
            SELECT 
                tbl_documents.*, 
                tbl_users.fullname as creator_name 
            FROM tbl_documents 
            JOIN tbl_users ON tbl_documents.created_by = tbl_users.user_id
            ORDER BY tbl_documents.created_at DESC
        ');
        
        $results = $this->db->resultSet();
        return $results;
    }

    // เมธอดสำหรับดึงข้อมูลเอกสาร 1 ฉบับตาม ID
    public function getDocumentById($id){
        $this->db->query('SELECT * FROM tbl_documents WHERE doc_id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;
    }

    // เมธอดสำหรับดึงประวัติของเอกสาร
    public function getHistoryByDocId($id){
        $this->db->query('
            SELECT h.*, u_by.fullname as action_by_name, u_to.fullname as action_to_name
            FROM tbl_doc_history h
            JOIN tbl_users u_by ON h.action_by = u_by.user_id
            LEFT JOIN tbl_users u_to ON h.action_to = u_to.user_id
            WHERE h.doc_id = :id
            ORDER BY h.action_at ASC
        ');
        $this->db->bind(':id', $id);
        $results = $this->db->resultSet();
        return $results;
    }

    // เมธอดสำหรับส่งต่อเอกสาร
    public function processDocumentAction($data){
        $this->db->query('START TRANSACTION');

        // 1. อัปเดตสถานะของเอกสารหลัก
        $this->db->query('UPDATE tbl_documents SET status = :status WHERE doc_id = :doc_id');
        $this->db->bind(':status', $data['new_status']);
        $this->db->bind(':doc_id', $data['doc_id']);
        if(!$this->db->execute()){
            $this->db->query('ROLLBACK');
            return false;
        }

        // 2. เพิ่มประวัติการดำเนินการ (History Log)
        // สังเกตว่า action_type และ action_to มาจาก $data ที่ส่งมาจาก Controller
        $this->db->query('INSERT INTO tbl_doc_history (doc_id, action_by, action_to, action_type, comment) VALUES (:doc_id, :action_by, :action_to, :action_type, :comment)');
        $this->db->bind(':doc_id', $data['doc_id']);
        $this->db->bind(':action_by', $data['action_by']);
        $this->db->bind(':action_to', $data['action_to']);
        $this->db->bind(':action_type', $data['action_type']);
        $this->db->bind(':comment', $data['comment']);
        if(!$this->db->execute()){
            $this->db->query('ROLLBACK');
            return false;
        }

        // ถ้าทุกอย่างสำเร็จ
        $this->db->query('COMMIT');
        return true;
    }

    // เมธอดสำหรับเพิ่มเอกสารใหม่ลงฐานข้อมูล
    public function createDocument($data){
        $this->db->query('INSERT INTO tbl_documents (doc_subject, doc_from, doc_number, doc_date, doc_file, created_by) VALUES (:doc_subject, :doc_from, :doc_number, :doc_date, :doc_file, :created_by)');
        
        // Bind values
        $this->db->bind(':doc_subject', $data['doc_subject']);
        $this->db->bind(':doc_from', $data['doc_from']);
        $this->db->bind(':doc_number', $data['doc_number']);
        $this->db->bind(':doc_date', $data['doc_date']);
        $this->db->bind(':doc_file', $data['doc_file']);
        $this->db->bind(':created_by', $data['created_by']);

        // Execute
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function getPendingDocumentsForUser($userId){
        // Query นี้จะเลือกเอกสารที่ยังไม่เสร็จสิ้น และมีประวัติล่าสุด (MAX history_id)
        // ที่มีผู้รับ (action_to) เป็น ID ของผู้ใช้ปัจจุบัน
        $this->db->query("
            SELECT d.* FROM tbl_documents d
            WHERE 
                d.status NOT IN ('completed', 'rejected') AND
                d.doc_id IN (
                    SELECT h.doc_id 
                    FROM tbl_doc_history h
                    WHERE h.history_id = (
                        SELECT MAX(h2.history_id) 
                        FROM tbl_doc_history h2 
                        WHERE h2.doc_id = h.doc_id
                    ) AND h.action_to = :user_id
                )
            ORDER BY d.created_at DESC
        ");

        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    public function getDocumentsStats(){
        $this->db->query("
            SELECT
                (SELECT COUNT(*) FROM tbl_documents WHERE DATE(created_at) = CURDATE()) as today_in,
                (SELECT COUNT(*) FROM tbl_documents WHERE status = 'completed' AND DATE(created_at) = CURDATE()) as today_out, /* สมมติว่า completed คือส่งออก */
                (SELECT COUNT(*) FROM tbl_documents) as total_docs
        ");
        return $this->db->single();
    }
}