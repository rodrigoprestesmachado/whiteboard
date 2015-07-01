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
	 * Classe responsavel pelo envio de emails.
	 *
	 * 	Example of use
	 *
	 * 	$email = new Email();
	 *	$email->setTo("test@niee.ufrgs.br");
	 *	$email->setCC("test@");
	 *	$email->setBCC("adm@niee.ufrgs.br");
	 *	$email->setFrom();
	 *	$email->setSubject("Test");
	 *	$email->setBody("Test");
	 *	$email->send();
	 */
	class Email
	{
		private $mailTo;
		private $mailCC;
		private $mailBCC;
		private $mailFrom;
		private $mailReplyTo;
		private $mailSubject;
		private $mailBody;
		private $mailHeader;
		private $mailType;
		private $template;
		
		const TEXT = 1;
		const HTML = 2;
	
		public function __construct($type = self::TEXT) {
			$this->mailType = $type;
		}
	
		/**
		 * Description:  Adiciona destinatario
		 *
		 * @param String address : Um email o uma lista de emails separada por virgula (,)
		 */
		function setTo($address) {
			$this->mailTo = $address;
		}
	
		/**
		 * Description: 	Adiciona email para envio de copia
		 *
		 * @param String address : Um email o uma lista de emails separada por virgula (,)
		 */
		function setCC($address) {
			$this->mailCC = $address;
		}
	
		/**
		 * Description: 	Adiciona email para envio de copia oculta
		 *
		 * @param String address : Um email o uma lista de emails separada por virgula (,)
		 */
		function setBCC($address) {
			$this->mailBCC = $address;
		}
	
		/**
		 * Description: 	Adiciona remetente
		 *
		 * @param String address : email do remetente
		 * @param String nome : nome do remetente
		 */
		function setFrom($address="naoresponda@niee.ufrgs.br", $nome="niee.ufrgs.br") {
			if($nome != "")
				$this->mailFrom = $nome;
			
			$this->mailFrom = $address;
		}
	
		/**
		 * Description: 	Adiciona "responder para"
		 *
		 * @param String address : email
		 * @param String name : nome
		 */
		function setReplyTo($address, $nome="") {
			if($nome != "")
				$this->mailReplyTo = $nome;
	
			$this->mailReplyTo = $address;
		}
	
		/**
		 * Description: 	Adiciona assunto
		 *
		 * @param String subject : assunto da mensagem
		 */
		function setSubject($subject) {
			$this->mailSubject = ereg_replace("[\n\r\t\f]","",$subject);
		}
	
		/**
		 * Description: 	Monta o header
		 *
		 */
		function createHeader() {
			if($this->mailCC != "")
			$this->mailHeader .= "Cc: ".$this->mailCC."\n";
	
			if($this->mailBCC != "")
			$this->mailHeader .= "Bcc: ".$this->mailBCC."\n";
	
			if($this->mailFrom != "")
			$this->mailHeader .= "From: ".$this->mailFrom."\n";
	
			if($this->mailReplyTo != "")
			$this->mailHeader .= "ReplyTo: ".$this->mailReplyTo."\n";
	
			$this->mailHeader .= "MIME-Version: 1.0\n";
			$this->mailHeader .= "X-Mailer: \n";
	
			if ($this->mailType == "TEXT") {
				$this->mailHeader .= "Content-Type: text/plain;\n";
				$this->mailHeader .= "Content-Transfer-Encoding: 8bit";
			}
			else {
				$this->mailHeader .= "Content-Type: text/html; charset=iso-8859-1\n";
				$this->mailHeader .= "Content-Transfer-Encoding: 8bit";
			}
		}
	
		/**
		 * Description: 	Define o tipo de mensaegem TEXT/HTML
		 *
		 * @param integer type : 1 para text, 2 para html
		 * @return boolean
		 */
		function setType($type = self::TEXT) {
			if($type != self::HTML && $type != self::TEXT)
			$this->mailType = self::TEXT;
			else
			$this->mailType = $type;
		}
	
		/**
		 * Description: 	Adiciona corpo da mensagem. Este metodo envia um mail com
		 * um template pre definido.
		 *
		 * @param String body : conteudo da mensagem
		 */
		function setBody($body) {
			$this->mailBody .= $body;
		}
	
		function getBody(){
			return 	$this->mailBody;
		}
		
		/**
		 * Description: 	Envia a mensagem
		 *
		 * @return boolean
		 */
		function send() {
			$this->createHeader();
			// O retorno indica que o email foi aceito para entrega. Nao significa que ele foi entregue
			return mail($this->mailTo, $this->mailSubject, $this->mailBody, $this->mailHeader);
		}
	}
?>