<?php

class Database extends PDO
{
    public function __construct($dbconfig = 'dbconfig.ini')
    {
        $settings = parse_ini_file($dbconfig);
		
        $dns      = $settings['driver'].':host='.$settings['host'].';dbname='.$settings['dbname'].';charset=utf8';
		$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf-8');
        parent::__construct($dns, $settings['user'], $settings['pass']);
    }
}
?>
