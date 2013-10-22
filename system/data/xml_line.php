<?php
/**
*XML-LINE Version  0.3.5 == 09.07.04
* PHP-Klasse zum Abfragen und Ändern von XML-Dateien
* (C) 2004 Peter Bieling, pb@media-palette.de
* Einige Codezeilen, für den Aufruf der Parserfunktionen sind dem
* PHP-Manual entnommen.
*
* This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU Lesser General Public
* License as published by the Free Software Foundation; either
* version 2.1 of the License, or (at your option) any later version.
*
* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
* Lesser General Public License for more details.
*
* You should have received a copy of the GNU Lesser General Public
* License along with this library; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*
* @version xml-line.php v 0.3.6
* @author Peter Bieling <pb@media-palette.de>
* @todo Attribute werden nicht aus dem Speicher gelöscht! Korrigieren
*       Zeichensatz testen bei Eingabe aus String (eventuell Zeichensatz setzen)
*       Limit-Counter auf alle Funktionen ausdehnen
*       Bei Lesevorgängen Datei schließen, wenn Suche beendet ist.
* ======== Änderungen ===============================================
* Bug-Fix: delete_content() (fehlende Klammer im Starttag bei Ausgabe)
*    "   : get_record() (Wert 0 wurde nicht angezeigt)
* insert_element_after_element - Umbenennung in
* insert_after_element (weil nicht nur Elemente eingefügt werden können)
* Beseitigung des Bugs (Elementinhalt wurde nicht berücksichtigt.)
* neue Funktionen:
* Die Übergabe eine Strings statt einer Eingabedatei ist jetzt möglich.
*     Das Skript prüft zuerst auf String und öffnet im Negativfall die Datei
* get_content() Der Inhalt von Elementen kann als String ausgelesen werden.
*
* copy_brench() ermöglicht die Kopie ganzer Elemente
*/

class xml_line {
    /**
    * Variable für Testausgaben.
    *
    * @var string $testbuffer
    */
    var $testbuffer; // für Testzwecke.

    /**
    * Der Name der XML-Input-Datei
    *
    * @var string $file
    */
    var $file;

    /**
    * Der Name der Output-Datei
    *
    * @var string $outfile
    */
    var $outfile = "";

    /**
    * Name des aktuellen Elements
    *
    * @var string $akt_name
    */
    var $akt_name = "";

    /**
    * Ausgabe wird nur geschrieben, wenn true gesetzt ist.
    *
    * @var boolean $write_flag
    */
    var $write_flag = true;

    /**
    * Markiert das Ende von Bereichen, die nicht geschrieben (also de facto gelöscht) werden.
    *
    * @var string $last_nowrite_line    join("",$this->ls);
    */
    var $last_nowrite_line = "";

    /**
    * Speichert die XML-Ausgabe, sofern sie gefordert ist, bzw. nicht in eine Datei geschrieben wird
    *
    * @var string $xml_buffer;
    */
    var $xml_buffer = "";

    /**
    * Speichert die CSV-Ausgabe, sofern sie (statt XML)gefordert ist,
    * bzw. nicht in eine Datei geschrieben wird. Experimentell!!!
    *
    * @var string $csv_buffer;
    */
    var $csv_buffer = "";

    /**
    * Speichert Position als key und einen String als value für das Ersetzen
    * oder Einsetzen von Text oder XML .Jede Funktion nutzt diesen Speicher selbst bei Bedarf.
    *
    * @var array $fill     join("", $this->ls)=> Insertstring
    */
    var $fill = array();

    /**
    * Speichert einzusetzende Attribute in einem Hash (name=>value), wenn ein oder mehrere
    * Attribute hinzugefügt werden sollen
    *
    * @var array $fillattr
    */
    var $fillattr = array();

    /**
    * Speichert die Attributhashs solange das Element aktuell ist. (Key ist der "pathname")
    *    Achtung: Wird wegen neuer Funktion get_record zur Zeit nicht gelöscht. (todo)
    *    Wichtig für Einfügeoperationen, damit auch beim Endelement noch bekannt ist,
    *    welche Attribute das Element hat.
    *
    * @var array $temp_attr_buffer
    */
    var $temp_attr_buffer = array();

    /**
    * Gibt an, ob bzw. was ausgegeben werden soll.
	* xml, csv, hixml oder Leerstring
    *
    * @var mixed $output_action
    */
    var $output_action = "";

    /**
    * Gibt den aktuellen Level der Elementhierarchie an
    *
    * @var integer $level
    */
    var $level = 0;

    /**
    * Expat liefert die Daten häufig in mehreren Stücken
    * Hier wird das Ergebnis zwischengespeichert, bis der Data-String komplett ist
    *
    * @var string $data_buffer
    */
    var $data_buffer = "";

    /**
    * Enthält alle Elemente des aktuellen Elementpfads einzeln als Array-Werte.
    * Damit kann dieser problemlos ergänzt oder gekürzt werden
    *
    * @var array $path_array  (root,level1,level2)
    */
    var $path_array = array();

    /**
    * Name der aufzurufenden Funktion. Funktionen werden in einem Array gespeichert.
    * $action_func[0] = Funktionsname
    * $action_func[1] = Parameterliste (array)
    * $action_func[2] = Kommando
    * $action_func[3] = Ersetzungsstring
    *
    * @var array $action_func
    */
    var $action_func = array();

    /**
    * Zählt die gesetzten Funktionen. Ermöglicht das Auseinanderhalten der verschiedenen Prozesse
    * und die Zuordnung der Rückgabewerte.
    *
    * @var integer $func_counter
    */
    var $func_counter = 0;

    /**
    * Speicher für zusätzliche Prozessinformationen,
    * 'datapart' z.B. ([1]['datapart']) merkt sich bei
    * gemischten Inhalten, welcher Datenabschnitt ausgegeben werden soll
    * 'limit' [1]['limit']=3 bedeutet: 3 Treffer werden gesucht, danach steigt die Funktion aus.
    * (runterzählen bis auf 0)
    *
    * @var array $procdata
    */
    var $procdata = array(array());

    /**
    * Enthält die wichtigsten Informationen der aktuellen XML-Position.
    *
    * @var array $ls
    */
    var $ls = array('type' => "", // S (START)  D = (DATA)
        // E (END) EOS (End of Start)   A = (Attribute) X=(Doctype und Kommentare)
        'level' => 0, // level of XML-Tree
        'pathstring' => "", // element1/element2
        'attrn' => "", // attributename if type='A'
        'data' => "" // data of element or attribute
        );

    /**
    * Speichert die gefunden Daten, Pfadinformationen und Attribute in einem Array
    * Art der Rückgabe kann sich noch ändern, am besten mit print_r() selbst ansehen. ;-)
    *
    * @var array $found_data
    */
    var $found_data = array();

    /**
    * Zähler für Textstücke innerhalb eines Elements mit weiteren untergeordneten Elementen,
    * läuft nur mit, wenn er benötigt wird und das passende Element gefunden wurde.
    *
    * @var arry $found_data_part (key aus Prozessnr-pathstring-und-levelstring)
    */
    var $found_data_part = array();

    /**
    * Element-Counter. Läuft nur mit, wenn er gesetzt wird. Kann für statistische Zwecke benutzt werden
    *    $el_counter[elname] = array($countall, $level => $countonthislevel
    *
    * @var mixed $elcounter  (string or array)
    */
    var $el_counter = "";

