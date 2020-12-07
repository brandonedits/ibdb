<?php

    class User {
        private $db;
        
        public function __construct(){
            $this->db = new Database;
        }
        
        // Register User
        public function register($data){
            $this->db->query('INSERT INTO user (name, email, password) VALUES (:name, :email, :password)');
            
            // Bind values
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password', $data['password']);
            
            // Execute fomr db library
            if($this->db->execute()){
                // Everything went OK
                return true;
            } else {
                return false;
            }
        }
        
        // Login User
        public function login($email, $password){
            $this->db->query('SELECT * FROM user WHERE email = :email');
            $this->db->bind(':email', $email);
            
            $row = $this->db->single();
            
            $hashed_password = $row->password;

            if(password_verify($password, $hashed_password)){
                return $row;
            } else {
                return false;
            }
        }
        
        // Find user by email
        public function findUserByEmail($email){
            $this->db->query('SELECT * FROM user WHERE email = :email');
            
            // bind value to email
            $this->db->bind(':email', $email);
            
            $row = $this->db->single();
            
            // Check row
            if($this->db->rowCount() > 0){
                return true;
            } else {
                return false;
            }
        }
        
        // Get User by Id
        public function getUserById($id){
            $this->db->query('SELECT * FROM user WHERE user_id = :id');
            
            // bind value to email
            $this->db->bind(':id', $id);
            
            $row = $this->db->single();
            
            return $row;
        }
    }