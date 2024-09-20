<?php 


	function sanitize($str){
		global $db;
		return mysqli_real_escape_string($db, $str);
	}
    function sqL($table)
	{
		global $db;
		$sql=$db->query("SELECT * FROM $table " )or die(mysqli_error($db));	
		return mysqli_num_rows($sql);
	}
    function sqL1($table,$col1,$val1)
	{
		global $db;
		$sql=$db->query("SELECT * FROM $table WHERE $col1='$val1' " )or die(mysqli_error($db));	
		return mysqli_num_rows($sql);
	}    

	function sqL2($table,$col1,$val1,$col2,$val2)
	{
		global $db;
		$sql=$db->query("SELECT * FROM $table WHERE $col1='$val1' AND $col2='$val2' " )or die(mysqli_error($db));	
		return mysqli_num_rows($sql);
	}
	function sqL3($table,$col1,$val1,$col2,$val2,$col3,$val3)
	{
		global $db;
		$sql=$db->query("SELECT * FROM $table WHERE $col1='$val1' AND $col2='$val2' AND $col3='$val3' " )or die(mysqli_error($db));	
		return mysqli_num_rows($sql);
	}
	function sqLx($table,$col1,$val1,$col)
	{
		global $db;
	$sql=$db->query("SELECT * FROM $table WHERE $col1='$val1' " )or die(mysqli_error($db));	
        if(mysqli_num_rows($sql)==0){return ''; }
		$row = mysqli_fetch_assoc($sql); 
		return $row[$col];
	}	
	function sqLx2($table,$col1,$val1,$col2,$val2,$col)
	{
		global $db;
	$sql=$db->query("SELECT * FROM $table WHERE $col1='$val1' AND $col2='$val2' " )or die(mysqli_error($db));	
        if(mysqli_num_rows($sql)==0){return ''; }
		$row = mysqli_fetch_assoc($sql); 
		return $row[$col];
	}	

	function sqLx3($table,$col1,$val1,$col2,$val2,$col3,$val3,$col)
	{
		global $db;
	$sql=$db->query("SELECT * FROM $table WHERE $col1='$val1' AND $col2='$val2' AND $col3='$val3' " )or die(mysqli_error($db));	
        if(mysqli_num_rows($sql)==0){return ''; }
		$row = mysqli_fetch_assoc($sql); 
		return $row[$col];
	}	


	function checkSize($image_size){
	    if($image_size <= 1048576){
	        return true;
	    }
	    else {
	        return false;
	    }
	}
	function checkExtension($end){
	    $array = array('jpg','jpeg','gif','png');

	    if(in_array($end,$array)){
	        return true;
	    }
	    else { return false; }
	}
	function userName($id,$col=''){
	    global $db;
	    $sql = $db->query("SELECT * FROM user WHERE id='$id'  ");
        if(mysqli_num_rows($sql)==0){return '';}
	    $row = $sql->fetch_assoc();
	    $val = ($col=='')? $row['firstname'].' '.$row['lastname']: $row[$col];
	    return $val;
	}
	function dTable($head,$body,$sql,$action=0)
	{
		$action1 = $action;
		$i=0; $x=0;
		$n = count($head);
		$m = count($body);

		$act = $action==0 ? '' : '<th>Action</th>';

		$table='<table id="example1" class="table table-bordered table-striped sm">
		                  <thead>
		                  <tr>'; 
		            while($i<$n){ $a = $i++;
		                   
		                   $table .= '<th>'.$head[$a].'</th>';
		                  }
		                 $table .= $act.'</tr>
		                  </thead>
		                  <tbody>'; 
		while($row = mysqli_fetch_assoc($sql)) {
		$action = $action1==0 ? '' : '<td><form method="POST"><button type="submit" name="'.$action1[0].'" class="btn btn-xs btn-primary" value="'.$row[$action1[2]].'">'.$action1[1].'</button></form></td>';

              $table .= ' <tr>';
              $x=0;
              while($x<$m){ $y = $x++;
               $b = $row[$body[$y]];
               $table .= '<td>'.$b.'</td>';
              }
               $table .= $action.'</tr>';
            }
             
               $table .= '</tbody>
              <tfoot>
              <tr>';

              $i=0;
             while($i<$n){ $a = $i++;
               
               $table .= '<th>'.$head[$a].'</th>';
              }
              $table .= $act.'</tr>
              </tfoot>
            </table>';
               
		return $table;		  
	}


