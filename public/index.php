<?php
// เริ่ม Session
session_start();

// เรียกใช้งานไฟล์ config
require_once '../config/config.php';

// เรียกใช้งาน Core Libraries
require_once '../app/helpers/role_helper.php';
require_once '../app/helpers/telegram_helper.php'; 
require_once '../app/helpers/session_helper.php';
require_once '../app/helpers/status_helper.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Database.php'; // เพิ่มบรรทัดนี้
require_once '../app/core/App.php';

// สร้าง instance ของ Core App
$init = new App;