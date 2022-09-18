<?php
    namespace App\Model;

    use App\Database\Database;
    use Exception;
    
    include $_SERVER['DOCUMENT_ROOT'] . '/app/database/database.php';
    
    // User class
    class User {
        // User fields 
        private string $login; // Unique
        private string $password;
        private string $email; // Unique
        private string $sault;
        private string $name;
        // Database object 
        private Database $data_base;
        // User class constructor
        public function __construct()
        {
            $this->data_base = new Database();
        }

        //
        //  MAIN FUNCTIONAL
        //

        // Register user. Return json object
        public function register(): ?array {
            if (isset($this->login) == false) {
                throw new Exception("Login data is not filled out");
            } elseif (isset($this->password) == false) {
                throw new Exception("Password data is not filled out");
            } elseif (isset($this->email) == false) {
                throw new Exception("Email data is not filled out");
            } elseif (isset($this->name) == false) {
                throw new Exception("Name data is not filled out");
            } elseif ($this->isLoginExist()) {
                throw new Exception("A user with such an login exists");
            } elseif ($this->isEmailExist()) {
                throw new Exception("A user with such an email exists");
            } else {
                $this->sault = $this->generateSault();

                $user = [
                    "login" => $this->login,
                    "password" => $this->generatePasswordHash(),
                    "sault" => $this->sault,
                    "email" => $this->email,
                    "name" => $this->name
                ];

                $result = $this->data_base->insert("users", array($user));

                if(count($result)) {
                    return $this->getUserJSON();
                }
            }

            return null;
        }
        // Authorize user. Return json object
        public function login(): ?array {
            if (isset($this->login) == false) {
                throw new Exception("Login data is not filled out");
            } elseif (isset($this->password) == false) {
                throw new Exception("Password data is not filled out");
            } elseif ($this->isLoginExist() == false) {
                throw new Exception("The user with such a login is not registered");
            } else {
                $user = array_shift($this->data_base->select("users", false, "login", $this->login));
                $this->sault = $user["sault"];
                $this->email = $user["email"];
                $this->name = $user["name"];

                if($this->generatePasswordHash() != $user["password"]) {
                    throw new Exception("Invalid password");
                }

                return $this->getUserJSON();
            }

            return null;
        }

        //
        //  ADDITIONAL FUNCTIONAL
        //

        // Checks whether the user with the login in the database exists
        private function isLoginExist(): bool 
        {
            $result = $this->data_base->select("users", false, "login", $this->login);

            if(count($result)) return true;

            return false;
        }
        // Checks whether the user with the email in the database exists
        private function isEmailExist(): bool 
        {
            $result = $this->data_base->select("users", false, "email", $this->email);

            if(count($result)) return true;

            return false;
        }
        // Function of salt generation for password
        private function generateSault(): string 
        {
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            return substr(str_shuffle($permitted_chars), 0, 16);
        }
        // Generate password hash with sault
        private function generatePasswordHash(): string 
        {
            return sha1($this->sault . $this->password);
        }

        //
        // GETTERS & SETTERS
        //

        // Login getter
        public function getLogin(): string
        {
            return $this->login;
        }
        // Login setter
        public function setLogin($value) 
        {
            $regular = "/^[0-9a-zA-Z]{6,}$/";

            if (isset($value) == false || is_string($value) == false) {
                throw new Exception("Login isn't string");
            } elseif (preg_match($regular, $value) == false) {
                throw new Exception("Login isn't valid");
            } else {
                $this->login = $value;
            }
        }
        // Password getter
        public function getPassword(): string
        {
            return $this->password;
        }
        // Password setter
        public function setPassword($value) 
        {
            $regular = "/^[0-9a-zA-Z]{6,}$/";

            if (isset($value) == false || is_string($value) == false) {
                throw new Exception("Password isn't string");
            } elseif (
                preg_match($regular, $value) == false ||
                preg_match("/\d/", $value) == false ||
                preg_match("/[A-Za-z]/", $value) == false                
            ) {
                throw new Exception("Password isn't valid");
            } else {
                $this->password = $value;
            }
        }
        // Email getter
        public function getEmail(): string
        {
            return $this->email;
        }
        // Email setter
        public function setEmail($value) 
        {
            $regular = "/^[\w]{1}[\w\-\.]*@[\w\-]+\.[a-z]{2,4}$/i";

            if (isset($value) == false || is_string($value) == false) {
                throw new Exception("Email isn't string");
            } elseif (preg_match($regular, $value) == false) {
                throw new Exception("Email isn't valid");
            } else {
                $this->email = $value;
            }
        }
        // Name getter
        public function getName(): string
        {
            return $this->name;
        }
        // Name setter
        public function setName($value) 
        {
            $regular = "/^[A-Za-zа-яА-Я]{2,30}$/u";
            if (isset($value) == false || is_string($value) == false) {
                throw new Exception("Name isn't string");
            } elseif (preg_match($regular, $value) == false) {
                throw new Exception("Name isn't valid");
            } else {
                $this->name = $value;
            }
        }
        // Get user as JSON object
        public function getUserJSON(): array {
            return [
                "login" => $this->login,
                "password" => $this->password,
                "email" => $this->email,
                "name" => $this->name
            ];
        }
    }
?>