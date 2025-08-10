<?php

/*
 * App Core Class
 * สร้าง URL และโหลด Core Controller
 * รูปแบบ URL - /controller/method/params
 */
class App {
    // ตั้งค่า Controller เริ่มต้นให้มี Suffix ด้วย
    protected $currentController = 'HomeController';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct(){
        $url = $this->getURL();

        // มองหา Controller ในโฟลเดอร์ controllers
        // แก้ไข: เพิ่ม 'Controller' ต่อท้ายชื่อไฟล์
        if(isset($url[0]) && file_exists('../app/controllers/' . ucfirst($url[0]) . 'Controller.php')){
            // ถ้าเจอ ก็ให้ตั้งเป็น Controller ปัจจุบัน
            // แก้ไข: เพิ่ม 'Controller' ต่อท้ายชื่อคลาส
            $this->currentController = ucfirst($url[0]) . 'Controller';
            // เอาตัวที่ใช้แล้วออกจาก array
            unset($url[0]);
        }

        // เรียกใช้ไฟล์ Controller
        // แก้ไข: เพิ่ม 'Controller' ต่อท้ายชื่อไฟล์
        require_once '../app/controllers/' . $this->currentController . '.php';

        // สร้าง instance ของ Controller
        $this->currentController = new $this->currentController;

        // ตรวจสอบส่วนที่สองของ URL (Method) - ส่วนนี้ไม่ต้องแก้ไข
        if(isset($url[1])){
            if(method_exists($this->currentController, $url[1])){
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        // ดึงเอา Parameters ที่เหลือ - ส่วนนี้ไม่ต้องแก้ไข
        $this->params = $url ? array_values($url) : [];

        // เรียกใช้งาน method ใน controller พร้อมส่ง params ไปด้วย
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getURL(){
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        return [];
    }
}