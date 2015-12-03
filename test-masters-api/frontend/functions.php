<?php

function get_api_call() {
	$base_url = untrailingslashit(get_option('api_base_url')); // get api base url
	$page_url = untrailingslashit(site_url()).'/Lsat-Prep'; // get page url
	
	if(!empty(get_query_var('city'))) { // if current page is city
		
		$current_city = get_query_var('city');
		$current_state = get_query_var('statecity');
		$api_url = $base_url.'/Landing/'.$current_state.'/'.$current_city;
		$array_data = file_get_contents($api_url);
		$array_data = json_decode($array_data);
		$html = '<div class="city-content">';
		
			if($array_data) {
			foreach($array_data as $data) {
				
				$html1 = '<div class="content-listing">';
					$html1 .= $array_data->Content;
				$html1 .= '</div>';
				
				$html2 = '<div class="faq-listing">';
					$html2 .= $array_data->Faq;
				$html2 .= '</div>';
				
			}
			$html = $html1.$html2;
		}
		else
			$html .= '';
		
		$html .= '</div>';
	
	}
	else if(!empty(get_query_var('state'))){  // if current page is state
		
		$current_state = get_query_var('state');
		$api_url = $base_url.'/Landing/'.$current_state;
		$array_data = file_get_contents($api_url);
		$array_data = json_decode($array_data);
		$html = '<div class="city-listing">';
		
			if($array_data->Cities) {
			$html .= '<ul>';
			foreach($array_data->Cities as $data) {
				
				$html .= '<li>';
					$html .= '<a data-slug="'.$data->Slug.'" href="'.$page_url.'/'.$current_state.'/'.$data->Slug.'">'.$data->Name.'</a>';
				$html .= '</li>';
				
			}
			$html .= '</ul>';
		}
		else
			$html .= '';
		
		$html .= '</div>';
		
	}
	else{ // simple listing page
		
		$api_url = $base_url.'/Landing';
		$array_data = file_get_contents($api_url);
		$array_data = json_decode($array_data);
		
		$html = '<div class="state-listing">';
		
		if($array_data) {
			$html .= '<ul>';
			foreach($array_data as $data) {
				
				$html .= '<li>';
					$html .= '<a data-slug="'.$data->Slug.'" href="'.$page_url.'/'.$data->Slug.'">'.$data->Name.'</a>';
				$html .= '</li>';
				
			}
			$html .= '</ul>';
		}
		else
			$html .= '';

		$html .= '</div>';
		
	}
	
	return $html;
	
}

add_shortcode('display-test-masters-states','get_api_call');

// code for rewriting rules for states

add_action('init', 'Lsat_Prep_rewrite_rules');
add_filter('query_vars', 'Lsat_Prep_insert_query_vars');
add_action('wp_loaded', 'Lsat_Prep_flush_rules');

// flush_rules() if our rules are not yet included
function Lsat_Prep_flush_rules() {
	$rules = get_option('rewrite_rules');

	if (!isset($rules['Lsat-Prep/([^/]+)/?$'])) {
		global $wp_rewrite;
		$wp_rewrite->flush_rules();
	}
}

// Adding a new rule
function Lsat_Prep_rewrite_rules() {
	add_rewrite_rule('Lsat-Prep/([^/]+)/?$', 'index.php?pagename=Lsat-Prep&state=$matches[1]', 'top');
}

// Adding the id var so that WP recognizes it
function Lsat_Prep_insert_query_vars($vars) {
	array_push($vars, 'state');
	return $vars;
}

function Lsat_Prep_template_redirect() {
	if (isset($_REQUEST['state']) && $_REQUEST['state'] != '') {
		$redirecturl = site_url() . '/Lsat-Prep/' . $_REQUEST['state'];
		exit(wp_redirect($redirecturl));
	}
}

add_action('template_redirect', 'Lsat_Prep_template_redirect');

// end code for rewriting rules for states

// code for rewriting rules for cities

add_action('init', 'Lsat_Prep_state_rewrite_rules');
add_filter('query_vars', 'Lsat_Prep_state_insert_query_vars');

// Adding a new rule
function Lsat_Prep_state_rewrite_rules() {
	add_rewrite_rule('Lsat-Prep/([^/]*)/([^/]*)/?', 'index.php?pagename=Lsat-Prep&statecity=$matches[1]&city=$matches[2]', 'top');
}

// Adding the id var so that WP recognizes it
function Lsat_Prep_state_insert_query_vars($vars) {
	array_push($vars, 'statecity','city');
	return $vars;
}

function Lsat_Prep_state_template_redirect() {
	if (isset($_REQUEST['city']) && $_REQUEST['city'] != '') {
		$redirecturl = site_url() . '/Lsat-Prep/' .$_REQUEST['statecity'].'/'. $_REQUEST['city'];
		exit(wp_redirect($redirecturl));
	}
}

add_action('template_redirect', 'Lsat_Prep_state_template_redirect');

// end code for rewriting rules for cities
