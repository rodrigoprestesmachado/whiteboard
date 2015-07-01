<?php
	return array (
	  'log' => 
	  array (
	    'ident' => 'propel-whiteboard',
	    'level' => '7',
	  ),
	  'propel' => 
	  array (
	    'datasources' => 
	    array (
	      'whiteboard' => 
	      array (
	        'adapter' => 'mysql',
	        'connection' => 
	        array (
	          'phptype' => 'mysql',
	          'database' => 'whiteboard',
	          'hostspec' => 'localhost',
	          'username' => 'wb',
	          'password' => 'wb',
	        ),
	      ),
	      'default' => 'wb',
	    ),
	  ),
	);
?>