function teamInvSum($table, $col, $cola, $vala, $colb, $valb)
{
  global $db;
  $sql = $db->query("SELECT SUM($col) AS value_sum FROM $table WHERE $cola = '$vala' AND $colb = '$valb' ");
  $row = mysqli_fetch_assoc($sql);
  return $row['value_sum'];
}
  


function sqLsum($table,$col)
{
  global $db;
  $sql = $db->query("SELECT SUM($col) AS value_sum FROM $table ");
  $row = mysqli_fetch_assoc($sql);
  return $row['value_sum'];
}
  


function sqLsum1($table, $col, $cola, $vala)
{
  global $db;
  $sql = $db->query("SELECT SUM($col) AS value_sum FROM $table WHERE $cola = '$vala' ");
  $row = mysqli_fetch_assoc($sql);
  return $row['value_sum'];
}

function sqLsumx($table, $col, $cola, $vala,$valb)
{
	global $db;
  	$sql = $db->query("SELECT SUM($col) AS value_sum FROM $table WHERE $cola BETWEEN '$vala' AND '$valb' ");
 	$row = mysqli_fetch_assoc($sql);
  	return $row['value_sum'];
}
function sqLsumy($table, $col, $cola, $colb,$vala,$valb)
{
  global $db;
  $y =  strtotime(date('Y-m-d H:i:s'));
  $t = strtotime(date('Y-m-d H:i:s',strtotime('-1 days')));
  $sql = $db->query("SELECT SUM($col) AS value_sum FROM $table WHERE  $cola BETWEEN $t AND $y AND $colb BETWEEN $vala AND $valb");
  $row = mysqli_fetch_assoc($sql);
   return $row['value_sum'];
  
}
 
function sqLsum2($table, $col, $cola, $vala, $colb, $valb)
{
  global $db;
  $sql = $db->query("SELECT SUM($col) AS value_sum FROM $table WHERE $cola = '$vala' AND $colb = '$valb' ");
  $row = mysqli_fetch_assoc($sql);
  return $row['value_sum'];
}


    
    
function getOS() { 
  $user_agent     =   $_SERVER['HTTP_USER_AGENT'];

    $os_platform    =   "Unknown OS Platform";

    $os_array       =   array(
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );

    foreach ($os_array as $regex => $value) { 

        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }

    }   

    return strtolower($os_platform);

}


