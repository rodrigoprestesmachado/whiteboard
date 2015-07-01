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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml"
	lang="<?php echo $msgs->getLanguage(); ?>">
	<head>
	    <title><?php echo $msgs->getText('title'); ?></title>
	    <meta http-equiv="content-type" content="text/html;charset=ISO-8859-1" />
	    
		<script type="text/javascript" src="pages/bases/javascript/accessibility.js"></script>
		<script type="text/javascript" src="pages/bases/javascript/libWhiteBoard.js"></script>
	    
	    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>
		<script type="text/javascript" src="pages/bases/javascript/filterlist.js"></script>
		<script type="text/javascript" src="pages/bases/javascript/utilities.js"></script>
		
	    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
 		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
 		<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
		
	    <?php require_once 'dialogModal.php'; ?>
	    <link rel="stylesheet" type="text/css" href="pages/bases/css/widgets.css" />
	</head>
	<body>
	
	<!-- Mask to cover the whole screen -->
	<div id="mask"></div>
	
			<?php 
				if ($_REQUEST["errorMsg"]){
					?>
						<div class="divError">
						
						<center>	
						
						<!-- Write on the screen the error message -->
						<?php echo $_REQUEST["errorMsg"];?>					
						
						<br /><br />
						
						<form action="wb.php">
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
						
						<br />
						
						<div id="tipbtnReturn" class="tip">
					     	 <?php echo $msgs->getText('basicTemplate.btnReturn.description'); ?>
						</div>
					
						</center>
						
						</div>
					<?php 
				}
			?>
		
		<?php include_once $_GET["content"];?>
		
		<script type="text/javascript">
			checkCookie();
		</script>
	</body>			
</html>