<?php

/**
 * @author Assidi
 * @copyright 2017
 */
 
 // класс приложения, содержит всякие полезные функции вроде авторизации  
class app {
    // функция проверяет,вошел ли пользователь под логином администратора 
    public static function isAdmin($login = false, $password = false) {
		if (!$login) $login = isset($_SESSION["login"])? $_SESSION["login"] : false;
		if (!$password) $password = isset($_SESSION["password"])? $_SESSION["password"] : false;
		return mb_strtolower($login) === mb_strtolower(ADM_LOGIN) && $password === ADM_PASSWORD;
	}  
    
    // функция для входа 
    public static function login($login, $password) {
		$password = md5($password);
		if (self::isAdmin($login, $password)) {
			$_SESSION["login"] = $login;
			$_SESSION["password"] = $password;
			return true;
		}
		return false;
	}   
    
    // функция для выхода
    public static function logout() {
         unset($_SESSION["login"]);
         unset($_SESSION["password"]);
    }   
}


?>