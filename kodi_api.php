<?php

$ip = $_GET['ip'];
$port = $_GET['port'];
$method_in = $_GET['method_in'];
$dir = $_GET['dir'];
$music_lib_dir = $_GET['music_lib_dir'];
$user = $_GET['user'];
$pwd = $_GET['pwd'];

if ( $method_in == "Player.SetShuffle_on" ) {
    $params = array("playerid" => 0, "shuffle" => true);
    $method = "Player.SetShuffle";
    $id = "0";
} elseif ( $method_in == "Player.SetShuffle_off" ) {
    $params = array("playerid" => 0, "shuffle" => false);
    $method = "Player.SetShuffle";
    $id = "0";
} elseif ( $method_in == "Player.GoTo_next" ) {
    $params = array("playerid" => 0, "to" => "next");
    $method = "Player.GoTo";
    $id = "0";
} elseif ( $method_in == "Player.GoTo_previous" ) {
    $params = array("playerid" => 0, "to" => "previous");
    $method = "Player.GoTo";
    $id = "0";
} elseif ( $method_in == "Player.Stop" ) {
    $params = array("playerid" => 0);
    $method = "Player.Stop";
    $id = "0";
} elseif ( $method_in == "Player.PlayPause" ) {
    $params = array("playerid" => 0);
    $method = "Player.PlayPause";
    $id = "0";
} elseif ( $method_in == "Player.Open" ) {
    $params = array("item" => array("directory" => $dir));
    $method = "Player.Open";
    $id = "0";
} elseif ( $method_in == "Player.GetItem" ) {
    $params = array("playerid" => 0, "properties" => array("artist","title","fil                            e"));
    $method = "Player.GetItem";
    $id = "AudioGetItem";
} elseif ( $method_in == "Files.GetDirectory" ) {
    $params = array("directory" => $music_lib_dir, "media" => "music");
    $method = "Files.GetDirectory";
    $id = "1";
} else {
    print "unknown method";
}

function httpPost($url, $data, $user, $pwd)
    {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json                            '));
    curl_setopt($curl, CURLOPT_USERPWD, "$user:$pwd");
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
    };

$data = array(
    "jsonrpc" => "2.0",
    "method" => $method,
    "params" => $params,
    "id" => $id
    );

$result_raw = httpPost("http://$ip:$port/jsonrpc", $data, $user, $pwd);

if ( $method_in == "Player.GetItem" ) {
    if($result_raw) {
        $result_json = json_decode($result_raw);
        $title = $result_json->result->item->title;
        $artist = $result_json->result->item->artist[0];
        $file = $result_json->result->item->file;
        if (isset($title)) {
            $scr_out = $title." - ".$artist;
        } elseif (isset($file)) {
            $scr_out = $file;
        } else {
            $scr_out = "ERROR ".$result_raw;
        }
    } else {
        $scr_out = "no response from XBMC";
    }
} elseif ( $method_in == "Files.GetDirectory" ) {
    if($result_raw) {
        $result_json = json_decode($result_raw);
        $result_field = $result_json->result;
        foreach ($result_field->files as $files_field) {
            if($files_field->filetype == 'directory') {
                 $dir_out[] = $files_field->label;
            }
        }
        $scr_out = implode("\n", $dir_out);
    } else {
        $scr_out = "No response";
    }
} else {
    $scr_out = $result_raw;
}
print($scr_out);

?>