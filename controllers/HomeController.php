<?php
namespace controllers;

class HomeController extends Controller {
    public function index() {
        $data = [
            'title' => 'Witamy',
            'description' => 'System zarządzania restauracją'
        ];
        
        $this->render('home/index', $data);
    }
} 