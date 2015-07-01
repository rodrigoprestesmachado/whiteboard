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
?>

<?php $msgs = Localization::getInstance(); ?>

	
<div class="credits">

<h1 id="DesenvolvimentodeSoftwarenoNIEE">Desenvolvimento de Software no NIEE</h1>
<p>
O NIEE (Núcleo de Informática na Educaç&atilde;o Especial) é um grupo que ao longo das duas décadas de atuaç&atilde;o desenvolveu experiências, pesquisas, softwares e formaç&atilde;o de recursos humanos na área de Informática na Educaç&atilde;o Geral e Especial.
</p>
<h1 id="Desenvolvedores">Desenvolvedores</h1>
<ul>
	<li>Lourenço de Oliveira Basso</li>
	<li>Rodrigo Prestes Machado</li>
	<li>Felipe Estima da Silveira (IFRS)</li>
	<li>Henrique de Resende (UFRGS)</li>
	<li>Renan Pigato (IFRS)</li>	
	<li>Fahad Kalil</li>	
</ul>

<br />

<form action="wb.php" align="center">
<input 
	id="textbtnReturn"
	type="submit"
	onfocus="showTip('tipbtnReturn', 'textbtnReturn')" 
	onblur="hideTip('tipbtnReturn')"  
	value="<?php echo $msgs->getText('basicTemplate.btnReturn'); ?>" 
	alt="<?php echo $msgs->getText('basicTemplate.btnReturn.description'); ?>"
/>	
<?php 
// If user is logged in, it goes back to the main if not, to login page
	if (!is_null($_SESSION['user'])){
		?>
			<input type="hidden" name="do" value="login">
		<?php 
	}
	else 
	{
		?>
			<input type="hidden" name="do" value="loginForm">
		<?php 
	}
?>
</form>
	
</div>