function dbInsert($table,$arr){
    global $db;
    $n = count($arr);
if($n==1){ 
    $k1 = array_keys($arr)[0];  $v1 = $arr[$k1];
    
    $sql = $db->query("INSERT INTO $table ($k1) VALUES ('$v1') ");
}
elseif($n==2){ 
    $k1 = array_keys($arr)[0];  $v1 = $arr[$k1];
    $k2 = array_keys($arr)[1];   $v2 = $arr[$k2];
 
    $sql = $db->query("INSERT INTO $table ($k1,$k2) VALUES ('$v1','$v2') ");
}
elseif($n==3){
    $k1 = array_keys($arr)[0]; $v1 = $arr[$k1];
    $k2 = array_keys($arr)[1]; $v2 = $arr[$k2];
    $k3 = array_keys($arr)[2]; $v3 = $arr[$k3];
   
    $sql = $db->query("INSERT INTO $table ($k1,$k2,$k3) VALUES ('$v1','$v2','$v3') ");

}
elseif($n==4){
    $k1 = array_keys($arr)[0]; $v1 = $arr[$k1];
    $k2 = array_keys($arr)[1]; $v2 = $arr[$k2];
    $k3 = array_keys($arr)[2]; $v3 = $arr[$k3];
    $k4 = array_keys($arr)[3]; $v4 = $arr[$k4];
   
    $sql = $db->query("INSERT INTO $table ($k1,$k2,$k3,$k4) VALUES ('$v1','$v2','$v3','$v4') ");
}
elseif($n==5){
    $k1 = array_keys($arr)[0]; $v1 = $arr[$k1];
    $k2 = array_keys($arr)[1]; $v2 = $arr[$k2];
    $k3 = array_keys($arr)[2]; $v3 = $arr[$k3];
    $k4 = array_keys($arr)[3]; $v4 = $arr[$k4];
    $k5 = array_keys($arr)[4]; $v5 = $arr[$k5];
   
    $sql = $db->query("INSERT INTO $table ($k1,$k2,$k3,$k4,$k5) VALUES ('$v1','$v2','$v3','$v4','$v5') ");
}
elseif($n==6){
    $k1 = array_keys($arr)[0]; $v1 = $arr[$k1];
    $k2 = array_keys($arr)[1]; $v2 = $arr[$k2];
    $k3 = array_keys($arr)[2]; $v3 = $arr[$k3];
    $k4 = array_keys($arr)[3]; $v4 = $arr[$k4];
    $k5 = array_keys($arr)[4]; $v5 = $arr[$k5];
    $k6 = array_keys($arr)[5]; $v6 = $arr[$k6];
   
    $sql = $db->query("INSERT INTO $table ($k1,$k2,$k3,$k4,$k5,$k6) VALUES ('$v1','$v2','$v3','$v4','$v5','$v6') ");
}
elseif($n==7){
    $k1 = array_keys($arr)[0]; $v1 = $arr[$k1];
    $k2 = array_keys($arr)[1]; $v2 = $arr[$k2];
    $k3 = array_keys($arr)[2]; $v3 = $arr[$k3];
    $k4 = array_keys($arr)[3]; $v4 = $arr[$k4];
    $k5 = array_keys($arr)[4]; $v5 = $arr[$k5];
    $k6 = array_keys($arr)[5]; $v6 = $arr[$k6];
    $k7 = array_keys($arr)[6]; $v7 = $arr[$k7];
   
    $sql = $db->query("INSERT INTO $table ($k1,$k2,$k3,$k4,$k5,$k6,$k7) VALUES ('$v1','$v2','$v3','$v4','$v5','$v6','$v7') ");
}
elseif($n==8){
    $k1 = array_keys($arr)[0]; $v1 = $arr[$k1];
    $k2 = array_keys($arr)[1]; $v2 = $arr[$k2];
    $k3 = array_keys($arr)[2]; $v3 = $arr[$k3];
    $k4 = array_keys($arr)[3]; $v4 = $arr[$k4];
    $k5 = array_keys($arr)[4]; $v5 = $arr[$k5];
    $k6 = array_keys($arr)[5]; $v6 = $arr[$k6];
    $k7 = array_keys($arr)[6]; $v7 = $arr[$k7];
    $k8 = array_keys($arr)[7]; $v8 = $arr[$k8];
   
    $sql = $db->query("INSERT INTO $table ($k1,$k2,$k3,$k4,$k5,$k6,$k7,$k8) VALUES ('$v1','$v2','$v3','$v4','$v5','$v6','$v7','$v8') ");
}
elseif($n==9){
    $k1 = array_keys($arr)[0]; $v1 = $arr[$k1];
    $k2 = array_keys($arr)[1]; $v2 = $arr[$k2];
    $k3 = array_keys($arr)[2]; $v3 = $arr[$k3];
    $k4 = array_keys($arr)[3]; $v4 = $arr[$k4];
    $k5 = array_keys($arr)[4]; $v5 = $arr[$k5];
    $k6 = array_keys($arr)[5]; $v6 = $arr[$k6];
    $k7 = array_keys($arr)[6]; $v7 = $arr[$k7];
    $k8 = array_keys($arr)[7]; $v8 = $arr[$k8];
    $k9 = array_keys($arr)[8]; $v9 = $arr[$k9];
   
    $sql = $db->query("INSERT INTO $table ($k1,$k2,$k3,$k4,$k5,$k6,$k7,$k8,$k9) VALUES ('$v1','$v2','$v3','$v4','$v5','$v6','$v7','$v8','$v9') ");
}
elseif($n==10){
    $k1 = array_keys($arr)[0]; $v1 = $arr[$k1];
    $k2 = array_keys($arr)[1]; $v2 = $arr[$k2];
    $k3 = array_keys($arr)[2]; $v3 = $arr[$k3];
    $k4 = array_keys($arr)[3]; $v4 = $arr[$k4];
    $k5 = array_keys($arr)[4]; $v5 = $arr[$k5];
    $k6 = array_keys($arr)[5]; $v6 = $arr[$k6];
    $k7 = array_keys($arr)[6]; $v7 = $arr[$k7];
    $k8 = array_keys($arr)[7]; $v8 = $arr[$k8];
    $k9 = array_keys($arr)[8]; $v9 = $arr[$k9];
    $k10 = array_keys($arr)[9]; $v10 = $arr[$k10];
   
    $sql = $db->query("INSERT INTO $table ($k1,$k2,$k3,$k4,$k5,$k6,$k7,$k8,$k9,$k10) VALUES ('$v1','$v2','$v3','$v4','$v5','$v6','$v7','$v8','$v9','$v10') ");
}
elseif($n==11){
    $k1 = array_keys($arr)[0]; $v1 = $arr[$k1];
    $k2 = array_keys($arr)[1]; $v2 = $arr[$k2];
    $k3 = array_keys($arr)[2]; $v3 = $arr[$k3];
    $k4 = array_keys($arr)[3]; $v4 = $arr[$k4];
    $k5 = array_keys($arr)[4]; $v5 = $arr[$k5];
    $k6 = array_keys($arr)[5]; $v6 = $arr[$k6];
    $k7 = array_keys($arr)[6]; $v7 = $arr[$k7];
    $k8 = array_keys($arr)[7]; $v8 = $arr[$k8];
    $k9 = array_keys($arr)[8]; $v9 = $arr[$k9];
    $k10 = array_keys($arr)[9]; $v10 = $arr[$k10];
    $k11 = array_keys($arr)[10]; $v11 = $arr[$k11];
   
    $sql = $db->query("INSERT INTO $table ($k1,$k2,$k3,$k4,$k5,$k6,$k7,$k8,$k9,$k10,$k11) VALUES ('$v1','$v2','$v3','$v4','$v5','$v6','$v7','$v8','$v9','$v10','$v11') ");
}
elseif($n==12){
    $k1 = array_keys($arr)[0]; $v1 = $arr[$k1];
    $k2 = array_keys($arr)[1]; $v2 = $arr[$k2];
    $k3 = array_keys($arr)[2]; $v3 = $arr[$k3];
    $k4 = array_keys($arr)[3]; $v4 = $arr[$k4];
    $k5 = array_keys($arr)[4]; $v5 = $arr[$k5];
    $k6 = array_keys($arr)[5]; $v6 = $arr[$k6];
    $k7 = array_keys($arr)[6]; $v7 = $arr[$k7];
    $k8 = array_keys($arr)[7]; $v8 = $arr[$k8];
    $k9 = array_keys($arr)[8]; $v9 = $arr[$k9];
    $k10 = array_keys($arr)[9]; $v10 = $arr[$k10];
    $k11 = array_keys($arr)[10]; $v11 = $arr[$k11];
    $k12 = array_keys($arr)[11]; $v12 = $arr[$k12];
   
    $sql = $db->query("INSERT INTO $table ($k1,$k2,$k3,$k4,$k5,$k6,$k7,$k8,$k9,$k10,$k11,$k12) VALUES ('$v1','$v2','$v3','$v4','$v5','$v6','$v7','$v8','$v9','$v10','$v11','$v12') ");
}
elseif($n==13){
    $k1 = array_keys($arr)[0]; $v1 = $arr[$k1];
    $k2 = array_keys($arr)[1]; $v2 = $arr[$k2];
    $k3 = array_keys($arr)[2]; $v3 = $arr[$k3];
    $k4 = array_keys($arr)[3]; $v4 = $arr[$k4];
    $k5 = array_keys($arr)[4]; $v5 = $arr[$k5];
    $k6 = array_keys($arr)[5]; $v6 = $arr[$k6];
    $k7 = array_keys($arr)[6]; $v7 = $arr[$k7];
    $k8 = array_keys($arr)[7]; $v8 = $arr[$k8];
    $k9 = array_keys($arr)[8]; $v9 = $arr[$k9];
    $k10 = array_keys($arr)[9]; $v10 = $arr[$k10];
    $k11 = array_keys($arr)[10]; $v11 = $arr[$k11];
    $k12 = array_keys($arr)[11]; $v12 = $arr[$k12];
    $k13 = array_keys($arr)[12]; $v13 = $arr[$k13];
   
    $sql = $db->query("INSERT INTO $table ($k1,$k2,$k3,$k4,$k5,$k6,$k7,$k8,$k9,$k10,$k11,$k12,$k13) VALUES ('$v1','$v2','$v3','$v4','$v5','$v6','$v7','$v8','$v9','$v10','$v11','$v12','$v13') ");
}
if($sql){return mysqli_insert_id($db); }else{return 0;} 

}


