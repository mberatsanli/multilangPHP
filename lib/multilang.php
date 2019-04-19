<?php
/*
*~ multilang.php
.---------------------------------------------------------------------------.
|  Software: multiLangPHP								                                    |
|   Version: 1.0.0                                                          |
|   Contact: via sourceforge.net support pages (also www.worxware.com)      |
|      Info: http://phpmailer.sourceforge.net                               |
|   Support: http://sourceforge.net/projects/phpmailer/                     |
| ------------------------------------------------------------------------- |
|   Authors: Melih Berat ŞANLI (mberatsanli.com / github.io/mberatsanli)		|
| Copyright (c) 2019, Melih Berat ŞANLI. All Rights Reserved.               |
| ------------------------------------------------------------------------- |
|   License: Distributed under the Lesser General Public License (LGPL)     |
|            http://www.gnu.org/copyleft/lesser.html                        |
| This library is distributed in the hope that it will be useful - WITHOUT  |
| ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or     |
| FITNESS FOR A PARTICULAR PURPOSE.                                         |
'---------------------------------------------------------------------------'
*/

/**
 * multilangPHP - PHP multi language support library
 * NOTE: Requires PHP version 7 or later
 * @package multilangPHP
 * @author Melih Berat ŞANLI
 * @copyright 2019 Melih Berat ŞANLI
 * @version 1.0.0
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
*/

class multilang{
	private static $lang ="tr"; // Predefined language
	private static $dir = "system/lang/"; // Predefined directory
	private static $log = array(); // Please don't touch

	public static function get($req, $return = 0){
		global $_SESSION;
		switch ($req){
			case 'lang':
				if($_SESSION['multilang']){
					if ($return) return $_SESSION['multilang'];
					echo $_SESSION['multilang'];
					break;
				}
				if ($return) return multilang::$lang;
				echo multilang::$lang;
				break;
			case 'dir&lang':
				if ($return) return multilang::get("dir", 1).multilang::get("lang",1).".php";
				echo multilang::get("dir",1).multilang::get("lang",1).".php";
				break;
			case 'dir':
				if ($return) return multilang::$dir;
				echo multilang::$dir;
				break;
			case 'log':
				if ($return) return multilang::$log;
				echo multilang::$log;
				break;	
			case 'log_last':
				if ($return) return end(multilang::$log);
				echo end(multilang::$log);
				break;
		}
	}

	public static function set($type, $set){
		global $_SESSION;
		switch ($type) {
			case 'lang':
				multilang::set("log", sprintf("The current language is set (%s)", $set));
				$_SESSION['multilang'] = $set;
				multilang::$lang = $set;
				break;
			case 'dir':
				multilang::set("log", sprintf("New directory (%s)", $set));
				multilang::$dir = $set;
				break;
			case 'log':
				multilang::$log[] = $set;
				break;
		}
	}

	public static function ctrl($fileLang){
		return file_exists(multilang::$dir.$fileLang.".php");
	}

	# Return Type: array, html (div>a*)
	public static function listlang($returnType = "array"){
		$langPHP_array = array();
		$langPHP_html = '<div class="multilang">';
		$openDir = opendir(multilang::get("dir", 1));
		while (($file = readdir($openDir)) != FALSE ){
			if ($file =='.' || $file == '..' || is_file($file) || substr($language, -4, 4) == '.php') continue;
			if ($returnType == "array") $langPHP_array[basename($file, ".php")] = $file;
			if ($returnType == "html") $langPHP_html .= sprintf(' <a href="?lang=%s" title="language %s">%s</a> ', basename($file, ".php"), $file, $file);
		}
		$langPHP_html .= '</div>';
		closedir($openDir);
		return $returnType == "array" ? $langPHP_array : $langPHP_html;
	}

	public static function lang($type){
		global $LANG;
		if(!$LANG[$type]){
			multilang::set("log", sprintf('NOT FOUND "%s" in %s.php', $type, multilang::get("lang", 1)));
			return sprintf('<span style="background-color: red; color: white;">NOT FOUND "%s" in %s.php</span>', $type, multilang::get("lang", 1));
		}
		return $LANG[$type];
	}

	public static function setup(){
		global $_GET, $_SESSION, $LANG;
		if(session_status() == PHP_SESSION_NONE) session_start();
		if($_GET && $_GET['lang']){
			if(multilang::ctrl($_GET['lang'])){
				multilang::set("lang", $_GET['lang']);
				require_once(multilang::get("dir&lang", 1));
				multilang::set("log", sprintf("Language file loading (%s.php)", multilang::get("dir&lang",1)));
			}else{
				multilang::set("log", sprintf("Language file not found (%s.php)", multilang::$dir.$_GET['lang']));
			}
		}else{
			require_once(multilang::get("dir&lang", 1));
			multilang::set("log", sprintf("Language file loading (%s.php)", multilang::get("dir&lang",1)));
		}
	}
}
?>