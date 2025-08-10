<?php
class UsersController extends Controller {
    public function __construct(){
        $this->userModel = $this->model('User');
    }

        public function login(){
        // เพิ่ม: ถ้า login อยู่แล้ว ให้ไป dashboard เลย
        if(isset($_SESSION['user_id'])){
            header('location:' . URLROOT . '/dashboard');
            exit();
        }

        // ตรวจสอบว่าเป็น POST request หรือไม่
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // ... โค้ดส่วนที่เหลือเหมือนเดิมทุกประการ ...
            
            // --- ส่วนที่แก้ไข ---
            // Sanitize POST data (ป้องกัน XSS) โดยใช้ htmlspecialchars
            foreach($_POST as $key => $value) {
                $_POST[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            }
            // --- จบส่วนที่แก้ไข ---

            $data = [
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'username_err' => '',
                'password_err' => ''
            ];

            // Validate Username
            if(empty($data['username'])){
                $data['username_err'] = 'กรุณากรอกชื่อผู้ใช้';
            }

            // Validate Password
            if(empty($data['password'])){
                $data['password_err'] = 'กรุณากรอกรหัสผ่าน';
            }

            // ตรวจสอบว่ามีผู้ใช้นี้ในระบบหรือไม่
            if($this->userModel->findUserByUsername($data['username'])){
                // User found
            } else {
                $data['username_err'] = 'ไม่พบชื่อผู้ใช้นี้ในระบบ';
            }

            // ตรวจสอบให้แน่ใจว่าไม่มี Error
            if(empty($data['username_err']) && empty($data['password_err'])){
                // ผ่านการตรวจสอบ, พยายาม Login
                $loggedInUser = $this->userModel->login($data['username'], $data['password']);

                if($loggedInUser){
                    // สร้าง Session
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'รหัสผ่านไม่ถูกต้อง';
                    $this->view('users/login', $data);
                }
            } else {
                // โหลด View พร้อมกับ Error
                $this->view('users/login', $data);
            }

        } else {
            // ถ้าไม่ใช่ POST request ให้โหลดฟอร์มเปล่าๆ
            $data = [
                'username' => '',
                'password' => '',
                'username_err' => '',
                'password_err' => ''
            ];
            $this->view('users/login', $data);
        }
    }

    public function createUserSession($user){
        // session_start() จะถูกเรียกจากไฟล์ bootstrap/index.php
        $_SESSION['user_id'] = $user->user_id;
        $_SESSION['user_username'] = $user->username;
        $_SESSION['user_fullname'] = $user->fullname;
        $_SESSION['user_role'] = $user->role;
        // เมื่อสร้าง session เสร็จ ให้ redirect ไปหน้า dashboard
        header('location:' . URLROOT . '/dashboard');
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_username']);
        unset($_SESSION['user_fullname']);
        unset($_SESSION['user_role']);
        session_destroy();
        header('location:' . URLROOT . '/users/login');
    }
}