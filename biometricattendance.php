<?php
/****************************************
/*  Author 	: Kvvaradha
/*  Module 	: Extended HRM
/*  E-mail 	: admin@kvcodes.com
/*  Version : 1.0
/*  Http 	: www.kvcodes.com
*****************************************/
  /*  $servername = "localhost";
    $username = "ecodelinfotel_crm";
    $password = "MQgFimE0UJIF";
    $dbname = "ecodelinfotel_crm"; */
    
    
    $servername = "localhost";
    $username = "onebook_ecodelinfotel";
    $password = "MQgFimE0UJIF";
    $dbname = "onebook_ecodelinfotel_crm";
    
    // Create connection
    $conn =mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (mysqli_connect_errno()) {
        die("Database Connection failed: " . $conn->connect_error);
    }
    
 
function get_all_fiscalyears($conn)
{
	$sql = "SELECT * FROM fiscal_year ORDER BY begin";
   	return mysqli_query($conn,$sql);
   	
}

function get_fiscal_year_id_from_date($date,$conn){
	$attendance_date = strtotime($date);
	$all_fiscal_years  = get_all_fiscalyears($conn);

	
	while($get_des=mysqli_fetch_assoc($all_fiscal_years)){
		$begin = strtotime($get_des['begin']);
		$end = strtotime($get_des['end']); 
		
		
		if( ($begin <= $attendance_date) && ($end >= $attendance_date)){
		    
		    $year = $get_des['id'];
			break;
		}
	}
	
//	return $year;
		return 3; 
}

function db_has_day_attendancee($empl_id, $month, $year,$conn){
	$sql = "SELECT COUNT(*) FROM staff_attendance WHERE month='".$month."' AND staff_id='".$empl_id."' AND year='".$year."'";
	
	$res=mysqli_query($conn,$sql);
	$row=mysqli_fetch_array($res);
	return $row[0];
}

function add_employee_attendance($empl_attend, $empl_id, $month, $year, $day,$dept_id,$attendance_date,$timing,$conn){
	 
	    $dayy = "day_".(int)$day;
	$sql = "INSERT INTO staff_attendance (staff_id, month, year, `{$dayy}`,department,attendance_date) VALUES ('".$empl_id."', '".$month."', '".$year."','".$empl_attend."','".$dept_id."','".$attendance_date."')";
	
	mysqli_query($conn,$sql);
	
		$sql1 = "INSERT INTO staff_attendance_timings (staff_id, month, year, `{$dayy}`,department,attendance_date) VALUES ('".$empl_id."', '".$month."', '".$year."','".$timing."','".$dept_id."','".$attendance_date."')";
	
	mysqli_query($conn,$sql1);
}




//--------------------------------------------------------------------------------------------
function update_employee_attendance($empl_attend, $empl_id, $month, $year, $day,$timing,$conn){
	$dayy = "day_".(int)$day;
	$sql = "UPDATE staff_attendance SET `{$dayy}` ='".$empl_attend."' WHERE month='".$month."' AND staff_id='".$empl_id."' AND year='".$year."'";
    mysqli_query($conn,$sql);
    
    
    $sql = "select  `{$dayy}` from staff_attendance_timings  WHERE month='".$month."' AND staff_id='".$empl_id."' AND year='".$year."'";
    	
     	$res=mysqli_query($conn,$sql);
	    $row=mysqli_fetch_array($res);
	    $timing_values= $row[0];
	    
        if($timing_values=='')
        {
		$sql = "UPDATE staff_attendance_timings SET `{$dayy}` ='".$timing."' WHERE month='".$month."' AND staff_id='".$empl_id."' AND year='".$year."'";
            mysqli_query($conn,$sql);
        }

}

function db_has_day_attendancee_timings($empl_id, $month, $year,$day,$conn){
	$sql = "SELECT COUNT(*) FROM attendance_log WHERE month='".$month."' AND empl_id='".$empl_id."' AND year='".$year."' AND day='".$day."'";
	
	$res=mysqli_query($conn,$sql);
	$row=mysqli_fetch_array($res);
	
		return $row[0];
}

