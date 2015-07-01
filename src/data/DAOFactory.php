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

	require_once 'src/data/MySqlDAOFactory.php';

	/**
	 * Creates the DAOs of system
	 * 
	 * @author rodrigo
	 */
	abstract class DAOFactory {
		
		 public static $MYSQL = 1;

		 public abstract function getDataBaseOperations();
		 
		 /**
		  * Creates the DAO object
		  * 
		  * @param Integer $factory : Receives a constant to define the kind of DAO 
		  */
		 public static function getDAOFactory($factory) {
		 	
		  	switch ($factory) {
		      case 1: 
		          return new MySqlDAOFactory();
		      default:
		          return null;
		    }
		 }
		  
	}
	
?>