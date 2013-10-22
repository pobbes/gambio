<?php
  /**
   * @package Lettr
   * @subpackage REST_Client
   * @access private
   * @author Digineo GmbH
   * @copyright Digineo GmbH, 2010
   * @link http://www.digineo.de
   * @link mailto:kontakt@digineo.de
   */
  class Lettr_Recipient extends Lettr_Resource {
    public function __construct(){
      parent::__construct("recipients");
    }
    
    /**
     * Legt einen EmpfÃ?nger an.
     * 
     * Attribute des EmpfÃ?nger sind:
     *  - email: E-Mail-Adresse
     *  - firstname (optional): Vorname
     *  - lastname (optional): Nachname
     *  - gender (optional): Geschlecht, kann "f" (female/weiblich) oder "m" (male/mÃ?nnlich) sein
     *  - birthdate (optional): Geburtsdatum
     * 
     * @param array $attributes
     */
    public function create($attributes){
      return parent::create(array("recipient" => $attributes));
    }
    
    /**
     * LÃ¶scht einen EmpfÃ?nger anhand seiner E-Mail-Adresse.
     * 
     * @param string $email E-Mail-Adresse des EmpfÃ?ngers.
     */
    public function delete_by_email($email) {
      return $this->custom("delete", "destroy_by_email", array("email" => $email));
    }
  }
?>
