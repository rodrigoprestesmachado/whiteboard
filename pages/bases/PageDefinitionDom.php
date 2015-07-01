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

/**
 * Descricao : DOM que faz o parser das definicoes de paginas
 * 
 * @author Rodrigo Prestes Machado
 * 
 * @copyright Prestes & Machado LTDA
 */
class PageDefinitionDom
{
    private $definitions;
    private $document;

    public function __construct($arquivoXML)
    {
        $this->definitions = array();
        $this->document = new DOMDocument();
        $this->document->load($arquivoXML);
        $this->createDefinitions();
    }
    
    public function getDefinitions(){
        return $this->definitions;
    }
    
    private function addDefinition($name, $definition){
        $this->definitions[$name] = $definition;
    }
    
    private function createDefinitions()
    {
        $definitionList = $this->document->getElementsByTagName('definition');
        
        foreach ($definitionList as $definition)
        {
            if ($definition->hasChildNodes())
			{
			    $definitionChildrenNode = $definition->childNodes;
				$definitionObj = new Definition();
				
				foreach($definitionChildrenNode as $definitionChild)
				{
                    if ($definitionChild->nodeName == "name"){
                        $definitionName = $definitionChild->nodeValue;
                        $definitionObj->setName($definitionName);
                    }
					    
                    if ($definitionChild->nodeName == "base")
					    $definitionObj->setBase($definitionChild->nodeValue);

                    if ($definitionChild->nodeName == "put")
                    {
                    	$pageKey = "";
                    	$value = "";
                    	$role = "";
                    	
                        if ($definitionChild->hasAttribute('pageKey')){
                            $pageKey = $definitionChild->getAttribute('pageKey');
                        }
                        
                        if ($definitionChild->hasAttribute('value')){
                            $value = $definitionChild->getAttribute('value');
                        }
                        
                        if ($definitionChild->hasAttribute('role')){
                            $role = $definitionChild->getAttribute('role');
                        }
                        
                        $put = new Put($pageKey, $value, $role);
                        $definitionObj->addPut($put);
                        
                    }
				}
				
				 $this->addDefinition($definitionName, $definitionObj);
            }
        }
    }
}

/**
 * Description : Classe que representa uma definicao de pagina
 */
class Definition
{
    private $name;
    private $base;
    private $puts;
    
    public function __construct()
    {
        $this->name = null;
        $this->base = null;
        $this->puts = array();
 	}
    
    public function getName(){
        return $this->name;
    }
    
    public function setName($name){
        $this->name = $name;
    }
    
    public function getBase(){
        return $this->base;
    }

    public function setBase($base){
        $this->base = $base;
    }
    
    public function getPuts(){
        return $this->puts;
    }

    public function setPuts($puts){
        $this->puts = $puts;
    }
    
    public function addPut($put){
        $this->puts[] = $put;
    }
}

/**
 * Description : Esta classe foi criada para encapsular os valores dos puts do XDM
 */
class Put
{
    private $pageKey;
    private $value;
    private $role;
    
    public function __construct($pageKey, $value, $role)
    {
        $this->pageKey = $pageKey;
        $this->value = $value;
        $this->role = $role;
    }
    
    public function getPageKey(){
        return $this->pageKey;
    }
    
    public function setPageKey($pageKey){
        $this->pageKey = $pageKey;
    }
    
    public function getValue(){
        return $this->value;
    }
    
    public function setValue($value){
        $this->value = $value;
    }
    
    public function getRole(){
        return $this->role;
    }

    public function setRole($role){
        $this->role = $role;
    }
}
?>