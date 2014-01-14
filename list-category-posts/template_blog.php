<?php
/*
Plugin Name: List Category Posts - Template
Plugin URI: http://picandocodigo.net/programacion/wordpress/list-category-posts-wordpress-plugin-english/
Description: Template file for List Category Post Plugin for Wordpress which is used by plugin by argument template=value.php
Version: 0.9
Author: Radek Uldrych & Fernando Briano 
Author URI: http://picandocodigo.net http://radoviny.net
*/

/* Copyright 2009  Radek Uldrych  (email : verex@centrum.cz), Fernando Briano (http://picandocodigo.net)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or 
any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * The format for templates changed since version 0.17.
 * Since this code is included inside CatListDisplayer, $this refers to
 * the instance of CatListDisplayer that called this file.
 */

$images = null;
$post = null;

/* This is the string which will gather all the information.*/
$lcp_display_output = '';

// Show category link:
$lcp_display_output .= $this->get_category_link('strong');

//Add 'starting' tag. Here, I'm using an unordered list (ul) as an example:
$lcp_display_output .= '<div class="lcp_catlist">';

$firephp = FirePHP::getInstance(true);

$firephp->log("Log", "Label");
$firephp->info("Info test '");
$firephp->error("Error", "Err Label");
$firephp->warn("Warning");
$firephp->log(array(0 => "A", "Z" => "Y"));
$firephp->log(array(1, 2, array(0 => "A", "Z" => "Y"), 4, 5));

/*
$images =& get_children(array(
'post_parent' => $post->ID,
'post_type' => 'attachment',
'post_mime_type' => 'image'
));
*/

/**
 * Posts loop.
 * The code here will be executed for every post in the category.
 * As you can see, the different options are being called from functions on the
 * $this variable which is a CatListDisplayer.
 *
 * The CatListDisplayer has a function for each field we want to show.
 * So you'll see get_excerpt, get_thumbnail, etc.
 * You can now pass an html tag as a parameter. This tag will sorround the info
 * you want to display. You can also assign a specific CSS class to each field.
 */
foreach ($this->catlist->get_categories_posts() as $single):
    //Start a List Item for each post:
    $lcp_display_output .= '';

    //Show the title and link to the post:
    $lcp_display_output .= $this->get_post_title($single);

    //Show comments:
    $lcp_display_output .= $this->get_comments($single);

    //Show date:
    $lcp_display_output .= ' ' . $this->get_date($single);

    //Show author
    $lcp_display_output .= $this->get_author($single);

    //Custom fields:
    $lcp_display_output .= $this->get_custom_fields($this->params['customfield_display'], $single->ID);

    //Post Thumbnail
    $lcp_display_output .= $this->get_thumbnail($single);

    $lcp_display_output .= the_post_thumbnail();

/*
	if (empty($images))
	{
		// no attachments here
	}
	else
	{
		foreach ( $images as $attachment_id => $attachment )
		{
			$lcp_display_output .= wp_get_attachment_image( $attachment_id, 'thumbnail' );
		}
	}    
*/

    /**
     * Post content - Example of how to use tag and class parameters:
     * This will produce:<p class="lcp_content">The content</p>
     */
    $lcp_display_output .= $this->get_content($single, 'p', 'lcp_content');

    /**
     * Post content - Example of how to use tag and class parameters:
     * This will produce:<div class="lcp_excerpt">The content</div>
     */
    $lcp_display_output .= $this->get_excerpt($single, 'div', 'lcp_excerpt');

    //Close li tag
    $lcp_display_output .= '';
endforeach;

$lcp_display_output .= '</div>';
$this->lcp_output = $lcp_display_output;