<?php
class User {
    private $db;

    //va a manejar todo lo relacionado con los usuarios.
    public function __construct($database) {
        $this->db = $database;
    }

    public function register($name, $email, $password, $role) {
        $hash = password_hash($password, PASSWORD_DEFAULT);//Hashea la contraseña por seguridad
        $query = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);// para evitar ataques de inyección SQL.
        return $stmt->execute([$name, $email, $hash, $role]);
    }

    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");//Busca un usuario por su email.
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) //Verifica si la contraseña es correcta con{
            return $user;//Si todo va bien, retorna la información del usuario.
        }
        return false;
    }

?>
