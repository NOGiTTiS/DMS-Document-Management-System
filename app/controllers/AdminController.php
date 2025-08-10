<?php
class AdminController extends Controller {

    public function __construct(){
        // --- Security Check ---
        // ตรวจสอบว่า Login หรือยัง
        if(!isset($_SESSION['user_id'])){
            header('location:' . URLROOT . '/users/login');
            exit();
        }
        // ตรวจสอบว่าเป็น Admin หรือไม่
        if($_SESSION['user_role'] != 'admin'){
            set_flash_message('doc_message', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้', 'error');
            header('location:' . URLROOT . '/dashboard');
            exit();
        }
        
        // โหลด Model ที่จำเป็น
        $this->userModel = $this->model('User');
    }

    // เมธอดหลักสำหรับแสดงรายชื่อผู้ใช้
    public function index(){
        $users = $this->userModel->getAllUsers();

        $data = [
            'title' => 'จัดการผู้ใช้งาน',
            'users' => $users
        ];
        $this->layout('main', 'admin/users/index', $data);
    }

    public function addUser(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'fullname' => trim($_POST['fullname']),
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'role' => trim($_POST['role']),
                // สามารถเพิ่ม validation error handling ได้ที่นี่
            ];
            
            // Hash Password
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            // ตรวจสอบว่ามี username นี้หรือยัง
            if($this->userModel->findUserByUsername($data['username'])){
                // จัดการ error
                set_flash_message('doc_message', 'Username นี้มีผู้ใช้งานแล้ว', 'error');
                $this->layout('main', 'admin/users/add', ['title' => 'เพิ่มผู้ใช้ใหม่']);
            } else {
                if($this->userModel->register($data)){
                    set_flash_message('doc_message', 'เพิ่มผู้ใช้งานใหม่สำเร็จ');
                    header('location: ' . URLROOT . '/admin');
                    exit();
                } else {
                    die('Something went wrong');
                }
            }

        } else {
            $data = [
                'title' => 'เพิ่มผู้ใช้ใหม่'
            ];
            $this->layout('main', 'admin/users/add', $data);
        }
    }

    public function editUser($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Sanitize POST
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'user_id' => $id,
                'fullname' => trim($_POST['fullname']),
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'role' => trim($_POST['role']),
            ];

            // ตรวจสอบว่ามีการกรอกรหัสผ่านใหม่หรือไม่
            if(!empty($data['password'])){
                // ถ้ามี ให้ Hash รหัสผ่านใหม่
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            } else {
                // ถ้าไม่มี ให้ใช้ค่าว่าง เพื่อให้ Model รู้ว่าไม่ต้องอัปเดต
                $data['password'] = '';
            }

            // เรียก Model เพื่ออัปเดตข้อมูล
            if($this->userModel->updateUser($data)){
                set_flash_message('doc_message', 'อัปเดตข้อมูลผู้ใช้งานสำเร็จ');
                header('location: ' . URLROOT . '/admin');
                exit();
            } else {
                die('Something went wrong');
            }

        } else {
            // ดึงข้อมูลผู้ใช้จาก Model
            $user = $this->userModel->findUserById($id);

            // ป้องกันไม่ให้ admin อื่นแก้ข้อมูล admin คนอื่น (ยกเว้นตัวเอง)
            // หรือถ้าไม่ใช่ admin ก็แก้ไม่ได้เลย
            if($user->role == 'admin' && $user->user_id != $_SESSION['user_id']){
                 set_flash_message('doc_message', 'คุณไม่มีสิทธิ์แก้ไขข้อมูลผู้ดูแลระบบคนอื่น', 'error');
                 header('location: ' . URLROOT . '/admin');
                 exit();
            }

            $data = [
                'title' => 'แก้ไขข้อมูลผู้ใช้',
                'user' => $user
            ];
            $this->layout('main', 'admin/users/edit', $data);
        }
    }

    public function deleteUser($id){
        // ป้องกันไม่ให้ผู้ใช้ลบตัวเอง
        if($id == $_SESSION['user_id']){
            set_flash_message('doc_message', 'คุณไม่สามารถลบบัญชีของตัวเองได้', 'error');
            header('location: ' . URLROOT . '/admin');
            exit();
        }

        // ตรวจสอบว่าเป็น POST request เพื่อความปลอดภัย (ป้องกันการลบผ่าน URL)
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if($this->userModel->deleteUser($id)){
                set_flash_message('doc_message', 'ลบผู้ใช้งานสำเร็จ');
                header('location: ' . URLROOT . '/admin');
                exit();
            } else {
                die('Something went wrong');
            }
        } else {
            // ถ้าไม่ใช่ POST ให้ redirect กลับ
            header('location: ' . URLROOT . '/admin');
            exit();
        }
    }
}