function dbSelect($table,$arr=[]){
    global $db;
    $n = count($arr);
if($n==0){  $sql = $db->query("SELECT * FROM $table "); }
elseif($n==1){  $k1 = array_keys($arr)[0];  $v1 = $arr[$k1];
  $sql = $db->query("SELECT * FROM $table WHERE $k1='$v1' ");
}
elseif($n==2){  $k1 = array_keys($arr)[0];  $v1 = $arr[$k1];
                $k2 = array_keys($arr)[1];  $v2 = $arr[$k2];

  $sql = $db->query("SELECT * FROM $table WHERE $k1='$v1' AND $k2='$v2' ");
}
elseif($n==3){  $k1 = array_keys($arr)[0];  $v1 = $arr[$k1];
                $k2 = array_keys($arr)[1];  $v2 = $arr[$k2];
                $k3 = array_keys($arr)[2]; $v3 = $arr[$k3];
 

  $sql = $db->query("SELECT * FROM $table WHERE $k1='$v1' AND $k2='$v2' AND $k3='$v3' ");
}
elseif($n==4){  $k1 = array_keys($arr)[0];  $v1 = $arr[$k1];
                $k2 = array_keys($arr)[1];  $v2 = $arr[$k2];
                $k3 = array_keys($arr)[2]; $v3 = $arr[$k3];
                $k4 = array_keys($arr)[3]; $v4 = $arr[$k4];

  $sql = $db->query("SELECT * FROM $table WHERE $k1='$v1' AND $k2='$v2' AND $k3='$v3' AND $k4='$v4' ");
}
elseif($n==5){  $k1 = array_keys($arr)[0];  $v1 = $arr[$k1];
                $k2 = array_keys($arr)[1];  $v2 = $arr[$k2];
                $k3 = array_keys($arr)[2]; $v3 = $arr[$k3];
                $k4 = array_keys($arr)[3]; $v4 = $arr[$k4];
                $k5 = array_keys($arr)[4]; $v5 = $arr[$k5];

  $sql = $db->query("SELECT * FROM $table WHERE $k1='$v1' AND $k2='$v2' AND $k3='$v3' AND $k4='$v4' AND $k5='$v5' ");
}
elseif($n==6){  $k1 = array_keys($arr)[0]; $v1 = $arr[$k1];
                $k2 = array_keys($arr)[1]; $v2 = $arr[$k2];
                 $k3 = array_keys($arr)[2]; $v3 = $arr[$k3];
                $k4 = array_keys($arr)[3]; $v4 = $arr[$k4];
                 $k5 = array_keys($arr)[4]; $v5 = $arr[$k5];
                 $k6 = array_keys($arr)[5]; $v6 = $arr[$k6];

  $sql = $db->query("SELECT * FROM $table WHERE $k1='$v1' AND $k2='$v2' AND $k3='$v3' AND $k4='$v4' AND $k5='$v5' AND $k6='$v6' ");
}
return $sql; 
}



