<?php
/*
 * Base Controller
 * โหลด Models และ Views
 */
class Controller {
    // โหลด Model
    public function model($model){
        require_once APPROOT . '/app/models/' . $model . '.php';
        return new $model();
    }

    // โหลด View (แบบเดิม)
    public function view($view, $data = []){
        if(file_exists(APPROOT . '/app/views/' . $view . '.php')){
            require_once APPROOT . '/app/views/' . $view . '.php';
        } else {
            die('View does not exist');
        }
    }

    // *** เพิ่มเมธอดใหม่ ***
    // โหลด Layout หลัก พร้อมส่ง View ที่ต้องการและข้อมูลไปให้
    public function layout($layout, $view, $data = []){
        $view_path = APPROOT . '/app/views/' . $view . '.php';
        
        // ตรวจสอบว่ามีไฟล์ layout และ view อยู่จริง
        if(file_exists(APPROOT . '/app/views/layouts/' . $layout . '.php') && file_exists($view_path)){
            // เรียกใช้ไฟล์ layout ซึ่งข้างในจะเรียกใช้ $view_path อีกที
            require_once APPROOT . '/app/views/layouts/' . $layout . '.php';
        } else {
            die('Layout or View does not exist');
        }
    }
}