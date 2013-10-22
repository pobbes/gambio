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
  class Lettr_Client {
    /**
     * Setzt die Zugangsdaten zur Lettr-API.
     *  
     * @var array assoziativ, enthÃ?lt 'api-key'
     */
    private static $credentials = array();
    
    /**
     * ÃœberprÃ?ft, ob die Zugangsdaten zur API bereits gesetzt wurden,
     * und schmeiÃŸt ggf. eine Lettr_Exception.
     */
    private static function check_credentials(){
      if(!is_array(self::$credentials)){
        throw new Lettr_Exception("Credentials sind nicht definiert.");
      }
    }
    
    /**
     * Setzt die Zugangsdaten zur API.
     * 
     * SchmeiÃŸt Lettr_IllegalArgumentException, wenn sie unvollstÃ?ndig gesetzt werde
     * 
     * @param string/array $credentials EnthÃ?lt entweder einen API-Key als String oder ein assoziatives Array bestehend aus 'username' und 'password' mit entsprechenden Werten.
     */
    public static function set_credentials($api_key_or_username_and_password){
      $credentials = array();
      $credentials["site"] = "https://lettr.de/";
      
      if(!$api_key_or_username_and_password)
      {
        throw new Lettr_IllegalArgumentException("API-Key ist leer oder nicht definiert.");
      } elseif (is_string($api_key_or_username_and_password)){
        $credentials["api_key"] = $api_key_or_username_and_password;
      }
      elseif (is_array($api_key_or_username_and_password)) {
        Lettr_Validation::presence_of('api_key_or_username_and_password', $api_key_or_username_and_password, array("username", "password"));
        $credentials = array_merge($credentials, $api_key_or_username_and_password);
      } else {
      }
      self::$credentials = $credentials;
    }
    
    /**
     * Holt per GET Daten einer Resource ab.
     * 
     * @param $url string Pfad der Resource
     */
    public function get($url){
      return $this->send($url, 'GET');
    }
    
    /**
     * Erstellt per POST eine neue Resource.
     * 
     * @param $url string Pfad der Resource
     * @param $data array Daten
     */
    public function post($url, $data){
      return $this->send($url, 'POST', $data);
    }
    
    /**
     * Aktualisiert per PUT eine vorhandene Resource.
     * 
     * @param $url string Pfad der Resource
     * @param $data array Daten
     */
    public function put($url, $data){
      return $this->send($url, 'PUT', $data);
    }
    
    /**
     * LÃ¶scht per DELETE eine vorhandene Resource.
     * 
     * @param $url string Pfad der Resource
     * @param $data array (optional) Daten, die zum LÃ¶schen der Resource verwendet werden sollen.
     */
    public function delete($url, $data = null){
      return $this->send($url, 'DELETE', $data);
    }
    
    /**
     * Setzt einen REST-Request ab.
     * 
     * @param $url string Pfad der Resource
     * @param $method string REST-Methode
     * @param $data array (optional) zu Ã?bergebende Daten
     */
    protected function send($url, $method, $data = null){
      self::check_credentials();
      $this->errors = null;
      
      $header = array("Accept: application/json");
      
      if(!empty(self::$credentials["api_key"])) {
        $header[] = "X-Lettr-API-key: " . self::$credentials["api_key"];
      }
      
      $ch  = curl_init();
      curl_setopt($ch, CURLOPT_URL,            self::$credentials["site"] . $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_TIMEOUT,        15);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  $method);
      curl_setopt($ch, CURLOPT_HTTPHEADER,     $header);
      curl_setopt($ch, CURLOPT_POSTFIELDS,     self::serialized_params($data));
      
      // Auf Benutzernamen und Kennwort prÃ?fen!
      if(!empty(self::$credentials["username"])){
        curl_setopt($ch, CURLOPT_USERPWD, self::$credentials["username"] . ":" . self::$credentials["password"]);
      }
      
      /*
        Wenn hier der fehler 'error setting certificate verify locations' auftritt, 
        dann fehlt das ca-certificates-Paket. Das muss nachinstalliert werden mit:
         
        apt-get install ca-certificates
      */
      $data = curl_exec($ch);
      
      if (curl_errno($ch)) {
        // cURL-Fehler
        throw new Lettr_CurlException(curl_error($ch),curl_errno($ch));
      } else {
        $info = curl_getinfo($ch);
        curl_close($ch);

        // Behandeln der HTTP-Statuscodes
        switch($info['http_code']) {
          case 200:   // OK - Anfrage erfolgreich
          case 201:   // Created - Anfrage erfolgreich
          case 202:   // Accepted - Anfrage erfolgreich
            return true;
            break;
          case 400:   // Bad Request - Fehler in der Ãœbermittlung
            throw new Lettr_ClientErrorException('400 Bad Request - Daten wurden nicht erfolgreich Ã?bermittelt', 400);
            break;
          case 401:   // Unauthorized - Fehlerhafte Zugangsdaten
            throw new Lettr_ClientErrorException('401 Unauthorized - Bitte Benutzerdaten fÃ?r Lettr-Service Ã?berprÃ?fen!', 401);
            break;
          case 402:   // Payment Required - Kreditlimit Ã?berschritten
            throw new Lettr_ClientErrorException('402 Payment Required - Bitte Credits des Lettr-Service Ã?berprÃ?fen!', 402);
            break;
          case 403:   // Forbidden - Der Zugang wurde gesperrt
            throw new Lettr_ClientErrorException('403 Forbidden - Dienst temporÃ?r nicht verfÃ?gbar oder Zugang gesperrt', 403);
            break;
          case 404:   // Not Found - URL nicht mehr aktuell
            throw new Lettr_ClientErrorException('404 Not Found - URL nicht gefunden - Lettr-API auf dem neusten Stand?', 404);
            break;
          case 407:   // Proxy Authentication Required - Falls Proxy verwendet wird (Aktuell nicht relevant)
            throw new Lettr_ClientErrorException('407 Proxy Authentication Required - Bitte Benutzerdaten fÃ?r Proxy-Server prÃ?fen', 407);
            break;
          case 408:   // Request Timeout - Daten wurden zu langsam Ã?bermittelt (erneuter Versuch?)
            throw new Lettr_ClientErrorException('408 Request Timeout - Anfrage zu einem spÃ?teren Zeitpunkt neu stellen', 408);
            break;
          case 413:   // Request Entity Too Large - Anfrage zu groÃŸ (E-Mail zu groÃŸ?)
            throw new Lettr_ClientErrorException('413 Request Entity Too Large - Versendete E-Mail grÃ¶ÃŸer als maximum?', 413);
            break;
          case 418:   // I'm a Teapot - Soll ja vorkommen ;-)
            throw new Lettr_ClientErrorException('418 I\'m a Teapot - Sorry, wir liefern nur an Kaffeekannen ;-)', 418);
            break;
          case 422:   // Unprocessable Entity
            throw new Lettr_UnprocessableEntityException("422 Unprocessable Entity - Datenformat fehlerhaft (".print_r($data, true).")", 422);
            break;
          case 500:   // Internal Server Error - Anfrage spÃ?ter erneut absenden
            throw new Lettr_ServerErrorException('500 Internal Server Error - Der Lettr-Service steht gerade nicht zur VerfÃ?gung', 500);
            break;
          case 502:   // Bad Gateway - Anfrage spÃ?ter erneut senden 
            throw new Lettr_ServerErrorException('502 Bad Gateway - Der Lettr-Service steht gerade nicht zur VerfÃ?gung', 502);
            break;
          case 503:   // Service Unavailable - Retry-After abfragen und spÃ?ter erneut versuchen
            throw new Lettr_ServerErrorException('503 Service Unavailable - Der Lettr-Service steht gerade nicht zur VerfÃ?gung', 503);
            break;
        }
      }
    }
    
    public static function serialized_params($params, $prefix="", $return_as_hash=true) {
      $results = array();
      
      foreach($params as $key=>$value) {
        if(is_array($value)){
          $sub_results = self::serialized_params($value, empty($prefix) ? $key : $prefix.'['.$key.']', false);
          $results = array_merge($results, $sub_results);
        } else {
          array_push($results, array(empty($prefix) ? $key : $prefix.'['.$key.']', $value));
        }
      }
      
      if($return_as_hash) {
        $final_results = array();
        
        foreach($results as $result) {
          $final_results[$result[0]] = $result[1];
        }
        return($final_results);
      }
      
      return($results);
    }
  }
?>
