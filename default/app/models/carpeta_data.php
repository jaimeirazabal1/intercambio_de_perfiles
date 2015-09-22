<?php 
class CarpetaData extends ActiveRecord{
	public function ingresar_a_carpeta($id_carpeta, $data){
		foreach ($data as $key => $value) {
			$c = new CarpetaData();
			$c->carpeta_id = $id_carpeta;
			$c->data_id = $value->id;
			$c->objeto_json = json_encode($value);
			if(!$c->save()){
				$errores[] = $value;
			}
		}
		if (isset($errores)) {
			return $errores;
		}
		return true;
	}
	public function getByCarpetaId($id){
		return $this->find("conditions: carpeta_id = '$id'","join: inner join carpeta on carpeta_data.carpeta_id = carpeta_id inner join data on data.id = carpeta_data.data_id","order: data.pais asc","columns: data.*");
	}
}


 ?>