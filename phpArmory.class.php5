<?php
/**
 * phpArmory is an embeddable class to retrieve XML data from the WoW armory.
 * 
 * phpArmory is an embeddable PHP5 class, which allow you to fetch XML data
 * from the World of Warcraft armory in order to display arena teams,
 * characters, guilds, and items on a web page.
 * @author Daniel S. Reichenbach <daniel.s.reichenbach@mac.com>
 * @copyright Copyright (c) 2008, Daniel S. Reichenbach
 * @license http://www.opensource.org/licenses/gpl-3.0.html GNU General Public License version 3
 * @link https://github.com/marenkay/phparmory/tree
 * @package phpArmory
 * @version 0.4.0
 */

/**
 * phpArmory5 class
 * 
 * A class to fetch and unserialize XML data from the World of Warcraft armory
 * site.
 * @package phpArmory
 * @subpackage classes
 */
class phpArmory5 {

    /**
     * Current version of the phpArmory5 class.
     * @access      private     
     * @var         string      Contains the current class version.
     */
    protected static $version = "0.4.0";

    /**
     * Current state of the phpArmory5 class. Allowed values are alpha, beta,
     * and release.
     * @access      private
     * @var         string      Contains the current versions' state.
     */
    protected static $version_state = "alpha";

    /**
     * The URL of the World of Warcraft armory website to be used.
     * @access      private     
     * @var         string      Contains the URL of the armory website.
     */
    private $armory = "http://www.wowarmory.com/";

    /**
     * The URL of the World of Warcraft website to be used.
     * @access      private     
     * @var         string      Contains the URL of the World of Warcraft website.
     */
    private $wow = "http://www.worldofwarcraft.com/";

    /**
     * The armory area to send requests to.
     * @access      private     
     * @var         string      Contains the area / region to be used.
     */
    private $areaName = "us";

    /**
     * The locale used to send requests.
     * @access      private     
     * @var         string      Contains the locale used to send requests.
     */
    private $localeName = "en";

    /**
     * The case sensitive name of a realm.
     * @access      private     
     * @var         string      Contains the case sensitive name of a realm.
     */
    private $realmName = "";

    /**
     * The case sensitive name of a arena team.
     * @access      private     
     * @var         string      Contains the case sensitive name of a arena team.
     */
    private $arenaTeam = "";

    /**
     * The case sensitive name of a guild.
     * @access      private     
     * @var         string      Contains the case sensitive name of a guild.
     */
    private $guildName = "";

    /**
     * The case sensitive name of a character.
     * @access      private     
     * @var         string      Contains the case sensitive name of a character.
     */
    private $characterName = "";

