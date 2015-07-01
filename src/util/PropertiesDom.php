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

class PropertiesDom {
    private $properties;
    private $document;

    public function __construct($arquivoXML) {
        $this->properties = array();
        $this->document = new DOMDocument();
        $this->document->load($arquivoXML);
        $this->createProperties();
    }
    
    /**
     * Descricao              :  Retorna o valor da propriedade
     *  
     * @param    String name  :  A chave de uma propriedade
     * @return                :  O valor da propriedade
     */
    public function getPropertie($name) {
    	foreach ($this->properties as $property) {
    		if ($property->getName() == $name)
    			return $property->getValue();
    	}
    	
    	return null;
    }
    
    public function getProperties(){
        return $this->properties;
    }
    
    public function countProperties(){
    	return count($this->properties);
    }
    
    private function addProperty($name, $propertyObj){
        $this->properties[$name] = $propertyObj;
    }
    
    private function createProperties() {
        $propertiesList = $this->document->getElementsByTagName('property');
        
        foreach ($propertiesList as $property)
        {
        	$obj = new Property();
        	$name =  $property->getAttribute("name");
        	$value = $property->getAttribute("value");
        	$obj->setName($name);
        	$obj->setValue($value);
        	$this->addProperty($name, $obj);   
        }
    }
}

/**
 * Descricao : Classe que define um objeto propertie
 */
class Property
{
    private $name;
    private $value;
    
    public function __construct()
    {
        $this->name = null;
        $this->value = null;
 	}
    
    public function getName(){
        return $this->name;
    }
    
    public function setName($name){
        $this->name = $name;
    }
    
    public function getValue(){
        return $this->value;
    }
    
    public function setValue($value){
        $this->value = $value;
    }
}

?>