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

<script type="text/javascript" src="pages/bases/javascript/navigationArrows/loginPage.js"></script>

<?php 
// If this page is called by an error, will be open the modal window that was being used
if (!empty($_SESSION['openModalWindow'])){
echo "
<script type='text/javascript'>
	$(document).ready(function() {
		libOpenModalWindow('{$_SESSION['openModalWindow']}');
	});
</script>";
}
unset($_SESSION['openModalWindow']);
?>

<?php $msgs = Localization::getInstance(); ?>

	
	<div class="login">
		
		<form action="wb.php?do=login" method="post">
			<div id="inputs">
				<input 
					id="textEmail"
					class="input counterNavigationLoginForm" 
					type="text" 
					name="email" 
					onfocus="showTip('tipEmail', 'textEmail')" 
					onblur="hideTip('tipEmail')" 
					onmousemove="showTip('tipEmail')" 
					onmouseout="hideTip('tipEmail')" 
				    alt="<?php echo $msgs->getText('loginForm.email.description'); ?>"
					maxlength="40"
					size="19"
					aria-describedby="tipEmail"
				/>
				
				<input 
					id="textPassword" 
					class="input counterNavigationLoginForm"
					type="password" 
					name="password"
					onfocus="showTip('tipPassword', 'textPassword')" 
					onblur="hideTip('tipPassword')" 
					onmousemove="showTip('tipPassword')" 
					onmouseout="hideTip('tipPassword')" 
				    alt="<?php echo $msgs->getText('loginForm.password.description'); ?>"
					maxlength="20"
					size="19"
					aria-describedby="tipPassword"
				/>
			</div>
			
			<div id="lblEmail">
				<?php echo $msgs->getText('loginForm.email'); ?><br />
				
			</div>
			
			<div id="lblPassword">
				<?php echo $msgs->getText('loginForm.password'); ?><br />
			</div>
		
			<div id="buttons">
				<input 
					id="textSubmit"
					type="submit"
					type="image"
					class="counterNavigationLoginForm"
					onfocus="showTip('tipSubmit', 'textSubmit')" 
					onblur="hideTip('tipSubmit')"  
					onmousemove="showTip('tipSubmit')" 
					onmouseout="hideTip('tipSubmit')" 
					value="<?php echo $msgs->getText('loginForm.submit'); ?>" 
				    alt="<?php echo $msgs->getText('loginForm.submit.description'); ?>"
				    aria-describedby="tipSubmit"
				/>	
			</div>
		</form>	
			<div id="buttons">		
				<input 
					id="textbtnRegister"
					type="submit"
					type="image"
					class="counterNavigationLoginForm"
					onfocus="showTip('tipbtnRegister', 'textbtnRegister')" 
					onblur="hideTip('tipbtnRegister')"
					onmousemove="showTip('tipbtnRegister')" 
					onmouseout="hideTip('tipbtnRegister')"   
					value="<?php echo $msgs->getText('loginForm.btnRegister'); ?>" 
					alt="<?php echo $msgs->getText('loginForm.btnRegister.description'); ?>"
					onclick="$('#dialogRegister').dialog('open'); currentModalWindow='dialogRegister';"
					aria-describedby="tipbtnRegister"
				/>
			</div>
			
			<div id="bottomTips">
				<div id="tipEmail" class="tip">
			     	 <?php echo $msgs->getText('loginForm.email.description'); ?>
				</div>
				<div id="tipPassword" class="tip">
			     	 <?php echo $msgs->getText('loginForm.password.description'); ?>
				</div>
				<div id="tipSubmit" class="tip">
			     	 <?php echo $msgs->getText('loginForm.submit.description'); ?>
				</div>
				<div id="tipbtnRegister" class="tip">
			     	 <?php echo $msgs->getText('loginForm.btnRegister.description'); ?>
				</div>
			</div>
		
		<div id="dialogRegister" title="<?php echo $msgs->getText('registerForm.title'); ?>" class="dialog">
			<?php require_once 'registerForm.php';?>
		</div>
			
	</div>