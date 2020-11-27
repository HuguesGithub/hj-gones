<?php
if (!defined('ABSPATH')) {
  die('Forbidden');
}
/**
 * Classe UtilitiesBean
 * @author Hugues
 * @version 1.00.00
 * @since 1.00.00
 */
class UtilitiesBean implements ConstantsInterface
{
  /**
   * @param string $balise
   * @param string $label
   * @param array $attributes
   * @return string
   * @version 1.00.00
   * @since 1.00.00
   */
  protected function getBalise($balise, $label='', $attributes=array())
  {
    if (in_array($balise, array(self::TAG_INPUT))) {
      return '<'.$balise.$this->getExtraAttributesString($attributes).'>';
    } else {
      return '<'.$balise.$this->getExtraAttributesString($attributes).'>'.$label.'</'.$balise.'>';
    }
  }
  /**
   * @param array $attributes
   * @return array
   * @version 1.00.00
   * @since 1.00.00
   */
  private function getExtraAttributesString($attributes)
  {
    $extraAttributes = '';
    if (!empty($attributes)) {
      foreach ($attributes as $key => $value) {
        $extraAttributes .= ' '.$key.'="'.$value.'"';
      }
    }
    return $extraAttributes;
  }
  /**
   * @param string $urlTemplate
   * @param array $args
   * @return string
   * @version 1.00.00
   * @since 1.00.00
   */
  public function getRender($urlTemplate, $args)
  { return vsprintf(file_get_contents(PLUGIN_PATH.$urlTemplate), $args); }
  /**
   * @param mixed $selectedId
   * @param string $label
   * @return string
   * @version 1.00.00
   * @since 1.00.00
   */
  protected function getDefaultOption($selectedId=-1, $label=self::CST_DEFAULT_SELECT)
  {
    $args = array(self::ATTR_VALUE => '');
    if ($selectedId==-1) {
      $args[self::ATTR_SELECTED] = self::CST_SELECTED;
    }
    return $this->getBalise(self::TAG_OPTION, $label, $args);
  }
  /**
   * @param string $label
   * @param mixed $valueId
   * @param string $selectedId
   * @return string
   * @version 1.00.00
   * @since 1.00.00
   */
  protected function getLocalOption($label, $valueId, $selectedId)
  {
    $attributes = array(self::ATTR_VALUE=>$valueId);
    if ($selectedId==$valueId) {
      $attributes[self::ATTR_SELECTED] = self::CST_SELECTED;
    }
    return $this->getBalise(self::TAG_OPTION, $label, $attributes);
  }

}
