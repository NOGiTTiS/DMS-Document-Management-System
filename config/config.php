<?php

// ตั้งค่าฐานข้อมูล (Database Configuration)
define('DB_HOST', 'localhost');      // ที่อยู่ของเซิร์ฟเวอร์ฐานข้อมูล (ปกติคือ localhost)
define('DB_USER', 'root');           // ชื่อผู้ใช้สำหรับเข้าฐานข้อมูล (ของ Laragon คือ root)
define('DB_PASS', '');               // รหัสผ่าน (ของ Laragon จะว่าง)
define('DB_NAME', 'db_dms');         // ชื่อฐานข้อมูลที่เราสร้างไว้

// ตั้งค่า URL หลักของโปรเจค (App Root & URL Root)
// __FILE__ จะได้ path แบบเต็ม C:\laragon\www\DMS\config\config.php
// dirname() จะตัดชื่อไฟล์ออกไปหนึ่งระดับ
define('APPROOT', dirname(dirname(__FILE__))); // จะได้ C:\laragon\www\DMS

// URL Root (สำคัญมากสำหรับการทำลิงก์ในระบบ)
// แก้ไข 'dms' หากคุณตั้งชื่อโปรเจคเป็นอย่างอื่นใน C:\laragon\www
define('URLROOT', 'http://dms.test'); // Laragon จะสร้าง Virtual Host ให้เราอัตโนมัติ

// ชื่อเว็บไซต์
define('SITENAME', 'ระบบสารบรรณอิเล็กทรอนิกส์ (DMS)');