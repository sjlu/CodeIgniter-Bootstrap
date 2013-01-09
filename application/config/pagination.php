<?php

/*
 * Enclosure markup.
 * The tags which wrap the ENTIRE pagination.
 */
$config['full_tag_open'] = '<div class="pagination"><ul>';
$config['full_tag_close'] = '</ul></div>';

/*
 * All other page number markup.
 */
$config['num_tag_open'] = '<li>';
$config['num_tag_close'] = '</li>';

/*
 * The current "page" tag markup.
 */
$config['cur_tag_open'] = '<li class="active"><a>';
$config['cur_tag_close'] = '</a></li>';

/*
 * The text for the next and last links.
 */
//$config['next_link'] = '&rarr;';
//$config['prev_link'] = '&larr;';
$config['next_link'] = false;
$config['prev_link'] = false;

/*
 * The "First" and "Last" segments.
 */
$config['first_tag_open'] = $config['num_tag_open'];
$config['first_tag_close'] = $config['num_tag_close'];
$config['first_link'] = '&laquo;';

$config['last_tag_open'] = $config['num_tag_open'];
$config['last_tag_close'] = $config['num_tag_close'];
$config['last_link'] = '&raquo;';
