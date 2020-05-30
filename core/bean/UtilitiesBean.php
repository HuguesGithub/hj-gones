<?php
if (!defined('ABSPATH')) {
  die('Forbidden');
}
/**
 * Classe UtilitiesBean
 * @author Hugues
 * @since 1.00.00
 * @version 1.00.00
 */
class UtilitiesBean implements ConstantsInterface
{
  /**
   * @param string $balise
   * @param string $label
   * @param array $attributes
   * @return string
   */
  protected function getBalise($balise, $label='', $attributes=array())
  { return '<'.$balise.$this->getExtraAttributesString($attributes).'>'.$label.'</'.$balise.'>'; }
  /**
   * @param array $attributes
   * @return array
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
   */
  public function getRender($urlTemplate, $args)
  { return vsprintf(file_get_contents(PLUGIN_PATH.$urlTemplate), $args); }
}
