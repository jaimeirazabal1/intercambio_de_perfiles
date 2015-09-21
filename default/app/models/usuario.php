<?php 
class Usuario extends ActiveRecord{
	public function registrar_nuevo($login, $password){
		$password = $this->encriptar_password($password);
		$u = new Usuario();
		$u->login = $login;
		$u->password = $password;
		return $u->save();
	}
	public function encriptar_password($password){
		return md5($password);
	}
}

 ?>