function add_attendance_log($empl_id, $month, $year, $day,$hour, $min,$sec,$conn)
{
        $dayy = (int)$day;
        $dayy1 = "day_".(int)$day;
        
        $time_=$hour.":".$min.":".$sec;
		
		$time_=$hour.":".$min.":".$sec;
		
		$date_=$year."-".$month.":".$day;
        
        $login_type="";
        
        if($sec%10==1)
        $login_type="in";
        if($sec%10==2)
        $login_type="out";
	
	if($login_type=="out"){
		$attsql = "SELECT * FROM attendance_log WHERE  empl_id='".$empl_id."' AND punch_date='".$date_."' AND type='in'  ";
		
		$attres=mysqli_query($conn,$attsql);
		$row=mysqli_fetch_array($attres);
		
		if(empty($row)){
			$inssql = "INSERT INTO attendance_log(empl_id, month, year,day,hour,min,sec,type,time,punch_date) VALUES ('".$empl_id."', '".$month."', '".$year."','".$dayy."','0','0','0','in','00:00:00','".$date_."')";
			mysqli_query($conn,$inssql);
			
		}
	}
        
    	$sql = "INSERT INTO attendance_log(empl_id, month, year,day,hour,min,sec,type,time,punch_date) VALUES ('".$empl_id."', '".$month."', '".$year."','".$dayy."','".$hour."','".$min."','".$sec."','".$login_type."','".$time_."','".$date_."')";
    	
         mysqli_query($conn,$sql);
         
 if(db_has_day_attendancee_timings($empl_id, $month, $year,$day,$conn)>1)
 {
     	$sql = "select  `{$dayy1}` from staff_attendance_timings  WHERE month='".$month."' AND staff_id='".$empl_id."' AND year='".$year."'";
    	
     	$res=mysqli_query($conn,$sql);
	    $row=mysqli_fetch_array($res);
	    $timing_values= $row[0];
	    $starting_time = explode(",", $timing_values);
	    $starting_time=$starting_time[0];
	    $ending_time=$hour.":".$min;
	    $timing=$starting_time.",".$ending_time;
	    $sql = "UPDATE staff_attendance_timings SET `{$dayy1}` ='".$timing."' WHERE month='".$month."' AND staff_id='".$empl_id."' AND year='".$year."'";
    mysqli_query($conn,$sql);
 }
         
}


function get_employee_dept_id($empl_id,$conn){
	
	$sql="SELECT department_id FROM staff WHERE id='".$empl_id."'";

    $res=mysqli_query($conn,$sql);
	$row=mysqli_fetch_array($res);
	return $row[0];
}
	
$qs = str_replace('$', '', $_SERVER['QUERY_STRING']); // get rid of the $
$qs = str_replace('*', '', $qs); // get rid of the *

$submissions = explode(',', $qs); // split the subs

$SID = ""; // store for sid
$MID = ""; // store for mid

// loop
for ($i = 0; $i < count($submissions); $i++) {
    $sections = explode('&', $submissions[$i]);

    if($i == 0) {
        $SID = $sections[0];
        $MID = $sections[1];
        $RFID = $sections[2];
        $DOT = $sections[3];
    } else {
        $RFID = $sections[0];
         $DOT = $sections[1];
       
    }
//Creates new record as per request
    //Connect to database
   
$string = $DOT;

$day = substr($string, 0, 2);
$month = substr($string, 2, 2);
$year = substr($string, 4, 4);

$hour = substr($string, 8, 2);
$min = substr($string, 10, 2);
$sec = substr($string, 12, 2);

$result_date = $day.'-'.$month.'-'.$year.' '.$hour.':'.$min.':'.$sec;

$result_date1 = $day.'/'.$month.'/'.$year;
$timing=$hour.":".$min;




		$attendance_date = strtotime(str_replace('/', '-',$result_date));
		$month = date("m", $attendance_date);
		$day = date("d", $attendance_date);

	//	$year = get_fiscal_year_id_from_date($result_date1,$conn);
		
        $dept_id=get_employee_dept_id($RFID,$conn);
	
	
	      

		if( db_has_day_attendancee($RFID, $month, $year,$conn)){
				update_employee_attendance('P',$RFID, $month, $year,$day,$timing,$conn);
			}else{
				add_employee_attendance('P',$RFID, $month, $year, $day,
					$dept_id,$attendance_date,$timing,$conn);
			}
			
			 add_attendance_log($RFID, $month, $year, $day,$hour, $min,$sec,$conn);

    	     
		    echo'$RFID=0#'; 
		
		}

?>