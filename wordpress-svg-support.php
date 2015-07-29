<?php

	// this function adds SVG support to the media 
	// library allowing you to upload them

	function custom_mime_types($mimes) {

		// builds arry of addition mime types
		$mimes['svg'] = 'image/svg+xml';
		$mimes['svgz'] = 'image/svg+xml';
	  
	  	// return it
		return $mimes;

	}

	// adds funtion to upload mins
	add_filter('upload_mimes', 'custom_mime_types');

