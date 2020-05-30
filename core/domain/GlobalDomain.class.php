<?php
if ( !defined( 'ABSPATH') ) die( 'Forbidden' );
/**
 * Classe GlobalDomain
 * @author Hugues.
 * @version 1.0
 * @since 1.0
 */
class GlobalDomain implements ConstantsInterface {

  public function __construct($attributes=array()) {
    if (!empty($attributes)) {
      foreach ($attributes as $key=>$value) {
        $this->setField($key, $value);
      }
    }
  }

// TODO : Et si la property n'existe pas, on loggue ou pas ?
  public function setField($key, $value) { if (property_exists($this, $key)) { $this->{$key} = $value; } }
  public function getField($key) { return (property_exists($this, $key) ? $this->{$key} : null); }

  public static function convertRootElement($Obj, $row) {
    $vars = $Obj::getClassVars();
    if (!empty($vars)) {
      foreach ($vars as $key=>$value) {
        $Obj->setField($key, $row->{$key});
      }
    }
    return $Obj;
  }

  protected function isAdmin() { return current_user_can('manage_options'); }

}
?>