function dbSelectOr($table,$arr){
    global $db;
    $n = count($arr);
if($n==1){  $k1 = array_keys($arr)[0];  $v1 = $arr[$k1];
  $sql = $db->query("SELECT * FROM $table WHERE $k1='$v1' ");
}
elseif($n==2){  $k1 = array_keys($arr)[0];  $v1 = $arr[$k1];
                $k2 = array_keys($arr)[1];  $v2 = $arr[$k2];

  $sql = $db->query("SELECT * FROM $table WHERE $k1='$v1' OR $k2='$v2' ");
}
elseif($n==3){  $k1 = array_keys($arr)[0];  $v1 = $arr[$k1];
                $k2 = array_keys($arr)[1];  $v2 = $arr[$k2];
                $k3 = array_keys($arr)[2]; $v3 = $arr[$k3];
 

  $sql = $db->query("SELECT * FROM $table WHERE $k1='$v1' OR $k2='$v2' OR $k3='$v3' ");
}
elseif($n==4){  $k1 = array_keys($arr)[0];  $v1 = $arr[$k1];
                $k2 = array_keys($arr)[1];  $v2 = $arr[$k2];
                $k3 = array_keys($arr)[2]; $v3 = $arr[$k3];
                $k4 = array_keys($arr)[3]; $v4 = $arr[$k4];

  $sql = $db->query("SELECT * FROM $table WHERE $k1='$v1' OR $k2='$v2' OR $k3='$v3' OR $k4='$v4' ");
}
elseif($n==5){  $k1 = array_keys($arr)[0];  $v1 = $arr[$k1];
                $k2 = array_keys($arr)[1];  $v2 = $arr[$k2];
                $k3 = array_keys($arr)[2]; $v3 = $arr[$k3];
                $k4 = array_keys($arr)[3]; $v4 = $arr[$k4];
                $k5 = array_keys($arr)[4]; $v5 = $arr[$k5];

  $sql = $db->query("SELECT * FROM $table WHERE $k1='$v1' OR $k2='$v2' OR $k3='$v3' OR $k4='$v4' OR $k5='$v5' ");
}
elseif($n==6){  $k1 = array_keys($arr)[0]; $v1 = $arr[$k1];
                $k2 = array_keys($arr)[1]; $v2 = $arr[$k2];
                 $k3 = array_keys($arr)[2]; $v3 = $arr[$k3];
                $k4 = array_keys($arr)[3]; $v4 = $arr[$k4];
                 $k5 = array_keys($arr)[4]; $v5 = $arr[$k5];
                 $k6 = array_keys($arr)[5]; $v6 = $arr[$k6];

  $sql = $db->query("SELECT * FROM $table WHERE $k1='$v1' OR $k2='$v2' OR $k3='$v3' OR $k4='$v4' OR $k5='$v5' OR $k6='$v6' ");
}
return $sql; 
}







