<?php
if ( !defined( 'ABSPATH') ) die( 'Forbidden' );
/**
 * Classe GlobalServices
 * @author Hugues.
 * @version 1.0.00
 * @since 1.0.00
 */
class GlobalServices implements ConstantsInterface {

  /**
   * @param unknown $file
   * @param unknown $line
   * @param unknown $Obj
   *
  public function delete($file, $line, $Obj) { return $this->Dao->delete($file, $line, array($Obj->getId())); }

  /**
   * @param unknown $file
   * @param unknown $line
   * @param unknown $Obj
   *
  public function insert($file, $line, $Obj)
  {
    $res = $this->Dao->insert($file, $line, $this->prepObject($Obj));
    $Obj->setId(MySQL::getLastInsertId());
    return $res;
  }
  public function insertUpdate($file, $line, $Obj) { return $this->Dao->insertUpdate($file, $line, $this->prepObject($Obj)); }

  /**
   * @param unknown $file
   * @param unknown $line
   * @param unknown $Obj
   *
  public function update($file, $line, $Obj) { return $this->Dao->update($file, $line, $this->prepObject($Obj, true)); }

  /**
   * @param unknown $file
   * @param unknown $line
   * @param unknown $id
   *
  public function select($file, $line, $id) { return $this->Dao->select($file, $line, array(_SQL_PARAMS_WHERE_=>array($id))); }

  protected function buildOrderAndLimit($orderBy, $order, $limit=-1) {
    if ( is_array($orderBy) ) {
      $OrderBy = 'ORDER BY ';
      $cpt = 0;
      foreach ( $orderBy as $field ) {
        $OrderBy .= ( $cpt!=0 ? ', ' : '');
        $OrderBy .= $field.( isset($order[$cpt]) ? ' '.$order[$cpt] : ' ASC' );
        $cpt++;
      }
    } elseif ( $order == 'RAND' ) {
      $OrderBy = 'ORDER BY RAND()';
    } else {
      $OrderBy = 'ORDER BY '.$orderBy.' '.$order;
    }
    $Limit = ( $limit<=0 ? '' : 'LIMIT '.$limit );
    return array(_SQL_PARAMS_REPLACE_=>array(_SQL_PARAMS_ORDERBY_=>$OrderBy.' ', _SQL_PARAMS_LIMIT_=>$Limit));
  }

  public function prepObject($Obj, $isUpdate=false) {
    $arr = array();
    $vars = $Obj->getClassVars();
    if ( !empty($vars) ) {
      foreach ( $vars as $key=>$value ) {
        if ( $key=='id' ) { continue; }
        $arr[] = $Obj->getField($key);
      }
      if ( $isUpdate ) { $arr[] = $Obj->getField('id'); }
    }
    return $arr;
  }
  * */
}
?>