    /**
     * The default user agent for making HTTP requests.
     * @access      private     
     * @var         string      Contains the user agent string used to query the armory.
     */
    private $userAgent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; de; rv:1.8.1.11) Gecko/20071127 Firefox/2.0.0.11";

    /**
     * The amount of time in seconds after which to consider a connection timed
     * out if no data has been yet retrieved.
     * received.
     * @access      private     
     * @var         integer     Contains the nr# of seconds to wait between connection tries.
     */
    private $timeOut = 5;

    /**
     * Time of last download, used to insert a random delay to prevent armorys'
     * weird behaviour.
     * @access      private     
     * @var         integer     Contains the time passed since last download.
     */
    private $lastDownload = 0;

    /**
     * Number of retries for downloading data.
     * @access      private     
     * @var         integer     Contains the nr# of retries to perform in case of connection failures.
     */
    private $downloadRetries = 5;

    /**
     * phpArmory5 class constructor.
     * @access      public
     * @param       string      $areaName               
     * @param       int         $downloadRetries        
     * @return      mixed       $result                 Returns TRUE if the class could be instantiated properly. Returns FALSE and an error string, if the class could not be instantiated.
     */
    public function __construct($areaName = NULL, $downloadRetries = NULL) {

        if (!extension_loaded('curl') && !extension_loaded('xml')) {
            trigger_error("phpArmory (version " . self::$version . " - " . self::$version_state . " release): The PHP extensions \"curl\" and \"xml\" are required to use this class.", E_USER_ERROR);
        } else {
            trigger_error("phpArmory (version " . self::$version . " - " . self::$version_state . " release): Found \"curl\" and \"xml\" extensions.", E_USER_NOTICE);
        }
    }

    /**
     * phpArmory5 destructor.
     * @access      public
     */
    public function __destruct() {
        
    }

    /**
     * Provides information on the current area configuration of phpArmory.
     * @access      public
     * @return      array       $areaSettings           Returns an array with self::$armoy, self::$wow, and self::$areaName.
     */
    public function getArea() {
        
    }

    /**
     * Configure the area in which phpArmory should operate.
     * @access      protected
     * @param       string      $areaName               The area phpArmory should operate in.
     * @return      mixed       $result                 Returns TRUE if $areaName is valid. Returns FALSE and an error string, if $areaName is not valid.
     */
    protected function setArea($areaName) {
        
    }

    /**
     * Provides information on the current locale in which phpArmory returns data.
     * @access      public
     * @return      string      $localeName             Returns the current locales' name.
     */
    public function getLocale() {
        
    }

    /**
     * Configure the locale in which phpArmory should query the armory.
     * @access      protected
     * @param       string      $localeName             The locale to query data in.
     * @return      mixed       $result                 Returns TRUE if $localeName is valid. Returns FALSE and an error string, if $localeName is not valid.
     */
    protected function setLocale($localeName) {
        
    }

    /**
     * 
     * @access      protected
     * @param       string      $url                    URL of the page to fetch data from.
     * @param       string      $userAgent              The user agent making the GET request.
     * @param       integer     $timeout                The connection timeout in seconds.
     * @return      mixed       $result                 Returns TRUE if $url is valid, and could be fetched. Returns FALSE and an error string, if $url is not valid.
     */
    protected function getXmlData($url, $userAgent = NULL, $timeOut = NULL) {
        
        // If no user agent is defined, use our pre-defined userAgent from the class definition.
        if ( ($userAgent == NULL) && (self::$userAgent)) {

            $userAgent = self::$userAgent;

        }

        // If no timeout is defined, use our pre-defined timeout from the class definition.
        if ( ($timeOut == NULL) && (self::$timeOut)) {

            $timeout = self::$timeOut;

        }

        // Try to download from the given URL for a maximum of our pre-defined download retries from the class definition.
        for ( $i = 1; $i <= self::$downloadRetries; $i++ ) {

            if (time() < self::$lastDownload+1) {

                $delay = rand (1,2);
                trigger_error("phpArmory (version " . self::$version . " - " . self::$version_state . " release): Inserting fetch delay of" . $delay . " seconds.", E_USER_NOTICE);
                sleep($delay);    //random delay

            } // if

            trigger_error("phpArmory (version " . self::$version . " - " . self::$version_state . " release): Fetching [" . $url . "] (tries: #" . $i . ").", E_USER_NOTICE);
            $ch = curl_init();
            $timeout = self::$timeOut;

            curl_setopt ($ch, CURLOPT_URL, $url);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt ($ch, CURLOPT_USERAGENT, $userAgent);
            curl_setopt ($ch, CURLOPT_HEADER, 0);
            curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 0);
            curl_setopt ($ch, CURLOPT_FORBID_REUSE, 1);
            curl_setopt ($ch, CURLOPT_LOW_SPEED_LIMIT, 5);
            curl_setopt ($ch, CURLOPT_LOW_SPEED_TIME, $timeout);
            curl_setopt ($ch, CURLOPT_TIMEVALUE, $timeout*3);

            $f = curl_exec($ch);
            self::$lastDownload = time();
            
            // Disabled reporting of the fetched content in error logs. This may spam your host. Only uncomment this line if you are working on localhost aka 127.0.0.1.
            // trigger_error("phpArmory (version " . self::$version . " - " . self::$version_state . " release): Fetched content: " . $f, E_USER_NOTICE);
            
            curl_close($ch);

            if ( strpos($f,'errCode="noCharacter"') ) {

                return ("Character not found on armory, check spelling and area settings!");

            } // if

            if ( strpos($f,'errorhtml') AND $i <= self::$downloadRetries-1 ) {

                return ("Armory send an error page, retrying...");

            } else {

                if ( strlen($f) AND $i<=$this->retries-1 ) {

                    break;

                } else {

                    return ("No data, retrying...");

                } // if

            } // if

        } // for

        if ( strlen($f)<100 ) {

            return ("Download failed, giving up! Server response: ".$f);

        }

        return $f;

    }

    /**
     * Converts an XML string into an associative array, duplicating the XML structure.
     * @access      protected
     * @param       string      $xmlData                The XML data string to convert.
     * @param       bool        $includeTopTag          Whether or not the topmost XML tag should be included in the array. The default value for this is FALSE.
     * @param       bool        $lowerCaseTags          Whether or not tags should be set to lower case. Default value for this parameter is TRUE.
     * @return      array       $result                 An associative array duplicating the XML structure.
     */
    protected function & convertXmlToArray($xmlData, $includeTopTag = FALSE, $lowerCaseTags = TRUE) {

        $xmlArray = array();

        $parser = xml_parser_create();
        xml_parse_into_struct($parser, $xmlData, $vals, $index);
        xml_parser_free($parser);

        $temp = $depth = array();

        foreach ($vals as $value) {

            switch ($value['type']) {

                case 'open':
                case 'complete':
                    array_push($depth, $value['tag']);
                    $p = join('::', $depth);
                    if ($lowerCaseTags) {

                        $p = strtolower($p);
                        if (is_array($value['attributes']))
                            $value['attributes'] = array_change_key_case($value['attributes']);

                    }

                    $data = ( $value['attributes'] ? array($value['attributes']) : array());
                    $data = ( trim($value['value']) ? array_merge($data, array($value['value'])) : $data);

                    if ($temp[$p]) {

                        $temp[$p] = array_merge($temp[$p], $data);

                    } else {

                        $temp[$p] = $data;

                    }
                    
                    if ($value['type']=='complete') {

                        array_pop($depth);

                    }
                    break;

                case 'close':
                    array_pop($depth);
                break;

            }  // switch

        } // foreach
    
        if (!$includeTopTag) {

            unset($temp["page"]);

        }

        foreach ($temp as $key => $value) {

            if (count($value)==1) {

                $value = reset($value);

            }

            $levels = explode('::', $key);
            $num_levels = count($levels);

            if ($num_levels==1) {

                $xmlArray[$levels[0]] = $value;

            } else {

                $pointer = &$xmlArray;
                for ($i=0; $i<$num_levels; $i++) {

                    if ( !isset( $pointer[$levels[$i]] ) ) {

                        $pointer[$levels[$i]] = array();

                    }

                $pointer = &$pointer[$levels[$i]];

                } // for

            $pointer = $value;

            } // if

        } // foreach

        return ($includeTopTag ? $xmlArray : reset($xmlArray));

    }

    /**
     * Provides information on the current patch level of World of Warcraft.
     * @access      public
     * @return      array       $patchLevel             Returns an array with int $patchLevelMajor, int $patchLevelMinor, and int $patchLevelFix.
     */
    public function getPatchLevel() {
        
    }

    /**
     * Provides information on the current talent tree definitions used by all character classes World of Warcraft.
     * @access      public
     * @return      mixed       $result                 Returns an array containing TRUE and TalentDefinitions, otherwise FALSE and errorMessage.
     */
    public function getTalentData() {
        
    }

    /**
     * Provides information on a specific arena team.
     * @access      public
     * @param       string      $arenaName              The arena teams' name.
     * @param       string      $realmName              The arena teams' realm name.
     * @return      mixed       $result                 Returns an array containing TRUE and arenaTeamData if $arenaTeamName and $realmName are valid, otherwise FALSE and errorMessage.
     */
    public function getArenaTeamData($arenaTeamName, $realmName) {
        
    }

    /**
     * Provides information on a specific character.
     * @access      public
     * @param       string      $characterName          The characters' name.
     * @param       string      $realmName              The characters' realm name.
     * @return      mixed       $result                 Returns an array containing TRUE and characterData if $characterName and $realmName are valid, otherwise FALSE and errorMessage.
     */
    public function getCharacterData($characterName, $realmName) {
        
    }

    /**
     * Provides the link to the matching portrait icon for a charater.
     * @access      public
     * @param       array       $characterInfo          The characterinfo array returned by self::getCharacterData.
     * @return      string      $result                 Returns an array containing TRUE and characterIconURL if $characterInfo is valid, otherwise FALSE and errorMessage.
     */
    public function getCharacterIconURL() {
        
    }

    /**
     * Provides information on a specific guild.
     * @access      public
     * @param       string      $guildName              The guilds' name.
     * @param       string      $realmName              The guilds' realm name.
     * @return      mixed       $result                 Returns an array containing TRUE and characterData if $guildName and $realmName are valid, otherwise FALSE and errorMessage.
     */
    public function getGuildData($guildName = NULL, $realmName = NULL) {
        
    }

    /**
     * Provides information on a specific item by querying its' ID.
     * @access      public
     * @param       int         $itemID                 The items' ID.
     * @return      mixed       $result                 Returns an array containing TRUE and itemData if $itemID is valid, otherwise FALSE and errorMessage.
     */
    public function getItemData($itemID) {
        
    }

    /**
     * Provides information on a specific item by querying its' name.
     * @access      public
     * @param       string      $itemName               The items' name.
     * @param       string      $itemFilter             An associative array of search paramters.
     * @return      mixed       $result                 Returns an array containing TRUE and itemData if $itemID is valid, otherwise FALSE and errorMessage.
     */
    public function getItemDataByName($itemName, $filter = NULL) {
        
    }

}
?>