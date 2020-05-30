<?php
if ( !defined( 'ABSPATH') ) die( 'Forbidden' );
/**
 * Classe WpPostServices
 * @author Hugues.
 * @version 1.0.00
 * @since 1.0.00
 */
class WpPostServices extends GlobalServices {

  public function __construct() { }

  public function getPagesHeader()
  {
    $args = array(
      self::WP_POSTTYPE => self::WP_PAGE,
      self::WP_ORDERBY  => self::WP_MENUORDER,
      'post_parent' => 0,
    );
    return $this->getWpPosts($args);
  }

  public function getChildren($pageId)
  {
    $args = array(
      self::WP_POSTTYPE => self::WP_PAGE,
      self::WP_ORDERBY  => self::WP_MENUORDER,
      'post_parent' => $pageId,
    );
    return $this->getWpPosts($args);
  }

  /**
   * @param array $params
   * @param string $viaWpQuery
   * @param string $wpPostType
   * @return array
   */
  public function getWpPosts($params=array())
  {
    $args = array(
      self::WP_ORDERBY      => self::FIELD_NAME,
      self::WP_ORDER        => self::ORDER_ASC,
      self::WP_POSTSPERPAGE => -1,
      self::WP_POSTTYPE     => self::WP_POST,
    );
    if (!empty($params)) {
      foreach ($params as $key => $value) {
        $args[$key] = $value;
      }
    }
    $posts_array = get_posts($args);
    $WpPosts = array();
    if (!empty($posts_array)) {
      foreach ($posts_array as $post) {
        if ($post->post_type=='page') {
          $WpPosts[] = WpPage::convertElement($post);
        } else {
          $WpPosts[] = WpPost::convertElement($post);
        }
      }
    }
    return $WpPosts;
  }
}
?>
