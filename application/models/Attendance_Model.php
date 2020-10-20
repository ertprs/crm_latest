<?php
class Attendance_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function  get_attendance($current_date) {
        $this->db->join('attendance as a','a.staff_id = s.id AND a.attendance_date = "'.$current_date.'"','left' );
        $this->db->order_by('s.id','asc');
        $query = $this->db->get('staff as s');
        if($query->num_rows()>0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function get_attend_details($from_date,$to_date,$dep,$emp,$month){
      
             $curr_date = $from_date;
             $from_month = date("m", strtotime($curr_date));
        	$from_day = date("d", strtotime($curr_date));
        	$from_year = date("Y",strtotime($curr_date));
        	 
			 $to_month = date("m", strtotime($to_date));
			 $to_day = date("d", strtotime($to_date));
        	$to_year = date("Y",strtotime($to_date));

	
	
	 $sql = "SELECT timings.*,st.staffname,attendance_date,month FROM staff_attendance as timings LEFT JOIN staff as st ON st.id = timings.staff_id   WHERE month = '$month' AND year = '$to_year'  ";
	 
	
	// print_r($sql); die;
	$ret = $this->db->query($sql, "could not retrieve security roles");
 
        $result = $ret->result_array();
        
		
        return $result;
        
        
    }
	

	
    function get_current_attendance_timings($date){
      
             $curr_date = $date;
             $month = date("m", strtotime($curr_date));
        	$day = date("d", strtotime($curr_date));
        	$year = date("Y",strtotime($curr_date));
        	


	$degrees = array();
	$dayy = 'day_'.(int)$day;
	 $sql = "SELECT timings.staff_id, `{$dayy}` as day,st.staffname,attendance_date,atten.day_status FROM staff_attendance_timings as timings LEFT JOIN staff as st ON st.id = timings.staff_id  
	           LEFT JOIN (SELECT staff_id, `{$dayy}` as day_status FROM staff_attendance WHERE month = '$month' AND year = '$year' ) as atten ON atten.staff_id = timings.staff_id
	 
	  WHERE month = '$month' AND year = '$year' ";
	 
	 //echo $sql;
	$ret = $this->db->query($sql, "could not retrieve security roles");
 
        $result = $ret->result_array();
        
        //echo '<pre>'; print_r($result); die;
        return $result;
        
        
    }
	
	function get_current_attendance_log($date,$staffid){
		  $curr_date = $date;
             $month = date("m", strtotime($curr_date));
        	$day = date("d", strtotime($curr_date));
        	$year = date("Y",strtotime($curr_date));
			$where='';
			if($staffid!=''){
				$where .= " AND empl_id IN ($emp)";
			}
			
			    $sql1="Select InTime.empl_id,InTime.time As CheckInTime,OutTime.time As CheckOutTime,st.staffname,InTime.*
From 
    (Select * From attendance_log Where type = 'in'  '".$where."' AND `day`='".(int)$day."' AND `month`='".(int)$month."' AND `year`='".$year."') As InTime
    Left Join 
    (Select * From attendance_log Where type = 'Out' '".$where."' AND `day`='".(int)$day."' AND `month`='".(int)$month."' AND `year`='".$year."') As OutTime	
    On InTime.`empl_id` = OutTime.`empl_id`
    And InTime.time < OutTime.time  AND InTime.`day`='".(int)$day."' AND InTime.`month`='".(int)$month."' AND InTime.`year`='".$year."'
	LEFT JOIN staff as st ON st.id = InTime.empl_id  
	where  st.staff_status=1
Group By  InTime.`empl_id`,InTime.`time` 

UNION 

SELECT staff.id as empl_id,null as CheckInTime,null as CheckOutTime,staff.staffname,null as id,staff.id as empl_id,$month as month,$year as year,$day as day,'0' as hour,'0' as min,'0' as sec,'in' as type,'00:00:00' as time,$curr_date as punch_date,null as payment_type,null as type_of_leave FROM staff WHERE staff.id NOT IN (SELECT empl_id FROM attendance_log
                WHERE day ='".(int)$day."' AND month ='".(int)$month."' AND year='".$year."') AND staff.staff_status = '1' ";
//print_r($sql1); die;
$ret = $this->db->query($sql1, "could not retrieve security roles");
 
        $result = $ret->result_array();
        
        //echo '<pre>'; print_r($result); die;
        return $result;
	}
	
	function get_filter_attendance_log($from_date,$to_date,$dep='',$emp='',$month=''){
		//echo $from_date;exit;
		//echo $emp;exit;
		$where ='';
      if($from_date != '' && $to_date != ''){
             $curr_date = $from_date;
             $from_month = date("m", strtotime($curr_date));
        	$from_day = date("d", strtotime($curr_date));
        	$from_year = date("Y",strtotime($curr_date));
			 
	  
        	 
			 $to_month = date("m", strtotime($to_date));
			 $to_day = date("d", strtotime($to_date));
        	$to_year = date("Y",strtotime($to_date));
			$where .= " AND punch_date between '".$from_date."' and '".$to_date."'";
			
	  }
			
			 if($emp != ''){
		 $where .= " AND empl_id IN ($emp)";
	 }
			
			       $sql1="Select InTime.empl_id,InTime.time As CheckInTime,OutTime.time As CheckOutTime,st.staffname,InTime.*
From 
    (Select * From attendance_log Where type = 'in'    ".$where.") As InTime
    Left Join 
    (Select * From attendance_log Where type = 'Out' ".$where." ) As OutTime	
    On InTime.`empl_id` = OutTime.`empl_id`
    And InTime.time < OutTime.time  
	And InTime.punch_date = OutTime.punch_date
	 JOIN staff as st ON st.id = InTime.empl_id 
where  st.staff_status=1
 
Group By  InTime.`empl_id`,InTime.`id` order by InTime.empl_id ASC,InTime.punch_date ASC";
$ret = $this->db->query($sql1, "could not retrieve security roles");
 
        $result = $ret->result_array();
        
        //echo '<pre>'; print_r($result); die;
        return $result;
	
		
	} 
	function get_report_attendance_log($date,$id){
		  $curr_date = $date;
             $month = date("m", strtotime($curr_date));
        	$day = date("d", strtotime($curr_date));
        	$year = date("Y",strtotime($curr_date));
			
			   $sql1="Select InTime.empl_id,InTime.time As CheckInTime,OutTime.time As CheckOutTime,st.staffname,InTime.*
From 
    (Select * From attendance_log Where type = 'in'  AND `day`='".(int)$day."' AND `month`='".(int)$month."' AND `year`='".$year."' AND `empl_id`='".$id."') As InTime
    Left Join 
    (Select * From attendance_log Where type = 'Out'  AND `day`='".(int)$day."' AND `month`='".(int)$month."' AND `year`='".$year."' AND `empl_id`='".$id."') As OutTime	
    On InTime.`empl_id` = OutTime.`empl_id`
    And InTime.time < OutTime.time  AND InTime.`day`='".(int)$day."' AND InTime.`month`='".(int)$month."' AND InTime.`year`='".$year."'
	LEFT JOIN staff as st ON st.id = InTime.empl_id  
Group By  InTime.`empl_id` order by InTime.empl_id ASC";
//print_r($sql1);
$ret = $this->db->query($sql1, "could not retrieve security roles");
 
        $result = $ret->result_array();
        
        //echo '<pre>'; print_r($result); die;
        return $result;	
	} 
	
	
	function  get_staff_attendance($first_date,$last_date) {
		$staffid=$this->session->userdata( 'usr_id' );
         $sql = "SELECT *,st.staffname FROM staff_attendance as sa  JOIN staff as st ON st.id = sa.staff_id WHERE  sa.attendance_date >= '".$first_date."' AND sa.attendance_date <= '".$last_date."' and sa.staff_id='".$staffid."'";
      
            
        $res = $this->db->query($sql);
       
        $result = $res->result_array();
        
        return $result;
    }
    
    function getmonthlyattendance($department,$from_date,$to_date){
        
        $sql = "SELECT *,st.staffname FROM staff_attendance as sa LEFT JOIN staff as st ON st.id = sa.staff_id WHERE  sa.attendance_date >= '$from_date' AND sa.attendance_date <= '$to_date'";
      
      if($department != ''){
          $sql .= " AND sa.department = '$department'";
      }
      
        $res = $this->db->query($sql);
       
        $result = $res->result_array();
        
        return $result;
        
    }
	
	function get_attendance_sheet($id,$date){
		
		 $sql = "SELECT *,st.staffname FROM staff_attendance as sa LEFT JOIN staff as st ON st.id = sa.staff_id WHERE  sa.attendance_date = '".$date."' AND sa.staff_id = '".$id."'";
      
   
      
        $res = $this->db->query($sql);
       
        $result = $res->row_array();
        
        return $result;
	}
    
	function getmonthlyattendance_new($department=''){
        
        $sql = "SELECT * FROM staff as sa    ";
      
      if($department != '' && $department!=0){
		  $departments = "'" . implode ( "', '", $department ) . "'";
		  //$departments = implode(",", $department);
          $sql .= " where  sa.department_id IN ( ".$departments.")";
      }
	// echo $sql;exit;
      
        $res = $this->db->query($sql);
       
        $result = $res->result_array();
        
        return $result;
        
    }
     function getmonthlytimings($department,$from_date,$to_date){
         
         $sql = "SELECT * FROM staff_attendance_timings as sa WHERE  sa.attendance_date >= '$from_date' AND sa.attendance_date <= '$to_date'";
        
         if($department != ''){
          $sql .= " AND sa.department = '$department'";
      }
      
          $res = $this->db->query($sql);
       
        $result = $res->result_array();
        
        return $result;
        
    }
	
	 function get_attendance_time_sheet($staffid,$date){
         
         $sql = "SELECT * FROM staff_attendance_timings as sa WHERE  sa.attendance_date = '".$date."' AND sa.staff_id = '".$staffid."'";
        
         
      
          $res = $this->db->query($sql);
       
        $result = $res->row_array();
        
        return $result;
        
    }

    function get_all_dept_staff($department_id) {
		$this->db->select( '*,departments.name as department, staff.id as id' );
		$this->db->join( 'departments', 'staff.department_id = departments.id', 'left' );
		return $this->db->get_where( 'staff', array( 'department_id' => $department_id ) )->result_array();
	}

    function  get_staff() {
        $query = $this->db->get('staff as s');
        if($query->num_rows()>0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function  save($data) {
        $query = $this->db->insert('staff_attendance', $data); 
        if($query){ return true; } else { return false; }
    }
    
     function  savetimings($data) {
        $query = $this->db->insert('staff_attendance_timings', $data); 
        if($query){ return true; } else { return false; }
    }
	function saveothours($data)
	{
		$query = $this->db->insert('staff_ot_hours',$data);
		
		if($query) {  return true; } else {   return false; }
		
	}


function update_attendance($id,$params,$month,$year){
    
    	$this->db->where( 'staff_id', $id );
    	$this->db->where( 'month', $month );
    		$this->db->where( 'year', $year );
    		$this->db->where( 'department', $params['department']);
    		//	$this->db->where( 'attendance_date', $params['attendance_date'] );
    	
		$this->db->update( 'staff_attendance', $params);
}


function updatetimings($id,$params,$month,$year){
   
    	$this->db->where( 'staff_id', $id );
    		$this->db->where( 'month', $month );
    		$this->db->where( 'year', $year );
    		$this->db->where( 'department', $params['department']);
    		//	$this->db->where( 'attendance_date', $params['attendance_date'] );
    	
		$this->db->update( 'staff_attendance_timings', $params);
}
function update_ot($id,$params,$month,$year){
   
    	$this->db->where( 'staff_id', $id );
    		$this->db->where( 'month', '$month' );
    		$this->db->where( 'year', $year );
    		$this->db->where( 'department', $params['department']);
    		//	$this->db->where( 'attendance_date', $params['attendance_date'] );
    	
		$this->db->update( 'staff_ot_hours', $params);
		echo $this->db->last_query(); die;
}


    function  get_today($staff_id,$current_date) {
        $this->db->where('staff_id',$staff_id );
        $this->db->where('attendance_date',$current_date );
        $query = $this->db->get('attendance');
        return $query->num_rows();
    }
    
    function get_attendance_details($department,$attendance_date){
        
    $month = date("m", strtotime($attendance_date));
	$day = date("d", strtotime($attendance_date));

	$degrees = array();
	$dayy = 'day_'.(int)$day;
	$sql = "SELECT staff_id, `{$dayy}` FROM staff_attendance WHERE attendance_date='$attendance_date'  AND department='$department'";
	$ret = $this->db->query($sql, "could not retrieve security roles");
//	while($get_des=$ret->result_array()){
	    foreach($ret->result_array() as $get_des){
 
	    //print_r($get_des);
	    
		$degrees[$get_des['staff_id']] = $get_des[$dayy];	
	}
	return $degrees;
        
    }
	
	function get_attendance_details_multi($department,$attendance_date,$month,$year){
        
    $month = date("m", strtotime($attendance_date));
	$day = date("d", strtotime($attendance_date));

	$degrees = array();
	$dayy = 'day_'.(int)$day;
	 $sql = "SELECT staff_id, `{$dayy}` FROM staff_attendance WHERE  month = '$month' AND year = '$year' AND department in ($department)";
	$ret = $this->db->query($sql, "could not retrieve security roles");
//	while($get_des=$ret->result_array()){
	    foreach($ret->result_array() as $get_des){
 
	    //print_r($get_des);
	    
		$degrees[$get_des['staff_id']] = $get_des[$dayy];	
	}
	return $degrees;
        
    }
    
    function get_attendance_details_count($department,$attendance_date,$month,$year,$emp_id){
        
    $month = date("m", strtotime($attendance_date));
	$day = date("d", strtotime($attendance_date));

	$degrees = array();
	$dayy = 'day_'.(int)$day;
	 $sql = "SELECT count(*) as count FROM staff_attendance WHERE  month = '$month' AND year = '$year' AND staff_id = '$emp_id' AND department in ($department)";
	$ret = $this->db->query($sql, "could not retrieve security roles");
//	while($get_des=$ret->result_array()){
	    //print_r($sql); die;
	return $ret->row_array();
        
    }
    function get_attendance_timing_details_count($department,$attendance_date,$month,$year,$emp_id){
        
    $month = date("m", strtotime($attendance_date));
	$day = date("d", strtotime($attendance_date));

	$degrees = array();
	$dayy = 'day_'.(int)$day;
	 $sql = "SELECT count(*) as count FROM staff_attendance_timings WHERE  month = '$month' AND year = '$year' AND staff_id = '$emp_id' AND department in ($department)";
	$ret = $this->db->query($sql, "could not retrieve security roles");
//	while($get_des=$ret->result_array()){
	    //print_r($sql); die;
	return $ret->row_array();
        
    }
    //get_attendance_ot_details_count
    function get_attendance_ot_details_count($department,$attendance_date,$month,$year,$emp_id){
        
    $month = date("m", strtotime($attendance_date));
	$day = date("d", strtotime($attendance_date));

	$degrees = array();
	$dayy = 'day_'.(int)$day;
	 $sql = "SELECT count(*) as count FROM staff_ot_hours WHERE  month = '$month' AND year = '$year' AND staff_id = '$emp_id' AND department in ($department)";
	$ret = $this->db->query($sql, "could not retrieve security roles");
//	while($get_des=$ret->result_array()){
	    //print_r($sql); die;
	return $ret->row_array();
        
    }
    
    
    
    function get_attendance_timings($department,$attendance_date){
        
    $month = date("m", strtotime($attendance_date));
	$day = date("d", strtotime($attendance_date));

	$degrees = array();
	$dayy = 'day_'.(int)$day;
	$sql = "SELECT staff_id, `{$dayy}` FROM staff_attendance_timings WHERE attendance_date='$attendance_date'  AND department='$department'";
	$ret = $this->db->query($sql, "could not retrieve security roles");
//	while($get_des=$ret->result_array()){
	    foreach($ret->result_array() as $get_des){
 
	    //print_r($get_des);
	    
		$degrees[$get_des['staff_id']] = $get_des[$dayy];	
	}
	return $degrees;
        
    }
	
	function get_attendance_timings_multi($department,$attendance_date){
        
    $month = date("m", strtotime($attendance_date));
	$day = date("d", strtotime($attendance_date));

	$degrees = array();
	$dayy = 'day_'.(int)$day;
	 $sql = "SELECT staff_id, `{$dayy}` FROM staff_attendance_timings WHERE attendance_date='$attendance_date'  AND department in ($department)";
	$ret = $this->db->query($sql, "could not retrieve security roles");
//	while($get_des=$ret->result_array()){
	    foreach($ret->result_array() as $get_des){
 
	    //print_r($get_des);
	    
		$degrees[$get_des['staff_id']] = $get_des[$dayy];	
	}
	return $degrees;
        
    }
	
	
	 function get_ot_hours($department,$attendance_date){
        
    $month = date("m", strtotime($attendance_date));
	$day = date("d", strtotime($attendance_date));

	$degrees = array();
	$dayy = 'day_'.(int)$day;
	 $sql = "SELECT staff_id, `{$dayy}` FROM staff_ot_hours WHERE attendance_date='$attendance_date'  AND department in ($department)";
	$ret = $this->db->query($sql, "could not retrieve security roles");
//	while($get_des=$ret->result_array()){
	    foreach($ret->result_array() as $get_des){
 
	    //print_r($get_des);
	    
		$degrees[$get_des['staff_id']] = $get_des[$dayy];	
	}
	return $degrees;
        
    }
	
	function get_attendance_time($id){
    $id = (int)$id;
    	//$sql = "SELECT * FROM staff_work_plan where staff_id='".$id."'   ";
      
      $sql = "SELECT * FROM workshift  WHERE FIND_IN_SET('$id',employee_id)";
      //print_r($sql);
        $res = $this->db->query($sql);
       
        $result = $res->row_array();
        
        return $result;
}

    function get_break_timings($id){
        $id = (int) $id;
          $sql = "SELECT * FROM workshift  WHERE FIND_IN_SET('$id',employee_id)";
      //print_r($sql); 
        $res = $this->db->query($sql);
       
        $result = $res->row_array();
        
        $sql1 = "SELECT * FROM workshift_break_timings WHERE shift_id = '$result[shift_id]'";
        
        $res1 = $this->db->query($sql1);
        
        $break_result = $res1->result_array();
        
        return $break_result;
    }


function get_time_difference($start_time, $current_time)
{
	/*
	$time1 = strtotime("1/1/1980 $time1");
	$time2 = strtotime("1/1/1980 $time2");

if ($time2 < $time1)
{
	$time2 = $time2 + 86400;
}

return date("H:i:s", strtotime("1980-01-01 00:00:00") + ($time2 - $time1));*/
$start_t = new DateTime($start_time);
$current_t = new DateTime($current_time);
$difference = $start_t ->diff($current_t );
return $return_time = $difference ->format('%H:%I:%S');

}
function get_time_diff($start_time, $current_time)
{
	
	$start_t = new DateTime($start_time);
$current_t = new DateTime($current_time);

$difference = $start_t ->diff($current_t );

return $return_time = $difference ->format('%H Hrs %I Min');

}
function next_day_continuation($attendance_date,$emp_id){
    
   $next_day =  date('Y-m-d', strtotime($attendance_date. ' + 1 day'));
   
    $sql = "SELECT * FROM attendance_log WHERE punch_date = '$next_day' AND empl_id='$emp_id' ORDER BY id Limit 1";
   
  // echo $sql;
    $res = $this->db->query($sql);
    $result = $res->row_array();
    $inres = $result;
    $next_day_contine = 0;
   
        if($inres['hour'] == '0' && $inres['type'] == 'in'){
            
             $next_day_continue = 1;
        }
        else if($inres['hour'] != '0' && $inres['type'] == 'out' ){
            
             $next_day_continue = 1;
        }
        else{
             $next_day_continue = 0;
        }
        
    
 return $next_day_continue;
}

function next_day_prstatus($attendance_date,$emp_id){
    
   $next_day =  date('Y-m-d', strtotime($attendance_date. ' + 1 day'));
   
    $sql = "SELECT * FROM attendance_log WHERE punch_date = '$next_day' AND empl_id='$emp_id' ORDER BY id Limit 1";
   
  // echo $sql;
    $res = $this->db->query($sql);
    $result = $res->row_array();
    $inres = $result;
    $next_day_contine = 0;
   
        if($inres['hour'] != '0' && $inres['type'] == 'in'){
            
             $next_day_continue = 1;
        }
       
        else{
             $next_day_continue = 0;
        }
        
    
 return $next_day_continue;
}



   
   function get_current_day_leaves($staff_id){
       $date = date('Y-m-d');
      //$date = '2020-04-02';
    $sql = "SELECT * FROM staff_leaves WHERE staff_id='$staff_id' AND '$date' >= leave_start_date and '$date' < rejoin_date ";
    $res = $this->db->query($sql);
    $result  = $res->row_array();
    
    return $result;
       
   
   }
   
   public function get_attendance_report($startDt, $endDt, $users)
    {
        $this->db->query("CALL ProcessAttendance('$startDt', '$endDt', '$users')");
		$sql = "SELECT att.*,s.staffname as EmployeeName FROM attendancereport att inner join staff s on s.id = att.EmpID";
		$res = $this->db->query($sql);
        return $res->result_array();
   }
   public function get_all_staff(){
       $sql = "SELECT * FROM staff WHERE 1 = 1";
       $res = $this->db->query($sql);
       $result = $res->result_array();
       return $result;
   }
}