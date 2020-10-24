<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
 <link rel="stylesheet" href="<?php echo base_url('assets/datepicker/css/datepicker.css'); ?>">
 <script src="<?php echo base_url('assets/datepicker/js/datepicker.js'); ?>"></script>
<script>
$('#myTable').DataTable({
	   "paging": true,
	  "lengthChange": false,
	  "searching": false,
	  //"ordering": false,
	  "info": true,
	  "autoWidth": true,
	  "columnDefs": [
        { "orderable": false, "targets": 0 }
      ],
      "order": [],
	  
});
$(".myselect").select2({
	theme: "bootstrap"
});
</script>