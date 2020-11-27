<?php
if (!defined('ABSPATH')) {
  die('Forbidden');
}
/**
 * Classe ProfPrincipal
 * @author Hugues
 * @version 1.00.00
 * @since 1.00.00
 */
class ProfPrincipal extends LocalDomain
{
  /**
   * Id technique de la donnée
   * @var int $id
   */
  protected $id;
  /**
   * Id technique de l'année scolaire
   * @var int $anneeScolaireId
   */
  protected $anneeScolaireId;
  /**
   * Id technique de la classe
   * @var int $classeId
   */
  protected $classeId;
  /**
   * Id technique de l'enseignant
   * @var int $enseignantId
   */
  protected $enseignantId;

  public function __construct()
  {
    parent::__construct();
    $this->AnneeScolaireServices = new AnneeScolaireServices();
    $this->ClasseScolaireServices = new ClasseScolaireServices();
    $this->EnseignantServices = new EnseignantServices();
  }

  /**
   * @return int
   * @version 1.00.00
   * @since 1.00.00
   */
  public function getId()
  { return $this->id; }
  /**
   * @return int
   * @version 1.00.00
   * @since 1.00.00
   */
  public function getAnneeScolaireId()
  { return $this->anneeScolaireId; }
  /**
   * @return int
   * @version 1.00.00
   * @since 1.00.00
   */
  public function getClasseId()
  { return $this->classeId; }
  /**
   * @return int
   * @version 1.00.00
   * @since 1.00.00
   */
  public function getEnseignantId()
  { return $this->enseignantId; }
  /**
   * @param int $id
   * @version 1.00.00
   * @since 1.00.00
   */
  public function setId($id)
  { $this->id=$id; }
  /**
   * @param int $anneeScolaireId
   * @version 1.00.00
   * @since 1.00.00
   */
  public function setAnneeScolaireId($anneeScolaireId)
  { $this->anneeScolaireId=$anneeScolaireId; }
  /**
   * @param int $classeId
   * @version 1.00.00
   * @since 1.00.00
   */
  public function setClasseId($classeId)
  { $this->classeId=$classeId; }
  /**
   * @param int $enseignantId
   * @version 1.00.00
   * @since 1.00.00
   */
  public function setEnseignantId($enseignantId)
  { $this->enseignantId=$enseignantId; }
  /**
   * @return array
   * @version 1.00.00
   * @since 1.00.00
   */
  public function getClassVars()
  { return get_class_vars('ProfPrincipal'); }
  /**
   * @param array $row
   * @param string $a
   * @param string $b
   * @return ProfPrincipal
   * @version 1.00.00
   * @since 1.00.00
   */
  public static function convertElement($row, $a='', $b='')
  { return parent::convertElement(new ProfPrincipal(), self::getClassVars(), $row); }
  /**
   * @return ProfPrincipalBean
   * @version 1.00.00
   * @since 1.00.00
   */
  public function getBean()
  { return new ProfPrincipalBean($this); }

  public function getAnneeScolaire()
  {
    if ($this->AnneeScolaire==null) {
      $this->AnneeScolaire = $this->AnneeScolaireServices->selectLocal($this->anneeScolaireId);
    }
    return $this->AnneeScolaire;
  }
  public function getClasseScolaire()
  {
    if ($this->ClasseScolaire==null) {
      $this->ClasseScolaire = $this->ClasseScolaireServices->selectLocal($this->classeId);
    }
    return $this->ClasseScolaire;
  }
  public function getEnseignant()
  {
    if ($this->Enseignant==null) {
      $this->Enseignant = $this->EnseignantServices->selectLocal($this->enseignantId);
    }
    return $this->Enseignant;
  }
}
