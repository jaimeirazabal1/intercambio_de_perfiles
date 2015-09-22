<?php 
class Carpeta extends ActiveRecord{
	public function nueva_carpeta($nombre_carpeta){
		$carpeta_nueva = new Carpeta();
		$carpeta_nueva->nombre = $nombre_carpeta;
		$carpeta_nueva->usuario_id = Auth::get("id");
		return $carpeta_nueva->save();
	}
	public function get_carpetas_by_user_id($id){
		$query = "SELECT carpeta.id as carpeta_id,
						 carpeta.nombre as carpeta_nombre,
						 carpeta.created as carpeta_created, 
						 usuario.id as usuario_id,
						 usuario.login as usuario_login,
						 carpeta_data.created as carpeta_data_created,
						 data.*
						 from carpeta 
						 INNER JOIN usuario on usuario.id = carpeta.usuario_id
						 INNER JOIN carpeta_data on carpeta_data.carpeta_id = carpeta.id
						 INNER JOIN data on carpeta_data.data_id = `data`.`id`
						 WHERE carpeta.usuario_id = '$id'
						 order by carpeta_nombre asc";

		$results = $this->find_all_by_sql($query);
		return $results;

	}
	public function get_nombre_carpetas_by_user_id($id){
		return $this->find("conditions: usuario_id = '".$id."' ");
	}
}


 ?>