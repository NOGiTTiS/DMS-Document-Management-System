<?php
class HomeController extends Controller {
    public function __construct(){
        
    }

    public function index(){
        if(isset($_SESSION['user_id'])){
            header('location: ' . URLROOT . '/dashboard');
            exit();
        } else {
            header('location: ' . URLROOT . '/users/login');
            exit();
        }
    }
}