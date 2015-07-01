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

<div id="youTubeVideoForm">
	<p> 
		<?php echo $msgs->getText("roomTemplate.YouTubeVideo");?>
		<input 
			type="text" 
			id="inputYoutubeVideo" 
			class="input counterNavigationYouTube" 
			size="40" 
			value="" 
			onfocus="showTip('tipURLYouTubeVideo', 'inputYoutubeVideo')" 
			onblur="hideTip('tipURLYouTubeVideo')"  
			onmousemove="showTip('tipURLYouTubeVideo')" 
			onmouseout="hideTip('tipURLYouTubeVideo')"
			aria-describedby="tipURLYouTubeVideo"
		/> 
	</p> 
	<input 
		type="button" 
		class="counterNavigationYouTube"
		id="insertYoutubeVideo" 
		value="<?php echo $msgs->getText("roomTemplate.btnInsertYoutubeVideo");?>" 
		onclick="$('#dialogInputYoutubeVideo').dialog('close'); createVideoBox(event)" 
		onfocus="showTip('tipInsertVideo', 'insertYoutubeVideo')" 
		onblur="hideTip('tipInsertVideo')"  
		onmousemove="showTip('tipInsertVideo')" 
		onmouseout="hideTip('tipInsertVideo')"
		aria-describedby="tipInsertVideo"
	/> 
	 <br />
	<div id="tipInsertVideo" class="tip">
		<?php echo $msgs->getText('roomTemplate.btnInsertYoutubeVideo.description'); ?>
	</div>
	<div id="tipURLYouTubeVideo" class="tip">
		<?php echo $msgs->getText('roomTemplate.videoYouTubeURL.description'); ?>
		</div>
		<div id="tipBtnCloseYouTubeVideoForm" class="tip">
     		<?php echo $msgs->getText('userPage.btnClose.description'); ?>
	</div>	
</div>