    /**
    * element-level-counter, enthält die Zählerwerte, der aktuellen Elemente. [level]["elementname"]
    *
    * @var array $elc
    */
    var $elc = array(array());

    /**
    * Kurzform des aktuellen Elementpfads (3,2,8) ohne Bezug auf die Elemente
    *
    * @var array $elc_path_array
    */
    var $elc_path_array = array();

    /**
    * Error - noch sträflich vernachlässigt ;-( Soll die Fehlermeldungen aufnehmen,
    * die man dann abrufen kann. (noch in der Entwicklung)
    *
    * @var array $error
    */
    var $error = array();

    /**
    * Expat-Variable
    *
    * @var integer $parser resource
    */
    var $parser;

    /**
    * Outputfilehandler
    *
    * @var integer $of resource_id
    */
    var $of;

    /**
    * Soll bei Datensatzabfrage, das Ergebnis speichern:
    * $table_result[Funktionsnr][counter]['key'] => "value"
    * key ist die "Spaltenüberschrift" = Name des Elements.
    * Ist das Element untergeordnet ist key 'parent/child'
    * Attribute werden ebenfalls in die Tabelle aufgenommen:
    * 'element@attribut1'
    */
    var $table_result = array();

    /**
    * XML-Header und Kommentare ausgeben oder nicht. Wird über Methodenaufruf verändert
    *
    * @var boolean $ignore_default_data
    */
    var $ignore_default_data = false;

    /**
    * Interner Schalter für die Highlight-Ausgabe
    *
    * @var boolean $hightlight
    */
    var $highlight = false;

    /**
    * Interner Schalter für die Highlight-Ausgabe. Merkt sich, ob Daten ausgegeben wurden
    *
    * @var boolean $datafound
    */
    var $datafound = false;

    /**
    * Internes Flag für die Highlight-Ausgabe. Merkt sich, ob vorher ein Zeilenumbruch gesetzt wurde.
    *
    * @var boolean $breakset
    */
    var $breakset = false;
   //neu:
    var $copy_flag=array(); //zeigt an, ob in  proc-data :Puffer geschrieben werden muss:
       //$copy_flag[0]=true;
	var $tmp_sign = "_%%_"; //temporärer Inhalt für sonst leere Elemente.
	  //wird für get_record() benötigt.

    /**
    * Constructor.
    *
    * @param string $file XML-Quelldatei
    * @param string $out optional Ausgabeformat (z.B. xml oder hixml)
    * @param string $outfile optional Ausgabedatei
    * @access public
    */


    function xml_line ($file, $out = "", $outfile = "")
    {
        $this->file = $file;
        if ($out) { // Augabe in csv oder xml möglich
            if (trim($out) == "csv") {
                $this->output_action = "csv";
            } else if (trim($out) == "hixml") {
                $this->output_action = "xml";
                $this->highlight = true;
            } else $this->output_action = "xml";
            if ($file) { // ohne file wird die Ausgabe im String gepuffert;
                $this->outfile = trim($outfile);
            }
        } else {
            // Hier wird weder eine Datei noch ein String ausgegeben.
            // Sinnvoll für reine Abfragen.
            $this->output_action = false;
        }
    }

    /**
    * Setzt den Namen der Funktion, die auf den Stream zugreift
    *        und übergibt eine Parameterliste oder -string
    *
    * @param  $func string
    * @param  $arg mixed                (string or array)
    * @param  $command string
    * @param  $value mixed                (string or array)
    */
    function set_action($func, $arg = "", $command = "", $value = "")
    {
        $tmpindex = count($this->action_func); //Künftige Prozessnummer ermitteln
        // Datapart abtrennen falls vorhanden: 1-2-2:3
        if (isset($arg[4])) { // ist der Parameter vorhanden?
            if (strstr($arg[4], ':')) { // ist ein Trennzeichen vorhanden
                $tmparray = explode(':', $arg[4]);
                $arg[4] = $tmparray[0];

                $this->procdata[$tmpindex]['datapart'] = $tmparray[1];
            }
        }
        $this->action_func[] = array($func, $arg, $command, $value);
        $this->procdata[$tmpindex]['limitcount'] = 0;
    }

    /**
    * Setzt den Elementcounter. Dadurch ist die Adressierung paralleler Elemente
    * möglich.
    *
    * @param boolean $value optional
    * @access public
    */
    function set_element_counter($value = true)
    {
        if ($value) $this->el_counter = "set";
    }

    /**
    * Motor des Ganzen. Wird bei jedem Neueintrag in $ls aufgerufen
    * und arbeitet die Funktionen ab, die im Hauptprogramm gesetzt wurden.
    * Jeder neue "Datensatz" löst die Aktionen aus.
    *
    * @access private
    */
    function xml_action()
    {
        $f =& $this->action_func; //Referenz zur einfacheren Lesbarkeit
        for ($i = 0; $i < count($f) ; $i++) { // kommentieren, was hier passiert!
            $this->func_counter = $i; //
            // Funktionsname wird hier durch $vor dem f zur Funktion, die gleichzeitig aufgerufen wird.
            if ($this->action_func[$i]) { // wenn der Wert 0 ist, wurde die Funktion durch check_limit() gekillt,
                // weil keine Daten mehr gesucht oder verändert werden müssen.
                $this->$f[$i][0]($this->action_func[$i][1], $this->action_func[$i][2], $this->action_func[$i][3]);
            }
        }
		//neu===============
        if (! empty($this->copy_flag)) $this->copy_xml();
		//neu-ende===============
        if ($this->write_flag) {
            if ($this->output_action == "xml") $this->write_xml();
            else if ($this->output_action == "csv") $this->write_csv();
        } else {
            if ($this->last_nowrite_line == "") $this->write_flag = true;
            else if ($this->last_nowrite_line == $this->ls['type'] . implode('-', $this->elc_path_array) . $this->ls['pathstring']) {
                $this->write_flag = true;
                $this->last_nowrite_line = "";
            }
        }
        // Einfügen von Daten ===============================================
        // Replace-Daten oder Einschübe werden in einem Hash gespeichert,
        // der als Key die Reihe enthält, hinter der eingefügt wird.
        $insertkey = $this->ls['type'] . implode('-', $this->elc_path_array) . $this->ls['pathstring'];
        if (isset ($this->fill[$insertkey]) and $this->output_action == "xml") {
            $this->write_xml($this->fill[$insertkey]);
        }
    }

    /**
    * Startet den Parser und gibt die gefundenen Daten oder false zurück.
    *
    * @access public
    * @return array
    */
    function xml_stream() // Code aus PHP-Manual
    {
        if ($this->outfile) {
            $this->of = fopen ($this->outfile, "w") or die("Fehler beim Öffnen der Ausgabe");
        }

        $this->parser = xml_parser_create();
        // Parser-Funktionen im Objekt:
        xml_set_object($this->parser, &$this);
        xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, false);
        xml_set_default_handler($this->parser, "defaultData");
        xml_set_element_handler($this->parser, "startElement", "endElement");
        xml_set_character_data_handler($this->parser, "characterData");
		$string_flag=true; //Zeiger setzen für Eingabeformat.
		//Ermitteln der Eingabe. String enthält auf jeden Fall < Klammer.
		//Dateiname auf jeden Fall keine!
        $pos = strpos ($this->file, "<");
        if ($pos === false) { // Achtung: 3 Gleichheits-Zeichen
           $string_flag=false;
        }

