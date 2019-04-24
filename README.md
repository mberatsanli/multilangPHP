
# multilangPHP
[![MBS](http://mberatsanli.com/mbs4github.png)](http://www.mberatsanli.com)

[![MBS-PHP](https://img.shields.io/github/release/mberatsanli/multilangPHP.svg)](http://mberatsanli.github.io/multilangPHP)
[![MBS-PHP](https://img.shields.io/github/last-commit/mberatsanli/multilangPHP.svg)](http://mberatsanli.github.io/multilangPHP)
[![MBS-PHP](https://img.shields.io/github/repo-size/mberatsanli/multilangPHP.svg)](http://mberatsanli.github.io/multilangPHP)
[![MBS-PHP](https://img.shields.io/github/languages/code-size/mberatsanli/multilangPHP.svg)](http://mberatsanli.github.io/multilangPHP)
[![MBS-PHP](https://img.shields.io/github/license/mberatsanli/multilangPHP.svg)](http://mberatsanli.github.io/multilangPHP)

[![MBS-master](https://api.travis-ci.org/mberatsanli/multilangPHP.svg?branch=master)](https://travis-ci.org/mberatsanli/multilangPHP/jobs/522465502)
[![MBS-quality](https://scrutinizer-ci.com/g/mberatsanli/multilangPHP/badges/quality-score.png?b=master)](hhttps://scrutinizer-ci.com/g/mberatsanli/multilangPHP/)
[![MBS-intelligence](https://scrutinizer-ci.com/g/mberatsanli/multilangPHP/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/g/mberatsanli/multilangPHP/)

### Import the library
```php
require_once("lib/multilang.php");
```

## Using

####  > How to starting
```php
multilang::setup();
```

#### > Set Languages Directory
```php
multilang::set("dir", "../demo/langs/");
```
before `mutlilang::setup();`

#### > GET function
```php 
multilang::get($req, $return);
```


| $return | what is does |
|--|--|
| 1 | return |
| 0 | echo |


| $request | what is does | output example |
|--|--|--|
| lang | Gives you the language selected by the user | en |
| dir | Gives you the directory | ../demo/langs/ |
| log | Gives the log of the library | array() |
| log_last | Gives the last log the library | The current language is set tr |
| dir&lang | Gives the language file directory selected by the user | ../demo/langs/tr.php |


#### > List the language in the defined direcory
```php 
echo multilang::listlang($returnType);
```


| $returnType | what is does | output |
|-------------|--------------|--------|
| html | Gives languages in html format | div.multilang > [a href="?lang=tr" title="language tr"]tr[/a] |
| array | Gives languages in array | array('tr' => 'tr.php') |


#### > How to create the language file
For example, the folder with the language files: `../demo/langs/` and we create a language folder in the directory. Create `LANGUAGE.php`  for example `az.php`
```php  
// '../demo/langs/az.php'

$LANG = array(); // We are creating an array called LANG

$LANG['test'] = "Bu bir testdir.";


$LANG['CALLED_NAME'] = "CONTENTS";
```

#### > How to get the text
```php 
echo multilang::lang($type);
```
$type is a CALLED NAME

```php 
// Example
echo multilang::lang('test'); // Output (return): Bu bir testtir.
```

## Exapmle Using
```php 
// index.php
require_once("lib/multilang.php");

multilang::set("dir", "langs/"); // We defined the language directory
multilang::setup(); // We starting the library

echo multilang::lang("test"); // Echo the text

print_r(multilang::get("log", 1)); // Print the log array
```
