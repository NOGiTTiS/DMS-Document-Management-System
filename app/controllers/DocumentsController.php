<?php
class DocumentsController extends Controller {

    public function __construct(){
        // ตรวจสอบ Session ถ้าไม่ login ให้เด้งกลับ
        if(!isset($_SESSION['user_id'])){
            header('location:' . URLROOT . '/users/login');
            exit();
        }
        // โหลด Model ที่จะใช้
        $this->documentModel = $this->model('Document');
        $this->userModel = $this->model('User');
    }

    // เมธอดสำหรับแสดงรายการเอกสารทั้งหมด
    public function index(){
        $documents = $this->documentModel->getAllDocuments();
        $data = [
            'title' => 'รายการหนังสือเข้า',
            'documents' => $documents
        ];
        $this->layout('main', 'documents/index', $data);
    }

    // เมธอดสำหรับแสดงรายการเอกสารรอพิจารณา
    public function pending(){
        $documents = $this->documentModel->getPendingDocumentsForUser($_SESSION['user_id']);
        $data = [
            'title' => 'เอกสารรอพิจารณา',
            'documents' => $documents
        ];
        $this->layout('main', 'documents/index', $data);
    }

    // เมธอดสำหรับแสดงรายละเอียดเอกสาร 1 ฉบับ
    public function show($id){
        $document = $this->documentModel->getDocumentById($id);
        $history = $this->documentModel->getHistoryByDocId($id);
        $users = $this->userModel->getAllUsers($_SESSION['user_id']);

        $data = [
            'title' => 'รายละเอียดเอกสาร',
            'document' => $document,
            'history' => $history,
            'users' => $users
        ];
        $this->layout('main', 'documents/show', $data);
    }

    // เมธอดสำหรับแสดงและจัดการฟอร์มสร้างเอกสาร
    public function create(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // จัดการการอัปโหลดไฟล์
            $newFilename = "";
            if(isset($_FILES["doc_file"]) && $_FILES["doc_file"]["error"] == 0){
                $target_dir = "uploads/";
                $newFilename = time() . '_' . basename($_FILES["doc_file"]["name"]);
                $target_file = $target_dir . $newFilename;

                if (!move_uploaded_file($_FILES["doc_file"]["tmp_name"], $target_file)) {
                    set_flash_message('doc_message', 'ขออภัย, เกิดข้อผิดพลาดในการอัปโหลดไฟล์', 'error');
                    header('location:' . URLROOT . '/documents/create');
                    exit();
                }
            } else {
                set_flash_message('doc_message', 'กรุณาแนบไฟล์เอกสาร', 'error');
                header('location:' . URLROOT . '/documents/create');
                exit();
            }

            // Sanitize POST data
            foreach($_POST as $key => $value) {
                $_POST[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            }
            $data = [
                'doc_number' => trim($_POST['doc_number']),
                'doc_date' => trim($_POST['doc_date']),
                'doc_from' => trim($_POST['doc_from']),
                'doc_subject' => trim($_POST['doc_subject']),
                'doc_file' => $newFilename,
                'created_by' => $_SESSION['user_id'],
            ];

            if($this->documentModel->createDocument($data)){
                set_flash_message('doc_message', 'บันทึกเอกสารใหม่เรียบร้อยแล้ว');
                header('location:' . URLROOT . '/documents');
                exit();
            } else {
                set_flash_message('doc_message', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
                header('location:' . URLROOT . '/documents/create');
                exit();
            }
        } else {
            $data = ['title' => 'ลงรับหนังสือภายนอก (เข้า)'];
            $this->layout('main', 'documents/create', $data);
        }
    }

    // --- Action Methods ---
    public function forward($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data = $this->prepareActionData($id, 'forward');
            if(empty($data['action_to'])){
                 set_flash_message('doc_message', 'กรุณาเลือกผู้รับที่จะส่งต่อ', 'error');
                 $this->redirectToShowPage($id);
            }
            if($this->documentModel->processDocumentAction($data)){

                $settings = $this->settingModel->getAllSettings();
                $botToken = $settings['telegram_bot_token'] ?? null;
                
                // ส่งข้อความไปยัง Telegram
                $receiver = $this->userModel->findUserById($data['action_to']);
                if($receiver && !empty($receiver->telegram_chat_id)){
                    $doc = $this->documentModel->getDocumentById($id);
                    $senderName = $_SESSION['user_fullname'];

                    $message = "🔔 <b>แจ้งเตือนเอกสารใหม่</b>\n\n";
                    $message .= "<b>เรื่อง:</b> " . htmlspecialchars($doc->doc_subject) . "\n";
                    $message .= "<b>จาก:</b> " . htmlspecialchars($senderName) . "\n\n";
                    $message .= "<i>" . htmlspecialchars($data['comment']) . "</i>\n\n";
                    $message .= "คลิกเพื่อดูเอกสาร: " . URLROOT . "/documents/show/" . $id;

                    sendTelegramMessage($botToken, $receiver->telegram_chat_id, $message);
                }
                // --- จบส่วนที่เพิ่ม ---
                set_flash_message('doc_message', 'ส่งต่อเอกสารเรียบร้อยแล้ว');
                $this->redirectToShowPage($id);
            } else {
                die('Something went wrong during forwarding.');
            }
        }
    }

    public function approve($id){
         if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data = $this->prepareActionData($id, 'approve');
            if($this->documentModel->processDocumentAction($data)){
                set_flash_message('doc_message', 'อนุมัติเอกสารเรียบร้อยแล้ว');
                $this->redirectToShowPage($id);
            } else {
                die('Something went wrong during approval.');
            }
        }
    }

    public function reject($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $history = $this->documentModel->getHistoryByDocId($id);
            $last_sender_id = end($history)->action_by;
            $data = $this->prepareActionData($id, 'reject', $last_sender_id);
            
            if($this->documentModel->processDocumentAction($data)){
                set_flash_message('doc_message', 'ตีกลับเอกสารเรียบร้อยแล้ว', 'warning');
                $this->redirectToShowPage($id);
            } else {
                die('Something went wrong during rejection.');
            }
        }
    }

    // --- Helper Methods ---
    private function prepareActionData($doc_id, $action_type, $force_action_to = null){
        foreach($_POST as $key => $value) {
            $_POST[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
        $action_to = $force_action_to ?? (!empty(trim($_POST['action_to_id'])) ? trim($_POST['action_to_id']) : null);
        
        $new_status = $this->documentModel->getDocumentById($doc_id)->status;

        if($action_type == 'forward' && $action_to != null){
            $receiver = $this->userModel->findUserById($action_to);
            if($receiver){
                $new_status = 'pending_' . $receiver->role;
            }
        } elseif ($action_type == 'approve') {
            $new_status = 'completed';
        } elseif ($action_type == 'reject') {
            $new_status = 'rejected';
        }
        
        return [
            'doc_id' => $doc_id,
            'comment' => trim($_POST['comment']),
            'action_by' => $_SESSION['user_id'],
            'action_to' => $action_to,
            'action_type' => $action_type,
            'new_status' => $new_status
        ];
    }

    private function redirectToShowPage($id){
        header('location:' . URLROOT . '/documents/show/' . $id);
        exit();
    }
}