<?php
if (!defined('ABSPATH')) {
  die('Forbidden');
}
/**
 * Classe AperdPDF
 * @author Hugues
 * @version 1.00.00
 * @since 1.00.00
 */
class AperdPDF extends FPDF implements ConstantsInterface
{
  /**
   * Class Constructor
   * @param CompteRendu $CompteRendu
   * @version 1.00.00
   * @since 1.00.00
   */
  public function __construct($CompteRendu)
  {
    parent::__construct();
    $this->BilanMatiereServices = new BilanMatiereServices();
    $this->MatiereServices = new MatiereServices();
    $this->CompteRendu = $CompteRendu;

    $this->initData();
  }
  /**
   * @version 1.00.00
   * @since 1.00.00
   */
  private function initData()
  {
    $this->titre = "Association de Parents d'�l�ves du Coll�ge Raoul Dufy";
    $this->anneeScolaire = 'ANN�E SCOLAIRE '.$this->CompteRendu->getAnneeScolaire()->getAnneeScolaire();
    $trim = $this->CompteRendu->getValue(self::FIELD_TRIMESTRE);
    $frmtTrimestre = $trim.($trim==1 ? 'er' : '�me');
    $this->headerLine1 = 'Compte-rendu du conseil de classe du '.$frmtTrimestre.' trimestre';
    $this->headerLine2 = 'Classe de : '.str_replace('0', '�', $this->CompteRendu->getClasseScolaire()->getLabelClasse()).'. Effectif de la classe : '.$this->CompteRendu->getValue(self::FIELD_NBELEVES).' �l�ves';
    $this->headerLine3 = "Le conseil de classe s'est tenu le ".$this->CompteRendu->getValue(self::FIELD_DATECONSEIL)." sous la pr�sidence de ".utf8_decode($this->CompteRendu->getAdministration()->getFullInfo());
    $this->headerLine3 .= ", en pr�sence de ".utf8_decode($this->CompteRendu->getEnseignant()->getProfPrincipal()).", des autres professeurs de la classe, ";
    $this->headerLine3 .= utf8_decode($this->CompteRendu->getStrParentsDelegues());
    $this->headerLine3 .= utf8_decode($this->CompteRendu->getStrElevesDelegues());

    $this->conclusion1 = "R�unions mensuelles : L'association des Parents d'�l�ves se r�unit un mercredi par mois (hors vacances scolaires). Vous pouvez �galement d�couvrir la vie du coll�ge et les actions de l'association sur son site internet.";
    $this->conclusion2 = "Compte rendu fait le ".$this->CompteRendu->getValue(self::FIELD_DATEREDACTION)." par ".utf8_decode($this->CompteRendu->getValue(self::FIELD_AUTEURREDACTION)).", sous sa responsabilit�.";

    $this->footerLine1 = '74 bis, rue Mazenod 69003 Lyon';
    $this->footerLine21 = 'Site : ';
    $this->footerLine22 = ' - Email : ';

    $this->urlLogo = dirname(__FILE__).'/../../web/rsc/img/Logo-APERD-3.png';
  }
  /**
   * @param string $url
   * @param string $txt
   * @version 1.00.00
   * @since 1.00.00
   */
  private function putLink($url, $txt='')
  {
    $this->SetTextColor(0, 0, 255);
    $this->Write(5, ($txt=='' ? $url : $txt), $url);
    $this->setColorDefault(0);
  }
  /**
   * @param CompteRendu $CompteRendu
   * @return int
   * @version 1.00.00
   * @since 1.00.00
   */
  public static function buildPdf($CompteRendu)
  {
    $pdf = new AperdPDF($CompteRendu);
    $pdf->AliasNbPages();

    // Premi�re Page
    $pdf->AddPage();
    $pdf->buildPdfInfos();
    $pdf->buildPdfMatieres();
    $pdf->AddPage();

    // Deuxi�me Page
    $pdf->buildBilanGeneral();
    $pdf->buildBilanAndAttributions();

    // Export du fichier
    $url = dirname(__FILE__).'/../../web/rsc/pdf-files/'.$CompteRendu->getValue(self::FIELD_CRKEY).'.pdf';
    $pdf->Output('F', $url);
    return $pdf->PageNo();
  }
  /**
   * @version 1.00.01
   * @since 1.00.01
   */
  public function buildBilanGeneral()
  {
    $this->Ln();
    // Bilan Prof Principal
    $this->setColorBlue();
    $this->Write(5, 'Bilan G�n�ral de la Classe');
    $this->Ln();
    $this->Ln();
    $this->setColorDefault(0);
    $this->MultiCell(190, 5, utf8_decode($this->CompteRendu->getValue(self::FIELD_BILANPROFPRINCIPAL)), 0, 1);
    $this->Ln();
    // Attributions
    $this->setColorBlue();
    $this->Write(5, 'Attributions du conseil de classe');
    $this->Ln();
    $this->Ln();
    $this->setColorDefault(0);
    $this->Cell(40, 5, 'F�licitations : ', 0, 0, 'R');
    $this->Cell(10, 5, $this->CompteRendu->getValue(self::FIELD_NBFELICITATIONS), 0, 0, 'L');
    $this->Cell(80, 5, 'Mise en garde Travail : ', 0, 0, 'R');
    $this->Cell(10, 5, $this->CompteRendu->getValue(self::FIELD_NBMGTVL), 0, 0, 'L');
    $this->Ln();
    $this->Cell(40, 5, 'Compliments : ', 0, 0, 'R');
    $this->Cell(10, 5, $this->CompteRendu->getValue(self::FIELD_NBCOMPLIMENTS), 0, 0, 'L');
    $this->Cell(80, 5, 'Mise en garde Comportement : ', 0, 0, 'R');
    $this->Cell(10, 5, $this->CompteRendu->getValue(self::FIELD_NBMGCPT), 0, 0, 'L');
    $this->Ln();
    $this->Cell(40, 5, 'Encouragements : ', 0, 0, 'R');
    $this->Cell(10, 5, $this->CompteRendu->getValue(self::FIELD_NBENCOURAGEMENTS), 0, 0, 'L');
    $this->Cell(80, 5, 'Mise en garde Comportement et Travail : ', 0, 0, 'R');
    $this->Cell(10, 5, $this->CompteRendu->getValue(self::FIELD_NBMGCPTTVL), 0, 0, 'L');
    $this->Ln();
    $this->Ln();
  }
  /**
   * @version 1.00.00
   * @since 1.00.00
   */
  public function buildBilanAndAttributions()
  {
    // Bilan D�l�gu�s El�ves
    $this->setColorBlue();
    $this->Write(5, 'Intervention des d�l�gu�s �l�ves');
    $this->Ln();
    $this->Ln();
    $this->setColorDefault(0);
    $this->MultiCell(190, 5, utf8_decode($this->CompteRendu->getValue(self::FIELD_BILANELEVES)), 0, 1);
    $this->Ln();
    // Bilan D�l�gu�s Parents
    $this->setColorBlue();
    $this->Write(5, 'Intervention des d�l�gu�s parents');
    $this->Ln();
    $this->Ln();
    $this->setColorDefault(0);
    $this->MultiCell(190, 5, utf8_decode($this->CompteRendu->getValue(self::FIELD_BILANPARENTS)), 0, 1);
    $this->Ln();
    // Conclusion
    $this->setColorBlue();
    $this->SetY(-55);
    $this->Write(5, 'Informations g�n�rales');
    $this->Ln();
    $this->Ln();
    $this->setColorDefault(0);
    $this->MultiCell(190, 5, $this->conclusion1, 0, 1);
    $this->MultiCell(190, 5, $this->conclusion2, 0, 1);
  }
  /**
   * @version 1.00.00
   * @since 1.00.00
   */
  public function Header()
  {
    // On d�fini la cha�ne de caract�res utilis�e
    $this->SetFont('Times', '', 14);
    $this->Image($this->urlLogo, 93);
    // Le titre
    $this->addCenteredText($this->titre);
    $this->Ln();
    // Fin Titre
  }
  /**
   * @version 1.00.00
   * @since 1.00.00
   */
  public function Footer()
  {
    $this->SetY(-15);
    $this->SetFont('Times', 'I', 8);
    $this->Write(5, $this->titre);
    $this->Ln(3);
    $this->Write(5, $this->footerLine1);
    $this->Ln(3);
    $this->Write(5, $this->footerLine21);
    $this->putLink('http://asso-parents-dufy.org');
    $this->Write(5, $this->footerLine22);
    $this->SetTextColor(0, 0, 255);
    $this->Write(5, 'contact@asso-parents-dufy.org');
    $this->setColorDefault(0);
    $this->Write(5, '                                                                                                                            Page '.$this->PageNo().'/{nb}');
  }
  /**
   * @param array $w
   * @version 1.00.00
   * @since 1.00.00
   */
  private function setWidth($w)
  { $this->widths = $w; }
  /**
   * @param array $a
   * @version 1.00.00
   * @since 1.00.00
   */
  private function setAligns($a)
  { $this->aligns = $a; }
  /**
   * @version 1.00.01
   * @since 1.00.00
   */
  public function buildPdfMatieres()
  {
    /////////////////////////////////////////////////////////////////////////////
    // On d�fini les variables n�cessaires � l'ex�cution du script.
    $headers = array('Mati�re (Nom)', 'Statut', 'Observations');
    $this->setWidth(array(30, 15, 145));
    $this->setAligns(array('L', 'C', 'L'));
    $this->heightLine = 5;
    $this->SetFillColor(224, 235, 255);
    $fill = false;
    // On r�cup�re la liste des Mati�res.
    $Matieres = $this->MatiereServices->getMatieresWithFilters();
    $data = array();
    // Et on construit les lignes du tableau qui en d�pendent
    while (!empty($Matieres)) {
      $Matiere = array_shift($Matieres);
      $args = array(
        self::FIELD_COMPTERENDU_ID => $this->CompteRendu->getId(),
        self::FIELD_MATIERE_ID => $Matiere->getId(),
      );
      $BilanMatieres = $this->BilanMatiereServices->getBilanMatieresWithFilters($args);
      if (empty($BilanMatieres)) {
        continue;
      }
      $BilanMatiere = array_shift($BilanMatieres);
      $nomEnseignant = $BilanMatiere->getEnseignant()->getNomEnseignant();
      $args = array(
        utf8_decode($Matiere->getLabelMatiere()."\r\n".$nomEnseignant),
        utf8_decode($BilanMatiere->getStrStatut()),
        utf8_decode($BilanMatiere->getObservations()),
      );
      array_push($data, $args);
    }
    /////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////
    // On affiche le Header
    $nbHeaders = count($headers);
    $h = ($this->heightLine-1)*2;
    for ($i=0; $i<$nbHeaders; $i++) {
      //$this->Cell($this->widths[$i], $this->heightLine, $headers[$i], 1, 0, 'C', $fill);
      $w = $this->widths[$i];
      // Save the current position
      $x = $this->GetX();
      $y = $this->GetY();
      // Draw the Border
      $this->Rect($x, $y, $w, $h, $fill ? 'FD' : 'D');
      // Print the text
      $this->MultiCell($w, $this->heightLine, $headers[$i], 0, 'C');
      $this->SetXY($x+$w, $y);
    }
    $this->Ln($h);
    $fill = !$fill;
    /////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////
    // Puis on affiche chaque Mati�re de la classe
    $this->SetFontSize(10);
    $nbRows = count($data);
    for ($i=0; $i<$nbRows; $i++) {
      $nb=0;
      for ($j=0; $j<$nbHeaders; $j++) {
        $nb = max($nb, $this->NbLines($this->widths[$j], $data[$i][$j]));
      }
      $h = ($this->heightLine-1)*$nb;
      for ($j=0; $j<$nbHeaders; $j++) {
        $w = $this->widths[$j];
        $a = $this->aligns[$j];
        // Save the current position
        $x = $this->GetX();
        $y = $this->GetY();
        // Draw the Border
        $this->Rect($x, $y, $w, $h, $fill ? 'FD' : 'D');
        // Print the text
        $this->MultiCell($w, $this->heightLine-1, $data[$i][$j], 0, $a);
        $this->SetXY($x+$w, $y);
      }
      $this->Ln($h);
      $fill = !$fill;
    }
    $this->SetFontSize(12);
    /////////////////////////////////////////////////////////////////////////////
  }
  /**
   * @param int $w
   * @param string $txt
   * @return int
   * @version 1.00.00
   * @since 1.00.00
   */
  private function NbLines($w, $txt)
  {
    //Computes the number of lines a MultiCell of width w will take
    $cw = &$this->CurrentFont['cw'];
    if ($w==0) {
      $w = $this->w - $this->rMargin-$this->x;
    }
    $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r", '', $txt);
    $nb=strlen($s);
    if ($nb>0 && $s[$nb-1]=="\n") {
      $nb--;
    }
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while ($i<$nb) {
        $c=$s[$i];
        if ($c=="\n") {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if ($c==' ') {
            $sep=$i;
          }
        $l+=$cw[$c];
        if ($l>$wmax) {
            if ($sep==-1) {
                if ($i==$j) {
                    $i++;
                  }
            } else {
                $i=$sep+1;
              }
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        } else {
            $i++;
          }
    }
    return $nl;
  }
  /**
   * @version 1.00.00
   * @since 1.00.00
   */
  public function buildPdfInfos()
  {
    // L'ann�e Scolaire
    $this->setColorBlue();
    $this->addCenteredText($this->anneeScolaire);
    $this->Ln();
    // Trimestre / Classe / Effectifs
    $this->setColorDefault();
    $this->addCenteredText($this->headerLine1);
    $this->addCenteredText($this->headerLine2);
    $this->Ln();
    $this->Ln();
    // Texte Introduction
    $this->SetFontSize(12);
    $this->MultiCell(190, 5, $this->headerLine3, 0, 1);
    $this->Ln();
  }

  private function setColorDefault()
  { $this->SetTextColor(5); }
  private function setColorBlue()
  { $this->SetTextColor(36, 116, 179); }
  private function addCenteredText($text)
  {
    $w = $this->GetStringWidth($text);
    $this->SetX((210-$w)/2);
    $this->Cell($w, 5, $text, 0, 1, 'C');
  }

}
