<table width="50%" class="table table-bordered table-responsive">
<b>Departments</b>
<thead>
    <tr>
      <th scope="col"><b>#</b></th>
      <th scope="col"><b>Name</b></th>
	  </tr>
</thead>  
<?php if(!empty($dep_names)){$i=1;foreach($dep_names as $dep){?>
	  <tr>
      <th scope="row"><?php print $i;?></th>
      <td><?php print $dep['name'];?></td>
	  </tr>
<?php $i++; }} ?>
</table>
<table width="50%" class="table table-bordered table-responsive">
<b>Employees</b>
<thead>
    <tr>
      <th scope="col"><b>#</b></th>
      <th scope="col"><b>Name</b></th>
	  </tr>
</thead>  
<?php if(!empty($emps_names)){$j=1; foreach($emps_names as $emp){
	
	 ?>
	  <tr>
      <th scope="row"><?php print $i;?></th>
      <td><?php print $emp['staffname'];?></td>
	  </tr>
<?php $j++;  }} ?>
</table>

<table class="table">
	 <h2 >Break Details</h2>
	   <thead>
    <tr>
      <th scope="col"><b>#</b></th>
      <th scope="col"><b>Break Title</b></th>
      <th scope="col"><b>Start Time</b></th>
      <th scope="col"><b>End Time</b></th>
    </tr>
  </thead>
	   <?php if(!empty($result)){$i=1;foreach($result as $eachSupp){?>
	  <tr>
      <th scope="row"><?php print $i;?></th>
      <td><?php print $eachSupp['breakname'];?></td>
      <td><?php print $eachSupp['start_time'];?></td>
      <td><?php print $eachSupp['end_time'];?></td>
    </tr>
	   <?php $i++;}}?>
	   </table>
	  