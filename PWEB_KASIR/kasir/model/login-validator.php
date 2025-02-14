<?php

class LoginValidator {
    public $role;
    public $login_status;
    private $database;

    /**
     * Mencari koneksi database
     * 
     * @param mysqli $database
     * @return mysqli
     */
    public function __construct(mysqli $database)
    {
        $this->database = $database;
    }

    /**
     * Validasi login dengan username dan password
     *
     * @param String $username
     * @param String $password
     * @return bool
     */
    public function validate(String $username, String $password)
    {
        try
        {
            if (isset($username) && $password)
            {
                $username = trim($username);
                $password = trim($password);
    
                $sql = "SELECT username, password, peran FROM staff_kasir WHERE username = ?";
                $stmt = $this->database->prepare($sql);
    
                if ($stmt) {
    
                    $stmt->bind_param('s', $username);
                    $stmt->execute();
                    $result = $stmt->get_result();
    
                    if ($result->num_rows === 1) {
                        $user = $result->fetch_assoc();
    
                        if (password_verify($password, $user['password'])) {
                            $this->login_status = true;
                            $_SESSION['role'] = $user['peran'];
                            $_SESSION['login'] = $this->login_status;
                            $_SESSION['username'] = $user['username'];

                            return true;
    
                        }
                    } else {
                        $this->login_status = false;
                        $_SESSION['login_err'] = $this->login_status;

                        return false;
                    }
    
                    $stmt->close();
                }
            }
        } catch(Exception $e) {
            return $e;
        }
        
    }

    /**
     * true jika user telah login false jika belum
     *
     * @param array $session - sesi dari session_start
     * @return bool
     */
    public function check_login_status(String $session)
    {
        try
        {
            if (!isset($_SESSION[$session]) || !$_SESSION[$session]) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) { 
            return $e;
        }
    }
}