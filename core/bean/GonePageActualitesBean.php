<?php
if (!defined('ABSPATH')) {
  die('Forbidden');
}
/**
 * GonePageActualitesBean
 * @author Hugues
 * @since 1.00.00
 * @version 1.00.00
 */
class GonePageActualitesBean extends WpPageBean
{

  public function getContentPage()
  {
    $page = get_post();
    $WpPage = WpPage::convertElement($page);
    $args = array(
      self::WP_CAT  => 2,
      self::WP_ORDERBY => self::WP_POSTDATE,
      self::WP_ORDER   => self::ORDER_DESC,
      self::WP_POSTSPERPAGE => 8,
    );
    $WpPosts = $this->WpPostServices->getWpPosts($args);

    ///////////////////////////////////////////////
    //
    $strArticles = '';
    while (!empty($WpPosts)) {
      $WpPost = array_shift($WpPosts);
      $WpPostBean = $WpPost->getBean();
      $strArticles .= $WpPostBean->getWpPostExtract();
    }

    $args = array(
      // Titre de le page - 1
      $WpPage->getPostTitle(),
      // Eventuel entête de la page - 2
      $WpPage->getPostContent(),
      // Classe pour afficher le contenu - 3
      'card-deck', // card-columns
      // Contenu à proprement parlé - 4
      $strArticles,
    );
    $urlTemplate = 'web/pages/public/fragments/main-middle.php';
    return $this->getRender($urlTemplate, $args);
  }

}
