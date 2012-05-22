<?php

//The pagination function automatically determines which segment of your URI contains the page number. If you need something different you can specify it.
$config['uri_segment'] = 3;

//The number of "digit" links you would like before and after the selected page number.
//For example, the number 2 will place two digits on either side, as in the example links at the very top of this page.
$config['num_links'] = 5;

//By default, the pagination library assume you are using URI Segments, and constructs your links something like
$config['page_query_string'] = FALSE;


//If you would like to surround the entire pagination with some markup you can do it with these two prefs:

//The opening tag placed on the left side of the entire result.
$config['full_tag_open'] = '<div class="pagination" id="pagination">';

//The closing tag placed on the right side of the entire result.
$config['full_tag_close'] = '</div>';



//Customizing the First Link

//The text you would like shown in the "first" link on the left.
$config['first_link'] = '';

//The opening tag for the "first" link.
$config['first_tag_open'] = '';

//The closing tag for the "first" link.
$config['first_tag_close'] = '';



//Customizing the Last Link

//The text you would like shown in the "last" link on the right.
$config['last_link'] = '';

//The opening tag for the "last" link.
$config['last_tag_open'] = '';

//The closing tag for the "last" link.
$config['last_tag_close'] = '';


//Customizing the "Next" Link

//The text you would like shown in the "next" page link.
$config['next_link'] = 'Next';

//The opening tag for the "next" link.
$config['next_tag_open'] = '<div class="paginationDirection">
						<div class="directionRight">';

//The closing tag for the "next" link.
$config['next_tag_close'] = '</div></div>';


//Customizing the "Previous" Link

//The text you would like shown in the "previous" page link.
$config['prev_link'] = 'Previous';

//The opening tag for the "previous" link.
$config['prev_tag_open'] = '<div class="paginationDirection">
						<div class="directionLeft">';

//The closing tag for the "previous" link.
$config['prev_tag_close'] = '</div></div>';


//Customizing the "Current Page" Link

//The opening tag for the "current" link.
$config['cur_tag_open'] = '<div class="paginationPage selected">';

//The closing tag for the "current" link.
$config['cur_tag_close'] = '</div>';


//Customizing the "Digit" Link

//The opening tag for the "digit" link.
$config['num_tag_open'] = '<div class="paginationPage">';

//The closing tag for the "digit" link.
$config['num_tag_close'] = '</div>';