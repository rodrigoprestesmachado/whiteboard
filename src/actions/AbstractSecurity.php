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

	require_once 'src/util/Inspekt/Inspekt.php';
	require_once 'src/data/DAOFactory.php';
	
	abstract class AbstractSecurity {
		
		protected $dao;
		protected $message;
		
		public function __construct() {
			$mySqlDAOFactory = DAOFactory::getDAOFactory(DAOFactory::$MYSQL);
			$this->dao = $mySqlDAOFactory->getDataBaseOperations();
			$this->message = Localization::getInstance();
 		}
	
 		/**
	 	 * Descricao : Este metodo tem como objetivo de executar a validacao dos campos das acoes
	 	 * 
	 	 * @param Array validationFields : Um array de objetos Fields
	 	 * @param Boolean isAjaxAction   : True se o a acao for ajax
	 	 * 
	 	 * @return True se os campos forem validados com sucesso
  		 */
		public function executeValidations($validationFields, $isAjaxAction) {
			
			$getFields = $this->separateGetFields($validationFields);
			$postFields = $this->separatePostFields($validationFields);
		
			if (count($getFields) > 0) {
				if ($this->checkGetFields($getFields, $isAjaxAction)) {
					foreach ($getFields as $field) {
						if (!($this->executeFieldValidation($field)))
							return false;
					}
				}
				else
					return false;
			}
			
			if (count($postFields) > 0) {
				if ($this->checkPostFields($postFields, $isAjaxAction)) {
					foreach ($postFields as $field) {
						if (!($this->executeFieldValidation($field)))
							return false;
					}
				}
				else
					return false;
			}
			return true;
		}
		
		/** 
	 	 * Descricao : Este metodo cria um array de objetos Fiels que sao executados sobre HTTP GET
	 	 * 
	 	 * @param Array validationFields : Um array de objetos Fields
	 	 * 
	 	 * @return Um array de objetos Fiels que sao executados sobre HTTP GET
  		 */
		private function separateGetFields($validationFields) {
			$getFields = array();
			foreach ($validationFields as $field) {
				if ($field->getMethod() == "get")
					$getFields[] = $field;
			}
			return $getFields;
		}
		
		/** 
	 	 * Descricao : Este metodo cria um array de objetos Fiels que sao executados sobre HTTP POST
	 	 * 
	 	 * @param Array validationFields : Um array de objetos Fields
	 	 * 
	 	 * @return Um array de objetos Fiels que sao executados sobre HTTP POST
  		 */
		private function separatePostFields($validationFields) {
			$postFields = array();
			foreach ($validationFields as $field) {
				if ($field->getMethod() == "post")
					$postFields[] = $field;
			}
			return $postFields;
		}
		
		/** 
	 	 * Descricao : Este metodo tem como objetivo de verificar os campos de POST 
	 	 * (juntamente com a ordem) provenientes do formularios
	 	 * 
	 	 * @param Array allowed : Um array que contem todos os campos permitidos.
	 	 * Atencao: a ordem dos campos e tambem levada em consideracao
	 	 * 
	 	 * @return Verdadeiro que os campos recebidos forem iguais aos permitidos
  		 */
	 	private function checkPostFields($postFields, $isAjaxAction) {
	 		if ($isAjaxAction) {
	 			//TODO A ordem dos parametros de uma requisicao ajax nao esta sendo analisada
	 			return true;
	 		}
	 		else {
	 			$allowed = array();
		 		foreach($postFields as $field){
		 			$allowed[] = $field->getName();
		 		}
		 		
		 		$sent = array_keys($_POST);
		 		return $this->checkFields($allowed, $sent);
	 		}
	 	}
	 	
		/** 
	 	 * Descricao : Este metodo tem como objetivo de verificar os campos de GET 
	 	 * (juntamente com a ordem) provenientes do formularios
	 	 * 
	 	 * @param Array allowed : Um array que contem todos os campos permitidos.
	 	 * Atencao: a ordem dos campos e tambem levada em consideracao
	 	 * 
	 	 * @return Verdadeiro que os campos recebidos forem iguais aos permitidos
  		 */
	 	private function checkGetFields($getFields, $isAjaxAction)
	 	{
	 		if ($isAjaxAction) {
	 			//TODO A ordem dos parametros de uma requisicao ajax nao esta sendo analisada
	 			return true;
	 		}
	 		else {
	 			$allowed = array();
		 		$allowed[] = "do";
		 		
		 		foreach($getFields as $field)
		 			$allowed[] = $field->getName();
		 		
		 		$sent = array_keys($_GET);
		 		return $this->checkFields($allowed, $sent);
	 		}
	 	}
	 	
	 	/** 
	 	 * Descricao : Verifica se os campos enviados sao iguais aos campos permitidos
	 	 * 
	 	 * @param Array allowed : Um array de campos permitidos
	 	 * @param Array sent    : Um array de campos enviados
	 	 * 
	 	 * @return True se o array de campos permitido for igual ao array de campos enviados
  		 */
	 	private function checkFields($allowed, $sent) {
	 		if ($allowed == $sent)
				return true;
			else
				return false;
	 	}
	 	
	 	/** 
	 	 * Descricao : Executa a validacao de um campo
	 	 * 
	 	 * @param Field fields : Um objeto Field
	 	 * 
	 	 * @return True se o objeto field for validado com sucesso
  		 */
	 	private function executeFieldValidation($field) {
	 		$result = false;
	 		
	 		$validationType = $field->getValidationType();
	 		switch ($validationType) {
	    		case "not":
	        		$result = true;
	        		break;
		 		case "cleanTags":
	        		$result = $this->cleanTagsValidation($field);
	        		break;
	        	case "alfanumerico":
	        		$result = $this->alnumValidation($field);
	        		break;
	        	case "alfa":
	        		$result = $this->alphabeticValidation($field);
	        		break;
		 		case "integer":
	        		$result = $this->integerValidation($field);
	        		break;
	        	case "email":
	        		$result = $this->emailValidation($field);
	        		break;
	        	case "isCurrentUser":
	        		$result = $this->isCurrentUserValidation($field);
	        		break;
	        }
	        
	    	return $result;
	    	
	 	}
	 	
	 	/** 
	 	 * Descricao : Retorna o valor vindo do formulario de um campo
	 	 * 
	 	 * @param Field field : Um objeto field
	 	 * 
	 	 * @return O valor proveniente do formulario de um campo
  		 */
		private function getSentData($field) {
			if ($field->getMethod() == "get")
	 			return $_GET[$field->getName()];
	 		else
	 			return $_POST[$field->getName()];
	 	}
	 	
	 	/** 
	 	 * Descricao : Metodo responsavel pela validacao de emails vindo de formularios
	 	 * 
	 	 * @param String email : Um endereco de email
	 	 * 
	 	 * @return Verdadeiro se o endereco de email for visitado
  		 */
	 	private function emailValidation($field) {	
	 		$sent = $this->getSentData($field);
	 		
	 		$email_pattern = '/^[^@\s<&>]+@([-a-z0-9]+\.)+[a-z]{2,}$/i';
			if (preg_match($email_pattern, $sent)) 
    			return true;
			else
				return false;
	 	}
	 	
	 	/** 
	 	 * Descricao : Verifica se o dado do formulario for inteiro
	 	 * 
	 	 * @param Field field : Um objeto field
	 	 * 
	 	 * @return True se o dado for inteiro
  		 */
	 	private function integerValidation($field) {
	 		$sent = $this->getSentData($field);
	 		if ($sent == strval(intval($sent)))
	 			return true;
	 		else
	 			return false;
	 	}
	 	
	 	/** 
	 	 * Descricao : Verifica se o dado do formulario for alfa numerico
	 	 * 
	 	 * @param Field field : Um objeto field
	 	 * 
	 	 * @return True se o dado for alfa numerico
  		 */
		private function alnumValidation($field) {
	 		if ($field->getMethod() == "get")
	 			return Inspekt::isAlnum($_GET[$field->getName()]);
	 		else
	 			return Inspekt::isAlnum($_POST[$field->getName()]);
	 	}
	 	
	 	/** 
	 	 * Descricao : Verifica se o dado do formulario for alfabetico
	 	 * 
	 	 * @param Field field : Um objeto field
	 	 * 
	 	 * @return True se o dado for alfa alfabetico
  		 */
		private function alphabeticValidation($field) {
	 		if ($field->getMethod() == "get")
	 			return Inspekt::isAlpha($_GET[$field->getName()]);
	 		else
	 			return Inspekt::isAlpha($_POST[$field->getName()]);
	 	}
	 	
	 	/** 
	 	 * Descricao : Limpa as tags que um dado possa conter
	 	 * 
	 	 * @param Field field : Um objeto field
	 	 *
  		 */
	 	private function cleanTagsValidation($field) {
	 		if ($field->getMethod() == "get")
	 			$_GET[$field->getName()] = Inspekt::noTags($_GET[$field->getName()]);
	 		else
	 			$_POST[$field->getName()] = Inspekt::noTags($_POST[$field->getName()]);

			return true; 		
	 	}
	 	
	 	/** 
	 	 * Descricao : Verifica se o id enviado e o mesmo da sessao
	 	 * 
	 	 * @param Field field : Um objeto field
	 	 * 
	 	 * @return True se o id enviado for o mesmo da sessao
  		 */
	 	private function isCurrentUserValidation($field) {	
	 		if (isset($_SESSION["id"])) {
	 			if ($this->integerValidation($field)) {
			 		if ($field->getMethod() == "get")
			 			$userId = $_GET[$field->getName()];
			 		else
			 			$userId = $_POST[$field->getName()];
			 		
			 		if ($_SESSION["id"] == $userId)
			 			return true;
			 		else
			 			return false;
		 		}
		 		else
		 			return false;
	 		}
	 		else
	 			return false;	
	 	}
	 		 	
	}
?>