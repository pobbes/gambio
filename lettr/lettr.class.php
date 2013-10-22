<?php
  /**
   * @package Lettr
   * @subpackage API
   * @access public
   * @author Digineo GmbH
   * @copyright Digineo GmbH, 2010
   * @link http://www.digineo.de
   * @link mailto:kontakt@digineo.de
   */
  class Lettr {
    /**
     * Setzt die Zugangsdaten zur Lettr-API.
     *  
     * @param $credentials array assoziativ, enth�?lt 'username' und 'password'
     */
    public static function set_credentials($credentials){
      return Lettr_Client::set_credentials($credentials);
    }
    
    /**
     * F�?gt einen Newsletter-Empf�?nger hinzu.
     * 
     * Über den zweiten Parameter können bei Bedarf zus�?tzliche Informationen zum Empf�?nger angegeben werden:
     *  - name: Benutzername (Alternative zu firstname+lastname)
     *  - firstname: Vorname
     *  - lastname: Nachname
     *  - gender: Geschlecht (m/f)
     *  - birthdate: Geburtsdatum (YYYY-MM-DD)
     *  - street: Straße + Hausnummer
     *  - city: Stadt
     *  - ccode: Land nach <a href="http://www.iso.org/iso/english_country_names_and_code_elements">ISO 3166-1</a>
     * 
     * @param $email string E-Mail-Adresse des Empf�?ngers
     * @param $additional_info array (optional) assoziativ, weitergehende Informationen
     */
    public static function subscribe($email, $additional_info = array()){
      $recipient = new Lettr_Recipient();
      return $recipient->create(array_merge($additional_info, array("email" => $email)));
    }
    
    /**
     * Meldet einen Newsletter-Empf�?nger ab.
     * 
     * @param $email string E-Mail-Adresse des Empf�?ngers
     */
    public static function unsubscribe($email){
      $recipient = new Lettr_Recipient();
      return $recipient->delete_by_email($email);
    }
    
    /**
     * Verschickt eine E-Mail �?ber die Lettr-API ohne Template
     * 
     * Der Empf�?nger der E-Mail muss nicht notwendiger Weise auch Newsletter-Empf�?nger sein.
     * 
     * @param $to string E-Mail-Adresse des Empf�?ngers
     * @param $subject string Betreff der E-Mail
     * @param $message string Text der E-Mail
     * @param $options array Zus�?tzliche optionen wie reply_to oder sender_address
     *      */
    public static function mail($to, $subject, $message, $options=array()){
      $options = array("delivery" => array_merge(array("recipient" => $to, "subject" => $subject, "text" => $message), $options));
      $delivery = new Lettr_Delivery();
      return $delivery->deliver_without_template($options);
    }
    
    /**
     * Verschickt eine Multipart-E-Mail �?ber die Lettr-API ohne Template
     * 
     * Der Empf�?nger der E-Mail muss nicht notwendiger Weise auch Newsletter-Empf�?nger sein.
     * 
     * @param $to string E-Mail-Adresse des Empf�?ngers
     * @param $subject string Betreff der E-Mail
     * @param $multiparts array text/html (string), ggfs. files (array)
     * @param $options array Zus�?tzliche optionen wie reply_to oder sender_address
     *      */
    public static function multipart_mail($to, $subject, $multiparts=array(), $options=array()){
      if (empty($multiparts["text"]) && empty($multiparts["html"])) {
        throw new Lettr_IllegalArgumentException("Als multipart muss mindestens 'text' oder 'html' angegeben werden.");
      }
      
      $delivery_options = array("delivery" => array_merge($multiparts, array("recipient" => $to, "subject" => $subject), $options));
      
      if (!empty($multiparts["files"])) {
        if(!is_array($multiparts["files"])) {
          throw new Lettr_IllegalArgumentException("Als multipart 'files' muss ein assoziatives Array sein.");
        } else {
          $delivery_options["files"] = $multiparts["files"];
          unset($delivery_options["delivery"]["files"]); # Nach dem Merging Aufr�?umen
        }
      }
      
      $delivery = new Lettr_Delivery();
      return $delivery->deliver_without_template($delivery_options);
    }
    
    /**
     * Verschickt eine E-Mail �?ber diie Lettr-API mit Template
     * 
     * @param $to string E-Mail-Adresse des Empf�?ngers
     * @param $subject string Betreff der E-Mail
     * @param $mailing_identifier string Selbstgesetzter Identifier des zu verwendenden Templates
     * @param $placeholders array assozativ, verwendete Platzhalter im zu verwendenden Template
     * @param $options array Zus�?tzliche optionen wie reply_to oder sender_address
     *      */
    public static function mail_with_template($to, $subject, $mailing_identifier, $placeholders = array(), $options=array()){
      $delivery = new Lettr_Delivery();
      return $delivery->deliver_with_template($mailing_identifier, array("delivery" => array_merge($placeholders, array("recipient"=>$to, "subject"=>$subject), $options)));
    }
  }
?>
