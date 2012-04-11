<?php
/* LAYOUT LIST VIEW IN ADMIN PANEL */

add_action("manage_posts_custom_column",  "dr_object_custom_columns");
add_filter("manage_edit-dr_object_columns", "dr_object_edit_columns");
 
function dr_object_edit_columns($columns){
  $columns = array(
    "cb" => "<input type=\"checkbox\" />",
    "image" => "Image",
    "title" => "Title",
    "designers" => "Designers",
    "manufactors" => "Manufactors",
    "year" => "Year",
    "appearance" => "Appearance",
    "dr_tags" => "Tags",
    "colors" => "Colors",
    "comments" => "<img src='images/comment-grey-bubble.png'>",
    "date" => "Date"
  );
 
  return $columns;
}

function dr_object_custom_columns($column){
  global $post, $wpdb;
  $custom = get_post_custom();
  
  //13.03.12 update query colors from db, not from meta fields
  $post_id = $post->ID;
  $colors = $wpdb->get_results("SELECT h, s, l FROM wp_colors WHERE post_id = $post_id");
 
  switch ($column) {
  	case "image":
  		echo get_the_post_thumbnail($post_id, array(100,72) );
  	break;
    case "appearance":
      if(isset($custom["format"][0])){
	      if($custom["format"][0]==0) echo "Sketch";
	      if($custom["format"][0]==1) echo "One-Off";
	      if($custom["format"][0]==2) echo "Series";
      }
      break;
    case "year":
      if(isset($custom["year_published"][0])){
      	echo $custom["year_published"][0];
      }
      break;
    case "colors":

      foreach($colors as $color){
            
      	$cssh = round(($color->h / 255) * 360);				//css hsl(0-360, 0-100%, 0-100%)
      	$csss = round(($color->s / 255) * 100); $csss .= "%";
      	$cssl = round(($color->l / 255) * 100); $cssl .= "%";
      	
      	echo "<div style='float: left; margin: 0 4px; width: 36px; height: 24px; background-color: hsl($cssh,$csss,$cssl);'></div>";
      }
      break;
    case "dr_tags":
      echo get_the_term_list($post->ID, 'dr_tags', '', ', ','');
      break;  
    case "designers":
      echo get_the_term_list($post->ID, 'dr_designers', '', ', ','');
      break;
    case "manufactors":
      echo get_the_term_list($post->ID, 'dr_manufactors', '', ', ','');
      break;    
  }
}

// CLUSTER LIST ADMIN

add_action("manage_posts_custom_column",  "dr_cluster_custom_columns");
add_filter("manage_edit-dr_cluster_columns", "dr_cluster_edit_columns");
 
function dr_cluster_edit_columns($columns){
  $columns = array(
    "cb" => "<input type=\"checkbox\" />",
    "title" => "Title",
    "objects" => "Objects",    
    "essence" => "Essence",
    "comments" => "<img src='images/comment-grey-bubble.png'>",
    "date" => "Date"
  );
 
  return $columns;
}

function dr_cluster_custom_columns($column){
  global $post, $wpdb;
  $custom = get_post_custom();
  
  //setup featured objects
  $exponent = isset($custom['featured-object'][0]) ? $custom['featured-object'][0] : ""; 
  $objects = isset($custom['object_id']) ? array_diff($custom['object_id'], array($exponent)) : array();
   
  switch ($column) {
  	case "essence":
  		echo isset($custom['essence'][0]) ? "<em>".$custom['essence'][0]."</em>" : "";
  	break;
    case "objects":
    	//echo exponent
    	echo get_the_post_thumbnail($exponent, array(100,72));
    	//echo all others - without exponent
    	foreach($objects as $obj){
    		echo get_the_post_thumbnail($obj, array(100,72));
    	}
    break;    
  }
}
?>