<?php
require_once 'config/database.php';

/**
 * User model for handling user-related operations
 */
class User {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }

    /**
     * Register a new user
     * @param string $username
     * @param string $email
     * @param string $password
     * @param string $role
     * @return bool
     */
    public function register($username, $email, $password, $role = 'user') {
        $username = $this->conn->real_escape_string($username);
        $email = $this->conn->real_escape_string($email);
        $password = password_hash($password, PASSWORD_BCRYPT);
        $role = in_array($role, ['user', 'admin']) ? $role : 'user';
        $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
        return $this->conn->query($sql);
    }

    /**
     * Authenticate user
     * @param string $username
     * @param string $password
     * @return array|null
     */
    public function login($username, $password) {
        $username = $this->conn->real_escape_string($username);
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return null;
    }

    /**
     * Generate password reset code
     * @param string $email
     * @return string|null
     */
    public function generateResetCode($email) {
        $email = $this->conn->real_escape_string($email);
        $code = sprintf("%06d", mt_rand(0, 999999)); // 6-значный код
        $sql = "UPDATE users SET reset_code = '$code' WHERE email = '$email'";
        if ($this->conn->query($sql) && $this->conn->affected_rows > 0) {
            return $code;
        }
        return null;
    }

    /**
     * Verify reset code and reset password
     * @param string $email
     * @param string $code
     * @param string $newPassword
     * @return bool
     */
    public function resetPassword($email, $code, $newPassword) {
        $email = $this->conn->real_escape_string($email);
        $code = $this->conn->real_escape_string($code);
        $sql = "SELECT * FROM users WHERE email = '$email' AND reset_code = '$code'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $newPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $sql = "UPDATE users SET password = '$newPassword', reset_code = NULL WHERE email = '$email'";
            return $this->conn->query($sql);
        }
        return false;
    }

    /**
     * Get all users
     * @return array
     */
    public function getAll() {
        $sql = "SELECT id, username, email, role, created_at FROM users";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>