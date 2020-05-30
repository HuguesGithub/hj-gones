<?php
if (!defined('ABSPATH')) {
  die('Forbidden');
}
/**
 * WpPageBean
 * @author Hugues
 * @since 1.00.00
 * @version 1.00.00
 */
class WpPageBean extends LocalBean
{
  /**
   * WpPost affiché
   * @var WpPost $WpPage
   */
  protected $WpPage;

  /**
   * @param string $post
   */
  public function __construct($post='')
  {
    parent::__construct();
    if ($post=='') {
      $post = get_post();
      $this->WpPage = WpPage::convertElement($post);
    }
    $this->WpPostServices = new WpPostServices();
  }

  /**
   * @return Bean
   */
  public static function getPageBean()
  {
    if (is_front_page()) {
      $returned = new WpPageBean();
    } else {
      $uri = $_SERVER['REDIRECT_SCRIPT_URL'];
      $arrUri = explode('/', $uri);
      if (isset($arrUri[1]) && $arrUri[1]=='category') {
        // On est dans le cas d'une catégory
        $lastSlug = array_pop($arrUri);
        if (empty($lastSlug)) {
          $lastSlug = array_pop($arrUri);
        }
        $categs = get_categories(array('slug'=>$lastSlug, 'hide_empty'=>false));
      } else {
        // On est dans le cas d'une page
        $returned = new GonePageBean($uri);
      }
    }
    return $returned;
  }

  /**
   * @return string
   */
  public function getContentPage()
  {
    $args = array('');
    $urlTemplate = 'web/pages/public/fragments/main-home.php';
    return $this->getRender($urlTemplate, $args);
  }

  /**
   * @return string
   */
  public function getPublicHeader()
  {
    $strNavigation = '';
    $strSubmenu    = '';
    //////////////////////////////////////////////////////////////
    // On va récupérer les WpPages "racines".
    $WpPages = $this->WpPostServices->getPagesHeader();
    while (!empty($WpPages)) {
      $this->WpPage = array_shift($WpPages);
      if ($this->WpPage->getMenuOrder()==99) {
        continue;
      }
      $this->Children = $this->WpPage->getChildren();
      $hasChildren = (count($this->Children)>0);
      if ($hasChildren) {
        $strNavigation .= '<li class="nav-item"><span class="nav-link hasChildren" data-tab="#'.$this->WpPage->getPostName().'">'.$this->WpPage->getPostTitle().'</span></li>';
        $strSubmenu .= $this->dealWithChildren();
      } else {
        $strNavigation .= '<li class="nav-item"><a class="nav-link" href="'.$this->WpPage->getPermalink().'">'.$this->WpPage->getPostTitle().'</a></li>';
      }
    }

    //////////////////////////////////////////////////////////////
    // On enrichi le tempalte et on le retourne
    $args = array(
      // La navigation - 1
      $strNavigation,
      // Sousmenu - 2
      $strSubmenu,
    );
    $urlTemplate = 'web/pages/public/fragments/main-header.php';
    return $this->getRender($urlTemplate, $args);
  }

  private function dealWithChildren()
  {
    $strSubmenu = '';
    $hasArticles = false;
    while (!empty($this->Children)) {
      $Child = array_shift($this->Children);
      $postMeta = $Child->getPostMeta('toheader');
      $subMenus = $Child->getPostMeta('sous_menu');
      if ($postMeta==1) {
        if (empty($subMenus)) {
          $strSubmenu .= '<li class="nav-item"><a class="nav-link" href="'.$Child->getPermalink().'"><h3>'.$Child->getPostTitle().'</h3></a></li>';
        } else {
          $hasArticles = true;
          $strSubmenu .= '<li class="nav-item"><h3>'.$Child->getPostTitle().'</h3>';
          $strSubmenu .= '<ul class="nav flex-column vertical">';
          $arrSubMenus = unserialize($subMenus);
          while (!empty($arrSubMenus)) {
            $libelle = array_shift($arrSubMenus);
            $strSubmenu .= '<li class="nav-item"><a class="nav-link" href="#">'.$libelle.'</a></li>';
          }
          $strSubmenu .= '</ul>';
          $strSubmenu .= '</li>';
        }
      }
    }
    return '<ul class="nav '.($hasArticles ? 'justify-content-center horizontal' : 'flex-column vertical').'" id="'.$this->WpPage->getPostName().'">'.$strSubmenu.'</ul>';
  }


  /**
   * @return string
   */
  public function getPublicFooter()
  {
    $args = array();
    $urlTemplate = 'web/pages/public/fragments/main-footer.php';
    return $this->getRender($urlTemplate, $args);
  }

}
