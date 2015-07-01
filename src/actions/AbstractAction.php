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

    require_once 'src/util/PropertiesDom.php';
    require_once 'src/actions/AbstractSecurity.php';

	abstract class AbstractAction extends AbstractSecurity {
		
		// Controls join of pages
		protected $pageController;
		
		/** Construtor responsavel por selecionar o tipo de banco **/
		public function __construct() {	
			parent::__construct();

			$this->pageController = PageController::getInstance();
			
			//$propertiesDom = new PropertiesDom('conf/properties.xml');
			//$this->picture_directory = $propertiesDom->getPropertie("path");
 		}
	 	
	 	/** Metodo que deve ser implementado nas acoes contretas **/
	 	abstract function execute($action);
	 	
	 	/** Metodo que tem a funcao de verificar a permissao de cada acao **/
        public function actionPermission($action) {
            
        	if (($action->getAuthentication() == true) && (!(isset($_SESSION["id"]))) ) {

        		$action->setName("loginForm");
				$action->setType("ForwardAction");
				$action->setRole("");
				$action->setSSL("true");
				$action->setAuthentication("false");					
				$action->setForwards(Array("success"=>".showLoginForm"));
    
				$forwardAction = new ForwardAction();
				$forwardAction->execute($action);
				
			}
        	else{
        		return true;
        	}
        }
        
		/** 
	 	 * Description : O objetivo deste metodo e validar os dados de qualquer 
	 	 * requisicao ao sistema.
	 	 * 
	 	 * Atencao: Este metodo e sempre chamado pelo controlador.
	 	 *  
  		 */
	 	public function validadeInputData($actionMapping) {
	 		$validationFields = $actionMapping->getValidations();
	 		if (count($validationFields)>0) {
	 			return $this->executeValidations($validationFields, $actionMapping->getAjax());
	 		}
	 		else
	 			return true;
	 	}
	 }
?>