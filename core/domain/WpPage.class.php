<?php
if (!defined('ABSPATH')) {
  die('Forbidden');
}
/**
 * Classe WpPage
 * @author Hugues
 * @version 1.1.00
 * @since 1.1.00
 */
class WpPage extends WpPost
{
  public function __construct($id=0)
  {
    $post = get_post($id);
    $attributes = $this->getClassVars();
    foreach ($attributes as $attribute=>$value) {
      $this->{$attribute} = $post->{$attribute};
    }
    $this->WpPostServices = new WpPostServices();
  }

  public static function convertElement($row) {
    $Obj = new WpPage();
    return parent::convertRootElement($Obj, $row);
  }

  public function getChildren()
  {
    if ($this->Children==null) {
      $this->Children = $this->WpPostServices->getChildren($this->getID());
    }
    return $this->Children;
  }

  public function getArticles()
  {
    if ($this->Articles==null) {
      $args = array(
        self::WP_METAKEY   => 'menu_order',
        self::WP_ORDERBY   => 'meta_value_num',
        'meta_query'       => array(
                                'key'     => 'page_parent',
                                'value'   => $this->getID(),
                                'compare' => '=',
                              ),
      );
      $this->Articles = $this->WpPostServices->getWpPosts($args);
    }
    return $this->Articles;
  }
}
