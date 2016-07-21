<?php 

class usuarios {
	public $id;
	function POST_id() {
		return $this->id;
	}
	function set_id($id) {
		$this->id = $id;
	}
	public $usuario;
	function POST_usuario() {
		return $this->usuario;
	}
	function set_usuario($usuario) {
		$this->usuario = $usuario;
	}
	public $contrasena;
	function POST_contrasena() {
		return $this->contrasena;
	}
	function set_contrasena($contrasena) {
		$this->contrasena = $contrasena;
	}
}




?>