        if (! $string_flag) {
	        if (!($fp = fopen($this->file, "r"))) {
	            die ("could not open XML input");
	        } while ($data = fread($fp, 4096)) {
	            if (!xml_parse($this->parser, $data, feof($fp))) {
	                /*die (sprintf("XML error: %s at line %d",
	                        xml_error_string(xml_get_error_code($this->parser)),
	                        xml_get_current_line_number($this->parser)));*/
					trigger_error('XML kaputt', E_USER_NOTICE);
					return false;
	            }
	        }
        }  else {
 		   $data=$this->file;
           if (!xml_parse($this->parser, $data)) {
                /*die (sprintf("XML error: %s at line %d",
                        xml_error_string(xml_get_error_code($this->parser)),
                        xml_get_current_line_number($this->parser)));*/
			   trigger_error('XML kaputt', E_USER_NOTICE);
			   return false;
            }
        }
		//===================================
        xml_parser_free($this->parser);
        // Ausgabe schließen ====================
        if ($this->outfile) {
            fclose($this->of) or die("Fehler beim Schließen der Ausgabe!");
        }
		if (! $string_flag) {  //Falls Eingabedatei gelesen wurde
	        fclose($fp) or die("Fehler beim Schließen der Eingabedatei!");
		}
        return $this->found_data;
    }

    /**
    * Sorgt für die Ausgabe von Kommentaren und Doctype.
    *
    * @param integer $parser resource_id
    * @param string $ddata
    */
    function defaultData($parser, $ddata)
    {
        // DefaultData direkt ausgeben ===
        if ($this->write_flag and $this->ignore_default_data == false) {
            if ($this->output_action == "xml") $this->write_xml($ddata);
            else if ($this->output_action == "csv") {
                $this->write_csv("X;" . $this->level . ";" . $this->path_string(0) . ";'';" . $ddata);
            }
        }
    }

    /**
    * Aktionen beim Auftauchen eines Starttags
    *
    * @param integer $parser resource
    * @param string $name
    * @param array $attrs
    * @access private
    */
    function startElement($parser, $name, $attrs)
    {
        // Vor dem Element können ebenfalls Daten sein :
        if ($this->level > 0) { // Nichts vor das Wurzelelement schreiben!
            if ($this->data_buffer) { // Wenn Daten im Puffer sind
                $this->ls['type'] = "D"; //Data
                $this->ls['level'] = $this->level;
                $this->ls['pathstring'] = $this->path_string(0);
                $this->ls['attrn'] = "";
                $this->ls['data'] = $this->data_buffer;
                $this->data_buffer = ""; //Reset
                $this->xml_action();
            }
        }
        // Aktuelles Element global bekannt machen.
        $this->akt_name = $name;
        $this->level++;
        // =========  Counter  =====================================================
        // nur wenn Counter gesetzt ist
        if ($this->el_counter != "") {
            // Counter ist noch unberührt
            if ($this->el_counter == "set") {
                $this->el_counter = array();

                $this->el_counter[$this->akt_name] = array ('all' => 1,
                    $this->level => 1);
            } else { // Counter wurde schon benutzt
                if (isset($this->el_counter[$this->akt_name])) {
                    $this->el_counter[$this->akt_name]['all']++;
                    if (isset($this->el_counter[$this->akt_name][$this->level])) {
                        $this->el_counter[$this->akt_name][$this->level] ++;
                    } else { // neuer Level
                        $this->el_counter[$this->akt_name][$this->level] = 1;
                    }
                } else {
                    $this->el_counter[$this->akt_name] = array ('all' => 1,
                        $this->level => 1);
                }
            }
        }

        $this->ls['type'] = "S"; //Starttag
        $this->ls['level'] = $this->level;
        $this->ls['pathstring'] = $this->path_string(1);
        $this->ls['attrn'] = "";
        $this->ls['data'] = "";
        // Werden schon im Starttag für Replace gebraucht!
        $this->temp_attr_buffer[$this->ls['pathstring']] = $attrs;
        $this->xml_action();
        // Wenn Attribute hinzugefügt werden sollen, wird das hier gemacht:
        // Die Attribute sind im Hash gespeichert
        $aktattrbuffer = "S" . implode('-', $this->elc_path_array) . $this->path_string(0);
        if (isset($this->fillattr[$aktattrbuffer])) {
            // Attributhash anfügen
            $attrs = array_merge($attrs, $this->fillattr[$aktattrbuffer]);
            // Arrays zusammenfügen.
        }

        foreach($attrs as $key => $value) {
            $this->ls['type'] = "A"; //Attribut
            $this->ls['level'] = $this->level;
            $this->ls['pathstring'] = $this->path_string(0);
            $this->ls['attrn'] = $key;
            $this->ls['data'] = $value;
            $this->xml_action();
        }
        // Endmarke Starttag:
        $this->ls['type'] = "EOS"; //Data
        $this->ls['level'] = $this->level;
        $this->ls['pathstring'] = $this->path_string(0);
        $this->ls['attrn'] = "";
        $this->ls['data'] = "";
        $this->xml_action();
    }

    /**
    * Standard-XML-Parser-Funktion
    *
    * @param integer $parser resource
    * @param string $name
    * @access private
    */
    function endElement($parser, $name)
    {
        // Jedes Element, das sonst leer wäre, oder nur Whitespace enthält, bekommt
        // temporär eine Kennung '$this->tmp_sign'.
		 if ($this->ls['data'] == "" and $this->data_buffer == "") {
      //  if ($this->ls['data'] == "" and trim($this->data_buffer) == "") {
            $this->data_buffer = $this->tmp_sign . $this->ls['data'];
        }

        $this->ls['type'] = "D"; //Data
        $this->ls['level'] = $this->level;
        $this->ls['pathstring'] = $this->path_string(0);
        $this->ls['attrn'] = "";
        // Wenn das Element geschlossen wurde, werden die gesammelten Daten geschrieben.
        $this->ls['data'] = $this->data_buffer;
        $this->xml_action();
        /* todo: stimmt so noch nicht im record-mode (Fehler), daher vorübergehend deaktiviert
        // Element wird geschlossen und Attribute werden nicht mehr gebraucht:
        if (isset($this->temp_attr_buffer[$this->ls['pathstring']])) {
            unset($this->temp_attr_buffer[$this->ls['pathstring']]);
        }
		*/
        // Für Einfügungen hinter dem Endtag
        $this->ls['type'] = "BE"; //Before End
        $this->ls['level'] = $this->level;
        $this->ls['pathstring'] = $this->path_string(0);
        $this->ls['attrn'] = "";
        // Wenn das Element geschlossen wurde, werden die gesammelten Daten geschrieben.
        $this->ls['data'] = "";
        $this->xml_action();
        // =============================================================
        $this->ls['type'] = "E"; //End
        $this->ls['level'] = $this->level;
        $this->ls['pathstring'] = $this->path_string(-1);
        $this->ls['attrn'] = "";
        $this->ls['data'] = "";
        $this->xml_action();
        $this->level--;
        array_pop($this->elc_path_array); // Darf erst nach der Action gekürzt werden!!!
        $this->data_buffer = ""; //Reset
    }

    /**
    * Standard-XML-Parser-Funktion
    *
    * @param integer $parser resource
    * @param string $data
    * @access private
    */
    function characterData($parser, $data)
    {
        // Achtung! $data wird in mehreren Teilen ausgegeben. Daher wird hier gesammelt.
        $this->data_buffer .= $data; //Daten sammeln und zusammenführen
    }

    /**
    * Level-Counter-Funktion
    * Registriert die Ebene des XML-Elements und aktualisiert den "Pfad" des
    * aktuellen Elements im $path_array. Liefert einen String aus allen Werten
    * des $path_array zurück
    * Gleichzeitig werden alle gleichnamigen Elemente gezählt, solange sie sich innerhalb
    * eines übergeordeten Elements befinden:
    * $elc[3]["haus"] gibt z.B. an,
    *
    * @param integer $plusminus
    * @return string
    * @access private
    */
    function path_string($plusminus)
    {
        if ($plusminus == 1) {
            $this->path_array[] = $this->akt_name;
            $tmp = join('/', $this->path_array);
            // element-level-counter
            if (!isset($this->elc[count($this->path_array)][$this->akt_name])) {
                $this->elc[count($this->path_array)][$this->akt_name] = 1;
            } else {
                $this->elc[count($this->path_array)][$this->akt_name]++;
            }
            // array enthält nur die aktuellen Zählerwerte:
            $this->elc_path_array[] = $this->elc[count($this->path_array)][$this->akt_name];
        } else if ($plusminus == -1) {
            // Zähler für Elemente innerhalb des Elements abschließen.
            $this->elc[count($this->path_array) + 1] = array();
            // Datapart-counter abschließen:
            $tmp = join('/', $this->path_array); //Wert erst nach Rückgabe herunterzählen
            array_pop($this->path_array);
        } else {
            $tmp = join('/', $this->path_array);
        }
        return $tmp;
    }

    /**
    * Setzt die Abfrage für die Werte des Attributs oder der Attribute, die der Vorgabe
    * entsprechen. Ohne Parameter werden alle Werte in das Ergebnis-Array geschrieben.
    *
    * @param integer $limit optional  0 bedeutet: kein Limit
    * @param string $path optional
    * @param string $pattern optional
    * @param string $attrn optional
    * @param string $elcount optional
    * @access public
    */
    function get_attribute($limit = 0, $path = "", $pattern = "", $attrn = "", $elcount = "")
    {
        $arg = array($limit, $path, $pattern, $attrn, $elcount);
        $this->set_action("find_attribute", $arg);
    }

    /**
    * Setzt eine Änderungsabfrage. Funktioniert ähnlich wie get_attribute. Die dort übergebenen
    * Parameter werden hier als Array übergeben. Als zweiter Parameter kommt der String oder
    * die Zahl, die den alten Wert ersetzt. Die Funktion wird sooft angewendet, wie sie auf
    * die Abfrage trifft. Der entfernte Wert wird nicht gespeichert.
    *
    * @param array $arg
    * @param mixed $value (string or integer)
    * @access public
    * @see get_attribute()
    */
    function change_attribute_value($arg, $value)
    {
        $this->set_action("find_attribute", $arg, "change_attribute", $value);
    }

    /**
    * Löscht das angegebene Attribut.
    *
    * @param array $arg
    * @see get_attribute()
    * @access public
    */
    function delete_attribute($arg)
    {
        $this->set_action("find_attribute", $arg, "delete_attribute");
    }

    /**
    * Ersetzt das angegebene Attribut durch ein anderes.
    *
    * @param array $arg
    * @param array $newattr
    * @see get_attribute()
    * @access public
    */
    function replace_attribute($arg, $newattr)
    {
        $this->set_action("find_attribute", $arg, "replace_attribute", $newattr);
    }

    /**
    * Eigentliche Funktion für die Verarbeitung der Abfragen.
    * Übernimmt das Sucharray, optional den Namen der Funktion zur Modifizierung der Aktion
    * und eventuell einen neuen Wert bzw. Werte.
    *
    * @param array $arg
    * @param string $command optional
    * @param mixed $newvalue optional (string or array)
    * @access private
    */
    function find_attribute ($arg, $command = "", $newvalue = "")
    {
        $limit = (isset($arg[0])) ? $arg[0] : 0;
        $path = (isset($arg[1])) ? $arg[1] : "";
        $pattern = (isset($arg[2])) ? $arg[2] : "";
        $attr = (isset($arg[3])) ? $arg[3] : "";
        // Attribut kommt hier als String!
        $elcount = (isset($arg[4])) ? $arg[4] : "";
        $elementname = array_pop(explode('/', $this->ls['pathstring']));
        if ($this->ls['type'] == "A") {
            // Sucht nur nach dem Schluss von $path, wenn nur der Elementname
            // angegeben wird.
            $tmp_path = $this->wildcardpath($path);
            if ($path == "" or $path == $tmp_path or $path == array_pop(explode('/', $this->ls['pathstring']))) {
                // Attribute und Werte mit Suchmuster vergleichen
                if ($attr == "" or $attr == $this->ls['attrn']) {
                    if ($elcount == "" or $this->elc_check($elcount) == true) {
                        if ($pattern == "" or $pattern == $this->ls['data']) { // genaue Suche für den Attributwert!
                            if ($command == "") {
                                // $elementname = $this->path_array[count($this->path_array) - 1];
                                $this->found_data[$this->func_counter][] = array($this->ls['data'], $elementname, $this->ls['attrn'], $this->ls['pathstring'], implode('-', $this->elc_path_array));
                                $this->check_limit($this->func_counter, $limit); //Checken, ob die Funktion abrechen kann

                            } else if ($command == "change_attribute") $this->ls['data'] = $newvalue;
                            else if ($command == "delete_attribute") $this->write_flag = false;
                            else if ($command == "replace_attribute") {
                                list($this->ls['attrn'], $this->ls['data']) = each ($newvalue);
                            }
                        }
                    }
                }
            }
        }
    }

    /**
    * Ruft set_action auf und übergibt das Kommando "find_data" und die Suchkriterien als Parameter.
    * set_action wird bei fast jedem Event des Expat-Parsers aufgerufen, und ruft wiederum die
    * funktion find_data (und die übrigen gesetzen Funktionen) auf.
    *
    * @param integer $limit optional  Anzahl der gesuchten Treffer. 0 = keine Einschränkung
    * @param string $path optional  root/element1/element2   (kann unvollständig sein, z.B. element2)
    * @param string $pattern optional  String, der in den gesuchten Daten enthalten sein muss
    * @param mixed $attrn optional  array(name=>value, name2=>value2) Attribut(e) müssen enthalten sein.
    * @param string $elcount optional  "1-6-2" oder "1-4-6:2" oder "1-6-{3 to 5}" oder "1-6-{3,5,8}"
    * @access public
    */
    function get_data ($limit = 0, $path = "", $pattern = "", $attrn = "", $elcount = "")
    {
        $this->set_action("find_data", array($limit, $path, $pattern, $attrn, $elcount));
    }

    /**
    * Übergibt das Kommando, alle Elemente innerhalb dieses Elementes als Ergebnis zurückzuliefern.
    * Alle enthaltenen Elemente werden geliefert, in dem ein Zeiger gesetzt wird, der erst wieder
    * entfernt wird, wenn das Schlusstag gefunden wurde.
    *
    * @param integer $limit
	* @param string  $path
    * @param string  $pattern
    * @param mixed   $attrn
    * @param string  $elcount
    * @see get_data()
    * @access public
    */
    function get_record ($limit = 0, $path = "", $pattern = "", $attrn = "", $elcount = "")
    {
        $this->set_action("find_data", array($limit, $path, $pattern, $attrn, $elcount), "get_record");
    }

    /**
    * Ersetzt den gefundenen String durch einen neuen.
    * Zusätzlich zur Parameterliste $arg wird ein Wert übergeben, der den gefundenen String ersetzt.
    *
    * @param array $arg
    * @param string $value
    * @see get_data()
    * @access public
    */
    function change_data ($arg, $value)
    {
        $this->set_action("find_data", $arg, "change_data", $value);
    }

    /**
    * Hängt den neuen Inhalt an den Wert an
    * Zusätzlich zur Parameterliste $arg wird ein Wert übergeben, der den gefundenen String erweitert.
    *
    * @param array $arg
    * @param string $value
    * @see get_data()
    * @access public
    */
    function append_data ($arg, $value)
    {
        $this->set_action("find_data", $arg, "append_data", $value);
    }

    /**
    * Löscht das gesuchte Element und seinen Inhalt, indem die Ausgabe unterbrochen wird.
    *
    * @param integer $limit optional  Anzahl der gesuchten Treffer. Danach wird die Funktion beendet
    * @param string $path optional  root/element1/element2   (kann unvollständig sein, z.B. element2)
    * @param string $pattern optional  String, der in den gesuchten Daten enthalten sein muss
    * @param mixed $attrn optional  array(name=>value, name2=>value2) Attribut(e) müssen enthalten sein.
    * @param string $elcount optional  "1-6-2" oder "1-4-6:2" oder "1-6-{3 to 5}" oder "1-6-{3,5,8}"
    * @access public
    * @see get_attribute()
    */
    function delete_element ($limit = 0, $path = "", $pattern = "", $attrn = "", $elcount = "")
    {
        $this->set_action("find_data", array($limit, $path, $pattern, $attrn, $elcount), "delete_element");
    }

    /**
    * Ist identisch mit delete_element. Zusätzlich werden Daten in einen Speicher (fill)
    * geschrieben und dieser beim Erreichen der Marke in die Ausgabe eingefügt.
    *
    * @param array $arg
    * @param string $replace
    * @access public
    * @see get_data()
    */
    function replace_element ($arg, $replace)
    {
        $this->set_action("find_data", $arg, "delete_element", $replace);
    }

    /**
    * Löscht den Inhalt des gesuchten Elements, indem die Ausgabe unterbrochen wird.
    *
    * @param integer $limit optional  Anzahl der gesuchten Treffer. Danach wird die Funktion beendet
    * @param string $path optional  root/element1/element2   (kann unvollständig sein, z.B. element2)
    * @param string $pattern optional  String, der in den gesuchten Daten enthalten sein muss
    * @param mixed $attrn optional  array(name=>value, name2=>value2) Attribut(e) müssen enthalten sein.
    * @param string $elcount optional  "1-6-2" oder "1-4-6:2" oder "1-6-{3 to 5}" oder "1-6-{3,5,8}"
    * @access public
    * @see get_attribute()
    */
    function delete_content ($limit = 0, $path = "", $pattern = "", $attrn = "", $elcount = "")
    {
        $this->set_action("find_data", array($limit, $path, $pattern, $attrn, $elcount), "delete_content");
    }