function dbUpdate($table,$arr,$pkey){
    global $db;
    $n = count($arr);
     $key = array_keys($pkey)[0];  $val = $pkey[$key];

if($n==1){ $k1 = array_keys($arr)[0];  $v1 = $arr[$k1];              
  $sql = $db->query("UPDATE $table SET $k1='$v1' WHERE $key='$val' ");
}
elseif($n==2){ $k1 = array_keys($arr)[0];  $v1 = $arr[$k1];
              $k2 = array_keys($arr)[1];  $v2 = $arr[$k2];             
 $sql = $db->query("UPDATE $table SET $k1='$v1',$k2='$v2', WHERE $key='$val' ");
}
elseif($n==3){ $k1 = array_keys($arr)[0]; $v1 = $arr[$k1];
              $k2 = array_keys($arr)[1];  $v2 = $arr[$k2]; 
              $k3 = array_keys($arr)[2];  $v3 = $arr[$k3];           
 $sql = $db->query("UPDATE $table SET $k1='$v1',$k2='$v2',$k3='$v3' WHERE $key='$val' ");
}
elseif($n==4){ $k1 = array_keys($arr)[0];  $v1 = $arr[$k1];
              $k2 = array_keys($arr)[1];  $v2 = $arr[$k2];
              $k3 = array_keys($arr)[2]; $v3 = $arr[$k3];
              $k4 = array_keys($arr)[3]; $v4 = $arr[$k4];            
 $sql = $db->query("UPDATE $table SET $k1='$v1',$k2='$v2',$k3='$v3',$k4='$v4' WHERE $key='$val' ");
}
elseif($n==5){ $k1 = array_keys($arr)[0];  $v1 = $arr[$k1];
              $k2 = array_keys($arr)[1];  $v2 = $arr[$k2];
              $k3 = array_keys($arr)[2]; $v3 = $arr[$k3];
              $k4 = array_keys($arr)[3]; $v4 = $arr[$k4];
              $k5 = array_keys($arr)[4]; $v5 = $arr[$k5];             
 $sql = $db->query("UPDATE $table SET $k1='$v1',$k2='$v2',$k3='$v3',$k4='$v4',$k5='$v5' WHERE $key='$val' ");
}
elseif($n==6){ $k1 = array_keys($arr)[0];  $v1 = $arr[$k1];
              $k2 = array_keys($arr)[1];  $v2 = $arr[$k2]; 
              $k3 = array_keys($arr)[2]; $v3 = $arr[$k3];
              $k4 = array_keys($arr)[3]; $v4 = $arr[$k4];
              $k5 = array_keys($arr)[4]; $v5 = $arr[$k5];
              $k6 = array_keys($arr)[5]; $v6 = $arr[$k6];            
 $sql = $db->query("UPDATE $table SET $k1='$v1',$k2='$v2',$k3='$v3',$k4='$v4',$k5='$v5',$k6='$v6' WHERE $key='$val' ");
}
elseif($n==7){ $k1 = array_keys($arr)[0];  $v1 = $arr[$k1];
              $k2 = array_keys($arr)[1];  $v2 = $arr[$k2]; 
              $k3 = array_keys($arr)[2]; $v3 = $arr[$k3];
              $k4 = array_keys($arr)[3]; $v4 = $arr[$k4];
              $k5 = array_keys($arr)[4]; $v5 = $arr[$k5];
              $k6 = array_keys($arr)[5]; $v6 = $arr[$k6];            
              $k7 = array_keys($arr)[6]; $v7 = $arr[$k7];            
 $sql = $db->query("UPDATE $table SET $k1='$v1',$k2='$v2',$k3='$v3',$k4='$v4',$k5='$v5',$k6='$v6',$k7='$v7' WHERE $key='$val' ");
}
elseif($n==8){ $k1 = array_keys($arr)[0];  $v1 = $arr[$k1];
              $k2 = array_keys($arr)[1];  $v2 = $arr[$k2]; 
              $k3 = array_keys($arr)[2]; $v3 = $arr[$k3];
              $k4 = array_keys($arr)[3]; $v4 = $arr[$k4];
              $k5 = array_keys($arr)[4]; $v5 = $arr[$k5];
              $k6 = array_keys($arr)[5]; $v6 = $arr[$k6];            
              $k7 = array_keys($arr)[6]; $v7 = $arr[$k7];            
              $k8 = array_keys($arr)[7]; $v8 = $arr[$k8];            
 $sql = $db->query("UPDATE $table SET $k1='$v1',$k2='$v2',$k3='$v3',$k4='$v4',$k5='$v5',$k6='$v6',$k7='$v7',$k8='$v8' WHERE $key='$val' ");
}
elseif($n==9){ $k1 = array_keys($arr)[0];  $v1 = $arr[$k1];
              $k2 = array_keys($arr)[1];  $v2 = $arr[$k2]; 
              $k3 = array_keys($arr)[2]; $v3 = $arr[$k3];
              $k4 = array_keys($arr)[3]; $v4 = $arr[$k4];
              $k5 = array_keys($arr)[4]; $v5 = $arr[$k5];
              $k6 = array_keys($arr)[5]; $v6 = $arr[$k6];            
              $k7 = array_keys($arr)[6]; $v7 = $arr[$k7];            
              $k8 = array_keys($arr)[7]; $v8 = $arr[$k8];            
              $k9 = array_keys($arr)[8]; $v9 = $arr[$k9];            
 $sql = $db->query("UPDATE $table SET $k1='$v1',$k2='$v2',$k3='$v3',$k4='$v4',$k5='$v5',$k6='$v6',$k7='$v7',$k8='$v8',$k9='$v9' WHERE $key='$val' ");
}
elseif($n==10){ $k1 = array_keys($arr)[0];  $v1 = $arr[$k1];
              $k2 = array_keys($arr)[1];  $v2 = $arr[$k2]; 
              $k3 = array_keys($arr)[2]; $v3 = $arr[$k3];
              $k4 = array_keys($arr)[3]; $v4 = $arr[$k4];
              $k5 = array_keys($arr)[4]; $v5 = $arr[$k5];
              $k6 = array_keys($arr)[5]; $v6 = $arr[$k6];            
              $k7 = array_keys($arr)[6]; $v7 = $arr[$k7];            
              $k8 = array_keys($arr)[7]; $v8 = $arr[$k8];            
              $k9 = array_keys($arr)[8]; $v9 = $arr[$k9];            
              $k10 = array_keys($arr)[9]; $v10 = $arr[$k10];            
 $sql = $db->query("UPDATE $table SET $k1='$v1',$k2='$v2',$k3='$v3',$k4='$v4',$k5='$v5',$k6='$v6',$k7='$v7',$k8='$v8',$k9='$v9',$k10='$v10' WHERE $key='$val' ");
}
if($sql){return 'Successfully Updated'; }else{return 'Operation Failed';} 
}


