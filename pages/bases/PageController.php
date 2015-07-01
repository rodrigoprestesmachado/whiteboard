<?php
	/**
	 * Copyright 2011 - Nucleo de Informatica na Educacao Especial (NIEE) 
	 * 
	 * Licensed under the Apache License, Version 2.0 (the "License");
	 * you may not use this file except in compliance with the License.
	 * You may obtain a copy of the License at
	 * 
	 *     http://www.apache.org/licenses/LICENSE-2.0
	 * 
	 * Unless required by applicable law or agreed to in writing, software
	 * distributed under the License is distributed on an "AS IS" BASIS,
	 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
	 * See the License for the specific language governing permissions and
	 * limitations under the License.
	 */
    require_once 'pages/bases/PageDefinitionDom.php';
    
    class PageController {
		private static $instance;
		private $definitions;

		public static function getInstance() {
			if (!isset(self::$instance)) {
		    	$class = __CLASS__;
		    	self::$instance = new $class;
		    }
		    return self::$instance;
		}

		function __construct() {
			$dom = new PageDefinitionDom('pages/bases/pageDefinitions.xml');
			$this->definitions = $dom->getDefinitions();
		}

 	   	public function run($page) {
 	   		foreach($this->definitions as $definition) {
				if ($definition->getName() == $page) {
                     $puts = $definition->getPuts();
                     foreach($puts as $putObjtect) {                    	
                         
                     	 $key = $putObjtect->getPageKey();
                         $role = $putObjtect->getRole();
                     	 
                     	 if ($role != "" ) {    	 			
                     	 	if ($_SESSION['discriminador'] == $role) {
                     	 		$_GET["$key"] = $putObjtect->getValue();
                     	 	}		
                     	 }
                     	 else {
                     	 	$_GET["$key"] = $putObjtect->getValue();	
                     	 }
                     }
                     $content = $this->getFileContent($definition->getBase());
                     echo $this->scapeHTML($content);
                }
			}
		}
		
		public function getFileContent($filename) {
		    if (is_file($filename)) {
			    ob_start();
				    include_once $filename;
				    $contents = ob_get_contents();
			    ob_end_clean();
			    return $contents;
		    }
		    return false;
	    }
	    
	    public function scapeHTML($content) {
	    	$content =  str_replace("á", "&#225;", $content); 
			$content =  str_replace("â", "&#226;", $content); 
			$content =  str_replace("Á", "&#193;", $content); 
			$content =  str_replace("ç", "&#231;", $content); 
			$content =  str_replace("í", "&#237;", $content); 
			$content =  str_replace("Í", "&#205;", $content); 
			$content =  str_replace("ê", "&#234;", $content); 
			$content =  str_replace("é", "&#233;", $content); 
			$content =  str_replace("É", "&#201;", $content); 
			$content =  str_replace("ú", "&#250;", $content); 
			$content =  str_replace("õ", "&#245;", $content); 
			$content =  str_replace("ó", "&#243;", $content); 
	    	return $content;
		}
		
	}
?>