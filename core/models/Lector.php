<?php

# Seguridad
defined('INDEX_DIR') OR exit('Ocrend software says .i.');

//------------------------------------------------

final class Lector extends Models implements OCREND {

  public function __construct() {
    parent::__construct();
  }

  # Control de errores

  final private function errores(array $data) {
    try {

      /* if(Func::emp($data['ejemplo'])) {
        throw new Exception('Error campo vacío.');
        } */

      return false;
    } catch (Exception $e) {
      return array('success' => 0, 'message' => $e->getMessage());
    }
  }

  # Crear un elemento

  final public function crear(array $data): array {
    $error = $this->errores($data);
    if (false !== $error) {
      return $error;
    }

    $i = array(
        'cedula' => $data['cedula'],
        'nombre' => $data['nombre'],
        'apellido' => $data['apellido'],
        'estado' => $data['estado']
    );
    $this->db->insert('lector', $i);
    return array('success' => 1, 'message' => '<b>Creado</b> con éxito.');
  }

  # Editar un elemento

  final public function editar(array $data): array {

    $this->id = $this->db->scape($data['id']);

    $error = $this->errores($data);
    if (false !== $error) {
      return $error;
    }

    $i = array(
        'cedula' => $data['cedula'],
        'nombre' => $data['nombre'],
        'apellido' => $data['apellido'],
        'estado' => $data['estado']
    );
    $this->db->update('lector', $i, "id='$this->id'", 'LIMIT 1');

    return array('success' => 1, 'message' => '<b>Editado</b> con éxito.');
  }

  # Borrar un elemento

  final public function borrar() {
    $this->db->delete('lector', "id='$this->id'");
    Func::redir(URL . 'lector/');
  }

  # Leer uno o todos los elementos

  final public function leer(bool $multi = true) {
    if ($multi) {
      return $this->db->select('*', 'lector');
    }

    return $this->db->select('*', 'lector', "id='$this->id'");
  }

  public function __destruct() {
    parent::__destruct();
  }

}

?>
