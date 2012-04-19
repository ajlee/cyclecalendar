    


<?php



//gets the locations anc councils and boroughs from mapit in greater manchester and creates categories for them in WP
function update_category_locations() {

	//$json = file_get_contents("http://mapit.mysociety.org/area/9100"); //ancoats
	$kml_array = array ();
	//$kml_array["manchester"]["url"] = "http://mapit.mysociety.org/area/2528/children";
//	$kml_array["Manchester"]["id"] = "2528";
	$kml_array["Bury"]["id"] = "2517";
	$kml_array["Oldham"]["id"] = "2531";
	$kml_array["Rochdale"]["id"] = "2532";
	$kml_array["Salford"]["id"] = "2534";
	$kml_array["Stockport"]["id"] = "2540";

	$kml_array["Tameside"]["id"] = "2543";
	$kml_array["Trafford"]["id"] = "2544";
	$kml_array["Wigan"]["id"] = "2547";
	$kml_array["Bolton"]["id"] = "2515";

	foreach($kml_array as $key => $council)
	{

		$urltocall = "http://mapit.mysociety.org/area/".$council["id"]."/children";
		$kml_array[$key]["children"] = json_decode(file_get_contents($urltocall),true);
	}


  //  wp_insert_term( 'test2', 'event-category', array ('parent'=>'locations') );
	
	foreach ($kml_array as $councilname => $council)
	{
			wp_insert_term( $councilname, 'event-category', array ('parent'=>'10') );
			$tax = get_term_by("name", $councilname, 'event-category');

			wp_insert_term( 'test', 'event-category', array ('parent'=>get_term_by($councilname, $cat_name, 'event-category')));

			foreach ($council['children'] as $key => $val) {
				wp_insert_term( $val['name'], 'event-category', array ('parent'=>$tax->term_id));
			}

	}
}

function get_category_id($cat_name){
	$term = get_term_by('name', $cat_name, 'category');
	return $term->term_id;
}
?>