function dbDelete($table,$arr){
    global $db;
    $n = count($arr);
if($n==1){ $k1 = array_keys($arr)[0];  $v1 = $arr[$k1];
    
  $sql = $db->query("DELETE FROM $table WHERE $k1='$v1' ");
}
elseif($n==2){ $k1 = array_keys($arr)[0];  $v1 = $arr[$k1];
               $k2 = array_keys($arr)[1];  $v2 = $arr[$k2]; 
    
  $sql = $db->query("DELETE FROM $table WHERE $k1='$v1' AND $k2='$v2' ");
}
if($sql){return 'Successfully Deleted'; }else{return 'Operation Failed';} 
}


function dbDeleteOr($table,$arr){
    global $db;
    $n = count($arr);
if($n==1){ $k1 = array_keys($arr)[0];  $v1 = $arr[$k1];
    
  $sql = $db->query("DELETE FROM $table WHERE $k1='$v1' ");
}
elseif($n==2){ $k1 = array_keys($arr)[0];  $v1 = $arr[$k1];
               $k2 = array_keys($arr)[1];  $v2 = $arr[$k2]; 
    
  $sql = $db->query("DELETE FROM $table WHERE $k1='$v1' OR $k2='$v2' ");
}
if($sql){return 'Successfully Updated'; }else{return 'Operation Failed';}  
}

//NOTES
//dbInsert is limoted to 10 fields
//dbSelect is limited to 6 fields
//dbSelectOr is limited to 6 fields
//dbUpdate is limited to 6 fields and 1 key
//dbDelete is limited to 2 keys
//dbDeleteOr is limited to 2 keys




?>