<?php

	// The porpose of these functions are to recive intomration from the 
	// feature image so you can put it anywhere in a template. 

	// function to revieve the image caption from a feature image
	function the_post_thumbnail_caption() {

		// setup post
		global $post;

		// get thumbnail ID & feature image
		$thumbnail_id    = get_post_thumbnail_id($post->ID);
		$thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));

		// set value to null
		$caption = null;

		// if there is a value
		if ($thumbnail_image && isset($thumbnail_image[0])) {
			$caption = '<span>'.$thumbnail_image[0]->post_excerpt.'</span>';
		}

		// retuen it 
		return $caption;
		
	}

	// function to revieve the image description from a feature image
	function the_post_thumbnail_description() {

		// setup post
		global $post;

		// get thumbnail ID & feature image
		$thumbnail_id    = get_post_thumbnail_id($post->ID);
		$thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));

		// set value to null
		$description = null;

		// if there is a value
		if ($thumbnail_image && isset($thumbnail_image[0])) {
			$caption = '<span>'.$thumbnail_image[0]->post_content.'</span>';
		}

		// retuen it 
		return $description;

	}

	// function to revieve the image title from a feature image
	function the_post_thumbnail_title() {

		// setup post
		global $post;

		// get thumbnail ID & feature image
		$thumbnail_id    = get_post_thumbnail_id($post->ID);
		$thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));

		// set value to null
		$title = null;

		// if there is a value
		if ($thumbnail_image && isset($thumbnail_image[0])) {
			$title = '<span>'.$thumbnail_image[0]->post_title.'</span>';
		}

		// retuen it 
		return $title;

	}	