<?php

function add_geo($user_id, $latitude, $longitude){
    global $wpdb;
    if ( !empty($latitude) && !empty($longitude) ) {
        $wpdb->get_results('INSERT INTO `sr_user_locations` (`id`, `user_id`, `latitude`, `longitude`) VALUES (NULL, ' . $user_id . ', "' . $latitude . '", "' . $longitude . '")');
    }
}

function set_location_newuser(){
    global $wpdb;
    $result = $wpdb->get_results('SELECT DISTINCT(sr_users.id) AS id 
                                        FROM `sr_users` 
                                        LEFT JOIN sr_bp_xprofile_data ON sr_bp_xprofile_data.user_id = sr_users.ID
                                        WHERE `sr_users`.ID NOT IN (SELECT user_id FROM sr_user_locations) ORDER BY sr_users.id
                                        AND (sr_bp_xprofile_data.value != \'\' AND sr_bp_xprofile_data.field_id = 5)');
    if( !empty($result) ){
        foreach($result as $row){
            $arr[] = $row->id;
        }
    }
    return $arr;
}

function get_adress(){
    global $wpdb;

    $sql_filter='';
    $res = array();
    $result_filter = set_location_newuser();
    if(!empty($result_filter)){
        $res_in  = implode(",", $result_filter);
        $sql_filter = ' AND sr_users.id IN ('.$res_in.')';
    }
    $result = $wpdb->get_results('SELECT sr_users.id as user_id, 
                            sr_users.display_name as name,
                            sr_bp_xprofile_data.id as xprofile_id,
                            sr_bp_xprofile_data.id as id, 
                            sr_bp_xprofile_data.value as value,
                            sr_bp_xprofile_data.field_id as field_id
                            FROM sr_users 
                            LEFT JOIN sr_bp_xprofile_data ON sr_bp_xprofile_data.user_id = sr_users.ID 
                            WHERE (sr_bp_xprofile_data.field_id = 5 OR sr_bp_xprofile_data.field_id = 6 OR sr_bp_xprofile_data.field_id = 7)'.$sql_filter);


    if( !empty($result) ){
        foreach($result as $row){
            if( $row->field_id == 5 ){
                $res[$row->user_id]['value'][1] = $row->value;
            }
            if( $row->field_id  == 6 ){
                $res[$row->user_id]['value'][2] = $row->value;
            }
            if( $row->field_id == 7 ){
                $res[$row->user_id]['value'][3] = $row->value;
            }
        }
    }

    return $res;
}

function get_geo($path){
    $result = array();
    $arrContextOptions=array(
        "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
    );

    $file_geo = file_get_contents($path, TRUE, stream_context_create($arrContextOptions));
    $json_arr=json_decode($file_geo,TRUE);
    $result['y'] = $json_arr['results'][0]['geometry']['viewport']['northeast']['lat'];
    $result['x'] = $json_arr['results'][0]['geometry']['viewport']['northeast']['lng'];

    return $result;
}


function set_json($prop){
    return array(
        "attributes" =>array(
               "FID"=> $prop['id'],
               "NAME" => $prop['name'],
                "CLASS" => "city",
                "ST"=> "ID",
                "POPULATION"=>11946
        ),
        "geometry"=> array(
          "x" => $prop['x'],
          "y" => $prop['y']
       )
    );
}

function general_json($srr){
    return array(
        "objectIdFieldName"=> "FID",
          "uniqueIdField"=> array(
                "name"=> "FID",
            "isSystemMaintained"=> true
          ),
          "globalIdFieldName"=> "",
          "geometryType"=> "esriGeometryPoint",
          "spatialReference"=> array(
           "wkid"=> 4326,
           "latestWkid"=> 4326
           ),
           "fields"=> [
                array(
                 "name"=> "FID",
                  "type" => "esriFieldTypeOID",
                  "alias"=> "FID",
                  "sqlType"=> "sqlTypeInteger",
                  "domain"=> null,
                  "defaultValue"=> null
                ),
                array(
                  "name"=> "NAME",
                  "type"=> "esriFieldTypeString",
                  "alias"=> "NAME",
                  "sqlType"=> "sqlTypeNVarchar",
                  "length"=> 57,
                  "domain"=> null,
                  "defaultValue"=> null
                ),
                array(
                  "name"=> "CLASS",
                  "type"=> "esriFieldTypeString",
                  "alias"=>"CLASS",
                  "sqlType"=> "sqlTypeNVarchar",
                  "length"=> 36,
                  "domain"=> null,
                  "defaultValue"=> null
                ),
                array(
                    "name"=>  "POPULATION",
                    "type"=>  "esriFieldTypeInteger",
                    "alias"=>  "POPULATION",
                    "sqlType"=>  "sqlTypeInteger",
                    "domain"=>  null,
                    "defaultValue"=>  null
                )
          ],
        "features"=> $srr
     );
}


function set_add_geo(){
    $res = get_adress();
    $res_add = false;
    $i=0;
    if( !empty($res) ){
        foreach($res as $id=>$row){
            if( !empty($row['value'][1]) && !empty($row['value'][2]) ) {
                $i++;
                $path = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $row['value'][1] . ',' . $row['value'][2] . '+View,+' . $row['value'][3] . '&key=AIzaSyD2mreDB3R3-z6qShyNe-3u6Nsk2OfjENU';
                $path = str_replace("#", "", $path);
                $path = str_replace(" ", "+", $path);
                $result = get_geo($path);
                $user_id = $id;
                $latitude = $result['x'];
                $longitude = $result['y'];
                add_geo($user_id, $latitude, $longitude);
                $res_add = true;
            }
        }
    }

    return $res_add;
}

function set_geo(){
    global $wpdb;
    $res = $wpdb->get_results('SELECT sr_users.display_name as name, 
                            sr_user_locations.*
                            FROM sr_user_locations 
                            LEFT JOIN sr_users ON sr_users.id = sr_user_locations.user_id');
    if( !empty($res) ){
        $i=0;
        foreach($res as $id=>$row){
            $i++;
            $prop['id'] = $row->user_id;
            $prop['x'] = $row->latitude;
            $prop['y'] = $row->longitude;
            $prop['name'] = $row->name;
            $prop['value'] = $i;
            $json_arr[] = set_json($prop);
        }
    }

    return $json_arr;
}

$res_add = set_add_geo();
if( $res_add ) {
    $result = set_geo();
    if (!empty($result)) {
        $res_byte = file_put_contents($_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/synergyjar/js/population.json', json_encode(general_json($result)));
    }
}

?>