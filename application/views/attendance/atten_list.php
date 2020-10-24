<?php $appconfig = get_appconfig(); ?>
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
                <md-table-container>
          <table md-table  md-progress="promise" ng-cloak>
            <thead md-head md-order="task_list.order">
              <tr md-row>
                <th md-column md-order-by="name"><span><?php echo 'Date'; ?></span></th>
                 <th md-column md-order-by="address"><span><?php echo 'Employee'; ?></span></th> 
				
                <th md-column md-order-by="cperson"><span><?php echo 'Time In'; ?></span></th>
               <th md-column md-order-by="cnum"><span><?php echo 'Time Out'; ?></span></th>
				  <th md-column md-order-by="cemail"><span><?php echo 'Total Hours' ?></span></th> 
			
              </tr>
            </thead>
        
                <?php foreach($attend_details as $details) {   ?>
                <tr class="select_row" md-row >
                <td md-cell><?php echo $details["attendance_date"];?></td>
                 <td md-cell><?php echo $details["staffname"];?></td>
                 <?php $days = explode(',',$details["day"]);  ?>
                  <td md-cell><?php echo $days["0"];?></td>
                   <td md-cell><?php echo $days["1"];?></td>
                    <td md-cell><?php echo $details["staff_id"];?></td>
                    </tr>
                <?php } ?>
                </tbody>
          </table>
        </md-table-container>
            
       
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/attendance.js'); ?>"></script>

