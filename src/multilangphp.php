<?php
namespace multilangphp;

/**
 * multilangPHP - PHP multi language support library
 * NOTE: Requires PHP version 7.0 or later
 * @package multilangPHP
 * @author Melih Berat ŞANLI
 * @copyright 2019 Melih Berat ŞANLI
 * @version 2.0.1
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */
class multilangphp
{
    private $language = "tr";
    private $dir = "system/lang/";
    private $from = "php";
    private $definedExtension = [
        "php",
        "json"
    ];

    /**
     * Get the value of language
     *
     * @return string
     */ 
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * Set the value of language
     *
     * @param string $language
     * @return self
     */ 
    public function setLanguage(string $language): self
    {
        $this->language = $language;
        return $this;
    }

    /**
     * Get the value of dir
     *
     * @return string
     */ 
    public function getDir(): string
    {
        return $this->dir;
    }

    /**
     * Set the value of dir
     *
     * @param string $dir
     * @return self
     */ 
    public function setDir(string $dir): self
    {
        $this->dir = $dir;
        return $this;
    }

    /**
     * Get the value of from
     *
     * @return string
     */ 
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * Set the value of from
     *
     * @param string $from
     * @return self
     */ 
    public function setFrom(string $from): self
    {
        if(!in_array($from, $this->definedExtension))
        {
            $usable = "";
            foreach($this->definedExtension as $tip) $usable .= sprintf(' "%s",', $tip);
            $usable = substr($usable, 0, -1);
            exit("MultilangPHP: You can only use the". $usable . ' parameters.');
        }
        $this->from = $from;
        return $this;
    }

    /**
     * Get exact location of the language file
     *
     * @return string
     */
    public function getLangFile(): string
    {
        return sprintf("%s%s.%s", $this->getDir(), $this->getLanguage(), $this->getFrom());
    }

    /**
     * Control File Extension Function
     * 
     * if file extension correct; return true
     *
     * @param string $file
     * @param string $extension
     * @return boolean
     */
    public function controlFileExtention(string $file, string $extension = null): bool
    {
        if (!$extension) $extension = $this->getFrom();
        $fKontrol = explode(".", $file);
        if($fKontrol[count($fKontrol)-1] == $extension) return true;
        return false;
    }

    /**
     * Return language(s) in selected directory
     *
     * @param string $returnType
     * @return array|string
     */
    public function listAllLangFiles(string $returnType = "array")
    {
        if ($returnType == "array" || $returnType == "html")
        {
            $langPHP_array = array();
            $langPHP_html = '<div class="multilang">';
            $openDir = opendir($this->getDir());
            while (($file = readdir($openDir)) != FALSE ) {
                if ($file =='.' || $file == '..' || is_file($file) || !$this->controlFileExtention($file)) continue;
                if ($returnType == "array") $langPHP_array[basename($file, sprintf(".%s",$this->getFrom()))] = $file;
                if ($returnType == "html") $langPHP_html .= sprintf(' <a href="?lang=%s" title="language %s">%s</a> ', basename($file, sprintf('.%s', $this->getFrom())), basename($file, sprintf('.%s', $this->getFrom())), basename($file, sprintf('.%s', $this->getFrom())));
            }
            $langPHP_html .= '</div>';
            closedir($openDir);
            return $returnType == "array" ? $langPHP_array : $langPHP_html;
        }
        exit("MultilangPHP: You can only use the 'array' and 'html' parameters on ".__METHOD__."()");
    }

    /**
     * If set From php, we are getting languages in php file
     *
     * @param string $called
     * @return string
     */
    public function callInPHP(string $called): string
    {
        $call = include($this->getLangFile());
        if (!is_array($call)) exit("MultilangPHP: Some have problem in language file, file is not returning array: ".__METHOD__."()");
        return $call[$called];
    }

    /**
     * If set $from json, we are getting languages in json file
     *
     * @param string $called
     * @return string
     */
    public function callInJSON(string $called): string
    {
        $call = file_get_contents($this->getLangFile());
        if (!$call) exit("MultilangPHP: JSON file not readable!");
        $decodeCall = json_decode($call, true);
        if (is_array($decodeCall) && !$decodeCall[$called]) $decodeCall = $decodeCall[0];
        return $decodeCall[$called] ? $decodeCall[$called] : exit(sprintf('multilangPHP: "%s" not found in %s file', $called, $this->getLangFile()));
    }

    /**
     * Call method
     *
     * @param string $value
     * @return string
     */
    public function call(string $value): string
    {
        if (!$value) exit("MultilangPHP: You have to use with a parameter on ".__METHOD__."()");
        return call_user_func(array($this, sprintf('callIn%s', strtoupper($this->getFrom()))), $value);
    }
}