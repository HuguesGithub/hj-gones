<?php
if (!defined('ABSPATH')) {
  die('Forbidden');
}
/**
 * WpPostBean
 * @author Hugues
 * @since 1.00.00
 * @version 1.00.00
 */
class WpPostBean extends LocalBean
{
  /**
   * @param string $post
   */
  public function __construct($WpPost)
  {
    $this->WpPost = $WpPost;
  }

  public function getWpPostExtract()
  {
    $urlTemplate = 'web/pages/public/fragments/article-news.php';
    ////////////////////////////////////
    // Récupération des Tags
    $WpTags = $this->WpPost->getTags();
    $arrTags = array();
    while (!empty($WpTags)) {
      $WpTag = array_shift($WpTags);
      array_push($arrTags, $WpTag->getName());
    }

    $args = array(
      // Titre de l'article - 1
      $this->WpPost->getPostTitle(),
      // Url de l'article - 2
      $this->WpPost->getPermalink(),
      // Extrait du contenu - 3
      $this->WpPost->getPostExcerpt(),
      // Liste des Catégories de l'article - 4
      implode(', ', $arrTags),
    );
    return $this->getRender($urlTemplate, $args);
  }
}
