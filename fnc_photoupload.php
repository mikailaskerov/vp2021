<?php

	function save_image ($image, $file_type, $target){
		$notice = null;
		if ($file_type == "jpg") {
			if(imagejpeg($image, $target, 90)){
				$notice = "Vahendatud pildi salvestamine onnetus!";
			} else {
				$notice = "Vahendatud pildi salvestamine tekkis torge!";
			}
		}
		if ($file_type == "png") {
			if(imagepng($image, $target, 6)){
				$notice = "Vahendatud pildi salvestamine onnetus!";
			} else {
				$notice = "Vahendatud pildi salvestamine tekkis torge!";
			}
		}
		if ($file_type == "gif") {
			if(imagegif($image, $target)){
				$notice = "Vahendatud pildi salvestamine onnetus!";
			} else {
				$notice = "Vahendatud pildi salvestamine tekkis torge!";
			}
		}
		return $notice;
	}