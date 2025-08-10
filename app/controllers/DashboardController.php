<?php
class DashboardController extends Controller {
    public function __construct(){
        if(!isset($_SESSION['user_id'])){
            header('location:' . URLROOT . '/users/login');
            exit();
        }
        // โหลด Model ที่ต้องใช้
        $this->documentModel = $this->model('Document');
    }

    public function index(){
        $pendingDocs = $this->documentModel->getPendingDocumentsForUser($_SESSION['user_id']);
        $stats = $this->documentModel->getDocumentsStats(); // <--- เพิ่ม

        $data = [
            'title' => 'ภาพรวมระบบ',
            'pending_count' => count($pendingDocs),
            'stats' => $stats // <--- ส่งไปให้ View
        ];
        $this->layout('main', 'dashboard/index', $data);
    }
}