// neu ============================================
    function get_content ($limit = 0, $path = "", $pattern = "", $attrn = "", $elcount = "")
    {
        $this->set_action("find_data", array($limit, $path, $pattern, $attrn, $elcount), "get_content");
    }


	  // gleiche Funktion wie oben. Replace-Parameter wird als flag missbraucht.
	// "CB" signalisiert, dass am Ende die Start- und Endtag eingefügt werden.
    function copy_brench ($limit = 0, $path = "", $pattern = "", $attrn = "", $elcount = "")
    {
        $this->set_action("find_data", array($limit, $path, $pattern, $attrn, $elcount), "get_content", "CB");
    }
   //============ neu Ende ================================


    /**
    *   == replace_content
    * Ist identisch mit delete_content. Zusätzlich werden Daten in einen Speicher (fill)
    * geschrieben und dieser beim Erreichen der Marke in die Ausgabe eingefügt.
    *
    * @param array $arg
    * @param string $replace
    * @access public
    * @see get_data()
    */
    function replace_content ($arg, $replace)
    {
        $this->set_action("find_data", $arg, "delete_content", $replace);
    }

    /**
    *  Fügt Element(e) oder XML-Code an der gesuchten Stelle ein.
    * Der Inhalt wird direkt hinter dem Start-Tag eingesetzt.
    * Man kann dadurch auch den Zwischenraum zwischen zwei Starttags füllen, selbt wenn
    * dort kein Leerzeichen ist. <p><b>wort</b>text</p>. Eingefügt wird so:
    * <p>neuer Text<b>wort</b>text</p>
    * Es können auch leere Elemente gefüllt werden: <textarea></textarea>
    * <textarea>Text</textarea>
    *
    * @param array $arg
    * @param string $insert
    * @access public
    * @see get_data()
    */
    function insert_element ($arg, $insert)
    {
        $this->set_action("find_data", $arg, "insert_element", $insert);
    }

    /**
    * Fügt Attribute in einem Hash hinzu. Nutzt ebenfalls die Startelementmarke und nicht die Attributmarke,
    * weil direkt auf das Expat-Attributarray zugegriffen wird, bevor dieses weiter verarbeitet wird.
    * (Das muss man sich klar machen, wenn zunächst Attribute zugefügt und gleichzeitig nach gleichnamigen
    * Attributen gesucht wird!)
    *
    * @param array $arg
    * @param string $insert
    * @access public
    * @see get_data()
    */
    function add_attributes ($arg, $insert)
    {
        $this->set_action("find_data", $arg, "add_attributes", $insert);
    }

    /**
    * Fügt XML-Code oder einen String hinter dem End-Tag eines Elements ein.
    *
    * @param array $arg
    * @param string $insert
    * @access public
    * @see get_data()
    */
    function insert_after_element ($arg, $insert)
    {
        $this->set_action("find_data", $arg, "insert_after_element", $insert);
    }

    /**
    * Fügt einen String vor dem End-Tag eines Elements ein.
    *
    * @param array $arg
    * @param string $insert
    * @access public
    * @see get_data()
    */
    function insert_before_end ($arg, $insert)
    {
        $this->set_action("find_data", $arg, "insert_before_end", $insert);
    }

    /**
    * Findet und liefert den Elementinhalt mit einem bestimmten id-Attribut,
    * z.B. find_data_by_id(15); <Kiste id="1">Schrauben</Kiste>
    *
    * Shorthand für get_data(). Heißt "id" nicht "id" sondern "nr", kann der 2. Parameter
    * gesetzt werden. Damit wird aus der Funktion eigentlich ein find_data_by_attribute_name_value.
    *
    * @param string $value
    * @param string $idname optional (anderer Atrributname, wenn nicht "id")
    * @access public
    */
    function find_data_by_id($value, $idname = "id")
    {
        $this->set_action("find_data", array(0, "", "", array($idname => $value)));
    }

    /**
    * Ersetzt den Elementwert eines Elements mit einem bestimmten id-Attribut,
    * z.B. change_data_by_id(15,"Nägel"); <Kiste id="1">Schrauben</Kiste>
    *
    * @param string $value
    * @param string $replace
    * @param string $idname optional (anderer Atrributname, wenn nicht "id")
    * @access public
    * @see find_data_by_id()
    */
    function change_data_by_id($value, $replace, $idname = "id")
    {
        $this->set_action("find_data", array(0, "", "", array($idname => $value)), "change_data", $replace);
    }

    /**
    * Interne Hauptfunktion, die von den oben beschriebenen "Pseudofunktionen" in die Schleife gesetzt wird.
    *
    * @param array $arg bekannte Kriterienliste
    * @param string $command optional  Name der aufrufenden Funktion, damit differenziert werden kann
    * @param string $changedata optional  Ein Ersetzugs- oder Einsetzungsstring
    * @access private
    */
    function find_data($arg, $command = "", $changedata = "")
    {

        if ($this->ls['type'] == "A") return;
		$saveall = false;
        $limit = (isset($arg[0])) ? $arg[0] : 0;
        $path = (isset($arg[1])) ? $arg[1] : "";
        $pattern = (isset($arg[2])) ? $arg[2] : "";
        $attr = (isset($arg[3])) ? $arg[3] : "";
        // Attribute kommen als Hash name=>value rein
        $elcount = (isset($arg[4])) ? $arg[4] : "";
        $elementname = array_pop(explode('/', $this->ls['pathstring']));
        $elc_path_string = implode('-', $this->elc_path_array);
        $levelsig = implode('-', $this->elc_path_array); //aufräumen!!

        if ($command == "get_record" and $this->ls['type'] == "D" and isset($this->procdata[$this->func_counter]['recordmode'])) {
            $saveall = true;
            if (isset($this->procdata[$this->func_counter]['rowcounter'])) {
                $rc = $this->procdata[$this->func_counter]['rowcounter'];
            } else {
                $this->procdata[$this->func_counter]['rowcounter'] = 0;
                $rc = 0; //rowcounter
            }
        }

        if ($this->ls['type'] == "D" and ($command == "" or $command == "change_data" or $command == "get_record" or $command == "append_data") or
                ($this->ls['type'] == "S" and $command == "delete_element") or
                ($this->ls['type'] == "S" and $command == "add_attributes") or
                ($this->ls['type'] == "S" and $command == "get_record") or
                ($this->ls['type'] == "D" and $command == "insert_after_element") or
                ($this->ls['type'] == "E" and $command == "get_record") or
                ($this->ls['type'] == "BE" and $command == "insert_before_end") or
                ($this->ls['type'] == "EOS" and $command == "delete_content") or
				($this->ls['type'] == "EOS" and $command == "get_content") or
				($this->ls['type'] == "BE" and $command == "get_content") or
                ($this->ls['type'] == "EOS" and $command == "insert_element")
                and $this->write_flag == true) {
            if ($attr) {
                $attrcheck = false;
                $counter = count($attr); //Der Counter wird hochgesetzt auf die Attributzahl
                foreach ($attr as $k => $v) {
                    // Der Attributpuffer enthält die Werte zu den gesuchten Daten.
                    if (isset($this->temp_attr_buffer[$this->ls['pathstring']][$k])) {
                        if ($this->temp_attr_buffer[$this->ls['pathstring']][$k] == $v) {
                            $counter --; //Counter runterzählen.
                        }
                    }
                }
                if (!$counter) {
                    $attrcheck = true; //Wenn alle Attribute und Werte mit der Vorgabe
                } //überienstimmen, ist der Counter heruntergezählt.
            }

            $tmp_path = $this->wildcardpath($path);
            if ($saveall or $path == "" or $path == $tmp_path or $path == array_pop(explode('/', $this->ls['pathstring']))) {
                if ($saveall or $attr == "" or $attrcheck == true) {
                    // Teilsuche
                    if ($saveall or $pattern == "" or strstr($this->ls['data'], $pattern)) {
                        if ($saveall or $elcount == "" or $this->elc_check($elcount) == true) {
                            // Datapart:
                            if ($saveall or !isset($this->procdata[$this->func_counter]['datapart'])) {
                                $part = true;
                            } else {
                                // $levelsig = implode('-', $this->elc_path_array);
                                if (!isset($this->found_data_part[$this->func_counter . $this->ls['pathstring'] . $levelsig])) {
                                    $this->found_data_part[$this->func_counter . $this->ls['pathstring'] . $levelsig] = 1;
                                } else {
                                    $this->found_data_part[$this->func_counter . $this->ls['pathstring'] . $levelsig] ++;
                                }
                                if ($this->procdata[$this->func_counter]['datapart'] == $this->found_data_part[$this->func_counter . $this->ls['pathstring'] . $levelsig]) {
                                    $part = true;
                                } else {
                                    $part = false;
                                }
                            }

                            if ($saveall or $part == true) {
                                // $elc_path_string = implode('-', $this->elc_path_array);
                                if ($command == "") {
                                    // $elementname = $this->path_array[count($this->path_array) - 1];
                                    $this->found_data[$this->func_counter][] = array(str_replace($this->tmp_sign, '', $this->ls['data']), $elementname, $this->temp_attr_buffer[$this->ls['pathstring']], $this->ls['pathstring'], implode('-', $this->elc_path_array));
                                    $this->check_limit($this->func_counter, $limit); //Limit-Checkfunktion aufrufen

                                } else if ($saveall == true and $this->procdata[$this->func_counter]['recordmode'] != $this->ls['pathstring']) {
                                    // nur Elemente != Wurzelelement des Datensatzes
                                    if (trim($this->ls['data'] !="") or count($this->temp_attr_buffer[$this->ls['pathstring']])) {
                                        // der vollständige Suchpfad vom get_record-modus wird vom aktuellen Pfad abgezogen.
                                        // übrig bleibt das aktuelle Element oder ein Teilstring, falls es sich um ein
                                        // Child-Element handelt.
                                        $en = str_replace($this->procdata[$this->func_counter]['recordmode'] . '/', '', $this->ls['pathstring']);

                                        $data = str_replace($this->tmp_sign, '', trim($this->ls['data']));
                                        if (!isset($this->table_result[$this->func_counter][$rc][$en])) {
                                            $this->table_result[$this->func_counter][$rc][$en] = $data;
                                        } else if ($data != "") {
                                            $this->table_result[$this->func_counter][$rc][$en] .= "!!!" . $data;
                                            // Ist schon ein Wert im Ergebnis-Hash, wird der Wert angehängt, aber nur,
                                            // wenn er kein Leerstring ist.
                                        }
                                        // Attribute in Tabelle aufnehmen:
                                        foreach ($this->temp_attr_buffer[$this->ls['pathstring']] as $k => $v) {
                                            $this->table_result[$this->func_counter][$rc][$en . '@' . $k] = $v;
                                        }
                                    }
                                } else if ($command == 'get_record' and $this->ls['type'] == "S") {
                                    // Setzt die Marke aus Element- und Zählpfad, damit alle Ergebnisse des
                                    // Datensatzes registriert werden:
                                    $this->procdata[$this->func_counter]['recordmode'] = $this->ls['pathstring'];
                                } else if ($command == 'get_record' and $this->ls['type'] == "E") {
                                    // Recordmode killen -Todo: hier könnte jetzt das Attributarray gelöscht werden
                                    unset($this->procdata[$this->func_counter]['recordmode']);
                                    $this->procdata[$this->func_counter]['rowcounter']++;
                                    // hochzählen für nächsten Datensatz
                                } else if ($command == "change_data") {
                                    $this->ls['data'] = $changedata; //Setzt die übergebenen Daten ein.
                                } else if ($command == "append_data") {
                                    $this->ls['data'] .= $changedata; //hängt die übergebenen Daten an.
                                } else if ($command == "delete_element") {
                                    $this->write_flag = false;
                                    // Endmarke für den Nowrite-Vorgang definieren:
                                    $this->last_nowrite_line = "E" . $elc_path_string . $this->ls['pathstring'];
                                    // Wenn das Element ersetzt wird, passiert das nach der letzten Zeile
                                    if ($changedata) $this->fill[$this->last_nowrite_line] = $changedata;
                                } else if ($command == "delete_content") {
                                    $this->write_flag = false;
                                    // Endmarke für den Nowrite-Vorgang definieren:
                                    $this->last_nowrite_line = "BE" . $elc_path_string . $this->ls['pathstring'];
                                    // Klammer wird nicht geschlossen, daher muss sie wieder eingefügt werden.
                                   // if ($changedata) $this->fill[$this->last_nowrite_line] = '>' . $changedata;
								   //Klammer muss nachgetragen werden.
								   $this->fill[$this->last_nowrite_line] = '>' . $changedata;
                                    // if ($changedata) $this->fill[$this->last_nowrite_line] = $changedata;
                                } else if ($command == "get_content") {
								     if ($this->ls['type'] == "EOS") {
	                                     // Marke setzen, damit content in buffer geschrieben wird.
	                                     //Allgemeines Flag, um unnötige Arrayzugriffe zu vermeiden
	                                    $this->copy_flag[$this->func_counter] = "";
	                                     //Buffer für die Daten
	                                     //Eventuell schon einmal das Ergebnisarray schreiben und gepufferten String
	                                     //erst später nachtragen
									  } else if ($this->ls['type'] == "BE") {
									                                          //erste überflüssige Klammer von EOS wieder entfernen
                                           $copy_string= str_replace($this->tmp_sign, '', substr($this->copy_flag[$this->func_counter], 1));
										   if ($changedata == "CB" ) {
                                              //Elementtemplate erzeugen und Inhalt hineinpacken:
                                              $copy_string=sprintf($this->make_element($elementname, $this->temp_attr_buffer[$this->ls['pathstring']]), $copy_string);
										   }
                                           $this->found_data[$this->func_counter][] = array($copy_string, $elementname, $this->temp_attr_buffer[$this->ls['pathstring']], $this->ls['pathstring'], implode('-', $this->elc_path_array));
                             			   unset($this->copy_flag[$this->func_counter]);
                                      }
                                } else if ($command == "insert_element") {
                                    $insertline = "EOS" . $elc_path_string . $this->ls['pathstring'];
                                    if ($changedata) $this->fill[$insertline] = $changedata;
                                } else if ($command == "insert_before_end") {
                                    $insertline = "BE" . $elc_path_string . $this->ls['pathstring'];
                                    if ($changedata) $this->fill[$insertline] = $changedata;
                                } else if ($command == "insert_after_element") {
                                    $insertline = "E" . $elc_path_string . $this->ls['pathstring'];
                                    if ($changedata) $this->fill[$insertline] = $changedata;
                                } else if ($command == "add_attributes") {
                                    // Attribute werden als array übergeben
                                    // Kennung und pathstring reichen als Key!
                                    $insertline = "S" . $elc_path_string . $this->ls['pathstring'];
                                    if ($changedata) $this->fillattr[$insertline] = $changedata;
                                }
                            }
                        }
                    }
                }
            }
        }
    }


	//===========neu
    function make_element($eln, $attr_arr) {
       $attr_tpl= ' %s="%s"';
	   $attr_str="";
	   //Attributstring zusammen schrauben:
       foreach ($attr_arr as $k => $v) {
           $attr_str .= sprintf($attr_tpl, $k, $v);
	   }
	   //Template zurückliefern:
	   return '<' . $eln . $attr_str . '>%s</' . $eln . '>';
	}

	//

    /**
	* Prüft, ob das vorgegebene Limit der Suchergebnisse erreicht ist. Ist das der Fall,
	* wird die Funktion nicht mehr gebraucht.
	*
	* @param integer $funcnr Funktionsnummer
	* @param integer $lim vorgegebenes Limit
	* @access private
	* @see find_data()
    */
    function check_limit($funcnr, $lim)
    {
        $this->procdata[$funcnr]['limitcount']++;
        if ($this->procdata[$funcnr]['limitcount'] == $lim) {
            $this->action_func[$funcnr] = 0; //gesamtes Funktionsarray mit 0 überschreiben.
        }
    }

    /**
    * Um einen Wildcardstring mit dem aktuellen pathstring vergleichen zu können, wird
    * hier in den pathstring an entsprechender Stelle ebenfalls ein * eingefügt.
    * gibt es kein * wird normal verglichen.
	*
	* @param string $path
	* @access private
	* @see find_data()
    */
    function wildcardpath ($path)
    {
        if (strstr($path, '*')) { // wildcards im Pfad
            $tmp_path_array = explode('/', $path);
            $tmp_path = "";
            for ($i = 0; $i < count($this->path_array); $i++) {
                if (!isset($tmp_path_array[$i])) break; //Wenn der Index nicht mehr existiert
                // abbrechen
                $tmp_path .= ($tmp_path_array[$i] == '*') ? '*/' : $this->path_array[$i] . '/';
            }
            return substr ($tmp_path, 0, -1); //letzten Slash wieder entfernen

        } else {
            return $this->ls['pathstring'];
        }
    }

    /**
    * Hilfsfuktion: vergleicht den gesuchten element-counter-string mit dem aktuellen
    *
    * @param  string $search_elcstring
    * @return boolean
    * @access private
    */
    function elc_check($search_elcstring)
    {
        if (! strstr($search_elcstring, '{')) {
            // direkter Stringvergleich
            $act_string = join ("-", $this->elc_path_array);
            if ($search_elcstring == $act_string) {
                return true;
            }
        } else if (! strstr($search_elcstring, '-')) {
            // nur ein Wert 1. Level aber unterschiedlich, sonst hätte es oben gepasst
            return false;
        } else if (count(explode('-', $search_elcstring)) != count($this->elc_path_array)) {
            // arrays haben unterschiedliche Länge, können also nicht passen.
            return false;
        } else {
            // Prüfung der Einzelwerte
            $search_array = explode("-", $search_elcstring);
            for ($i = 0; $i < count($search_array); $i++) {
                if (($search_array[$i] != $this->elc_path_array[$i]) and (strstr($search_array[$i], '}') == false)) {
                    return false;
                } else if (strstr($search_array[$i], '*')) {
                    // wildcard *;
                } else if (strstr($search_array[$i], ',')) {
                    $search_array[$i] = str_replace ('{', '', $search_array[$i]);
                    $search_array[$i] = str_replace ('}', '', $search_array[$i]);
                    $temparray = explode(',', $search_array[$i]);
                    if (! in_array($this->elc_path_array[$i], $temparray)) {
                        return false;
                    }
                } else if (preg_match("/(\d+)\s*to\s*(\d+)/i", $search_array[$i], $matches)) {
                    if ($this->elc_path_array[$i] < $matches[1] or $this->elc_path_array[$i] > $matches[2]) {
                        return false;
                    }
                }
            }
            return true;
        }
    }

    /**
    * Experimentelle Funktion, die vielleicht wieder verschwindet. Mit ihr kann der aktuelle
    * "Linestring" als csv ausgegeben werden (buffer oder Datei). Dies ermöglicht z.B. eine
    * komprimierte Darstellung
    * einer XML-Datei, die in jeder Zeile ein Event hat. Das könnte für umfangreiche Arbeiten mit
    * großen Dateien interessant sein.
    *
    * @param string $linestring optional   Daten die eingefügt werden
    * @access private
    */
    function write_csv($linestring = "")
    {
        if (!$linestring) {
            $linestring .= $this->ls['type'] . ";";
            $linestring .= $this->ls['level'] . ";";
            $linestring .= $this->ls['pathstring'] . ";";
            $linestring .= $this->ls['attrn'] . ";";
            $linestring .= addslashes(($this->ls['data']));
        }
        $linestring .= "\n"; //Zeilenende ist nicht eindeutig

        if ($this->outfile) {
            fwrite($this->of, $linestring);
        } else if ($this->output_action) {
            $this->csv_buffer .= $linestring;
        }
    }

    /**
    * Interne Funktion. Schreibt in Datei falls vorhanden oder in String
    * Falls ein Einfügestring übergeben wurde, wird dieser eingefügt,
    * sonst wird die XML-Ausgabe von get_xml generiert.
    *
    * @param string $insert optional   String der eingefügt (zwischengeschaltet) wird
    * @access private
    */
    function write_xml($insert = "")
    {
        if (! $this->highlight) {
            $xmlstring = ($insert) ? $insert : $this->get_xml();
        } else {
            $xmlstring = ($insert) ? htmlentities_wrapper($insert) : $this->get_hi_xml();
        }
        if ($this->outfile) {
            fwrite($this->of, $xmlstring);
        } else if ($this->output_action) {
            $this->xml_buffer .= $xmlstring;
        }
    }

	//===========neu ==============
    function copy_xml()
    {
       $xmlstring = $this->get_xml();
	   foreach( $this->copy_flag as $k=>$v) {
          $this->copy_flag[$k] .= $xmlstring;
	   }
    }

    /**
    * Baut die XML-Ausgabe wieder zusammen.
    *
    * @access private
    */
    function get_xml()
    {
        if ($this->ls['type'] == "S") {
            $el = strrchr($this->ls['pathstring'], '/');
            $element = (!$el) ? $this->ls['pathstring'] : substr($el, 1);
            return "<" . $element;
        } else if ($this->ls['type'] == "E") {
            $el = strrchr($this->ls['pathstring'], '/');
            $element = (!$el) ? $this->ls['pathstring'] : substr($el, 1);
            return "</" . $element . ">";
        } else if ($this->ls['type'] == "D") {
            // return $this->ls['data'];
            return str_replace($this->tmp_sign, '', $this->ls['data']);
        } else if ($this->ls['type'] == "A") {
            // wichtig: Single-Line-Modus falls Attribut getrennt wird.
            return ' ' . $this->ls['attrn'] . '="' . $this->ls['data'] . '"';
        } else if ($this->ls['type'] == "EOS") {
            return '>'; //Tag schließen
        }
    }

    /**
    * Verantwortlich für die Ausgabe von XML als HTML mit Syntaxhighlighting mit span-Elementen und
    * class-Attributen. Diese Funktion wird aktiv wenn als Rückgabeformat nicht 'xml' sondern 'hixml'
    * angegeben wird. - Todo: eventuell Umbau für <pre>-Ausgabe
    *
    * @access private
    */
    function get_hi_xml()
    {
        $sp = ""; //Space für HTML
        if ($this->ls['type'] == "S") {
            $el = strrchr($this->ls['pathstring'], '/');
            $element = (!$el) ? $this->ls['pathstring'] : substr($el, 1);
            $newline = "";
            if ($this->breakset == false) $newline = "<br />\r\n";
            $this->breakset = true;
            $this->datafound = false; //Merker zurücksetzen
            return $newline . $this->sethtmlspace() . "<span class='klammer'>&lt;</span><span class='elname'>" . $element . "</span>";
        } else if ($this->ls['type'] == "E") {
            $el = strrchr($this->ls['pathstring'], '/');
            $element = (!$el) ? $this->ls['pathstring'] : substr($el, 1);
            if ($this->breakset == true) {
                $sp = $this->sethtmlspace();
            }
            $this->breakset = true;
            $this->datafound = false;
            return $sp . "<span class='klammer'>&lt;/</span><span class='elname'>" . $element . "</span><span class='klammer'>&gt;</span><br />\r\n";
        } else if ($this->ls['type'] == "D") {
            // Elementinahlt in Variable packen und prüfen, ob sie leer ist.
            // wenn ja, Flag setzen.
            $br = "";
            // Falls XML eingefügt wird
            if ($tmpdata = htmlentities_wrapper(trim(str_replace($this->tmp_sign, '', $this->ls['data'])))) {
                $this->datafound = true;
                if ($this->breakset == true) {
                    $sp = $this->sethtmlspace();
                    $br = "<br />\r\n";
                }
            } else {
                $this->datafound = false;
            }

            return $sp . $tmpdata . $br; //Space und Daten zurückgeben
        } else if ($this->ls['type'] == "A") {
            // wichtig: Single-Line-Modus falls Attribut getrennt wird.
            return " <span class='attname'>" . $this->ls['attrn'] . "</span>=&quot;<span class='attr'>" . trim($this->ls['data']) . "</span>&quot;";
        } else if ($this->ls['type'] == "EOS") {
            $this->datafound = false;
            $this->breakset = false;
            return "<span class='klammer'>&gt;</span>";
        }
    }
    /**
    * Rückt die Highlight-Ausgabe ein. wird nur von der Funktion get_high_xml benutzt.
    *
    * @see get_hi_xml()
    * @access private
    */
    function sethtmlspace()
    {
        $space = "";
        for ($i = 1; $i < $this->level; $i++) {
            $space .= " &nbsp; - &nbsp;";
        }
        return $space;
    }

    /**
    * Liefert den Output als String, wenn diese Variante gewählt wurde.
    * Es wird geprüft, ob entweder der XML- oder der CSV-Buffer Inhalt hat.
    *
    * @access public
    */
    function get_output()
    {
        if ($this->xml_buffer) {
            return $this->xml_buffer;
        } else if ($this->csv_buffer) {
            return $this->csv_buffer;
        } else {
            return false;
        }
    }

    /**
    * Experimentell.
    * Liefert das Array zurück, in dem die Elemente gezählt werden. Kann für
    * statistische Zwecke genutzt werden. Die Funktion setzt voraus, dass
    * der Zähler gesetzt wurde. Anzeige im Browser z.B.
    * mit print_r(get_element_counter_array())
    *
    * @access public
    */
    function get_element_counter_array()
    {
        return $this->el_counter;
    }
}

?>