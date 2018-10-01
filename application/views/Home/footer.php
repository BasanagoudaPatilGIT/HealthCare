  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2016 <a href="<?php echo base_url()?>/Dashboard/index">TMT</a>.</strong> All rights
    reserved.
  </footer>

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?php echo base_url()?>LTE-Jar/bower_components/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url()?>LTE-Jar/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>


<!-- SlimScroll -->
<script src="<?php echo base_url()?>LTE-Jar/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- bootstrap time picker -->
<script src="<?php echo base_url()?>LTE-Jar/plugins/timepicker/bootstrap-timepicker.min.js"></script>

<!-- FastClick -->
<script src="<?php echo base_url()?>LTE-Jar/bower_components/fastclick/lib/fastclick.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo base_url()?>LTE-Jar/bower_components/raphael/raphael.min.js"></script>
<script src="<?php echo base_url()?>LTE-Jar/bower_components/morris.js/morris.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url()?>LTE-Jar/bower_components/chart.js/Chart.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>LTE-Jar/dist/js/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url()?>LTE-Jar/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="<?php echo base_url()?>LTE-Jar/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url()?>LTE-Jar/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url()?>LTE-Jar/dist/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url()?>LTE-Jar/dist/js/demo.js"></script>
<script src="<?php echo base_url()?>LTE-Jar/jquery-ui-1.12.1/jquery1.12.4.js"></script>
<script src="<?php echo base_url()?>LTE-Jar/jquery-ui-1.12.1/jquery-ui.js"></script>
<!-- bootstrap datepicker -->
<script src="<?php echo base_url()?>LTE-Jar/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script src="<?php echo base_url() ?>LTE-Jar/bower_components/dataTables.net/js/jquery.dataTables.min.js"></script>

<script src="<?php echo base_url() ?>LTE-Jar/bower_components/dataTables.net-bs/js/dataTables.bootstrap.min.js"></script>


<script>

 $(function () {
    $('#example1').DataTable(
	);
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
	  "scrollX": true,
	  "columnDefs": [ { "width": "20%", "targets": 2},{ "width": "30%", "targets": 3},
					  { "width": "30%", "targets": 4},]
    })
	
});

</script>
<script>
$('#packdate').datepicker({
	format: 'yyyy-mm-dd',
	endDate: '0d',
	autoclose:true,
	showOnFocus:true,
	todayHighlight:true,
});
</script>

<script>
$('#expdate').datepicker({
	format: 'yyyy-mm-dd',
	startDate: '2d',
	autoclose:true,
	showOnFocus:true,
	todayHighlight:true,
});
</script>


<script>
$(document).ready(function() {
$( "#productname" ).autocomplete({
  source: "<?php echo base_url()?>/Invoice/auto_search/?",
  select: function(event,ui){
$('[name="productname"]').val(ui.item.label);
$('[name="batchno"]').val(ui.item.batchno);
$('[name="productid"]').val(ui.item.id);
$('[name="productcode"]').val(ui.item.prodcode);
$('[name="stock"]').val(ui.item.stock);
$('[name="salerate"]').val(ui.item.price);
$('[name="tax"]').val(ui.item.tax);
$('[name="stripsinbox"]').val(ui.item.stripsinbox);
$('[name="pcsinstrip"]').val(ui.item.pcsinstrip);
$('[name="stockinbox"]').val(ui.item.stockinbox);
$('[name="stockinstrip"]').val(ui.item.stockinstrips);
$('[name="stockinpcs"]').val(ui.item.stock);
$('[name="qty"]').val(1);
$('[name="lineamount"]').val($('#qty').val() * $('#salerate').val());
$('[name="linetaxamt"]').val($('#lineamount').val() * $('#tax').val() /100);
$('[name="cbo_uom"]').val("Pcs");
}
});
});
</script>

<script type="text/javascript">
$('#fees').change(function(){
	$fees = $('#fees').val();
	$gross =  $('#totalgrossamt').val();
	$tax =  $('#totaltaxamt').val();
	//alert($gross);
	//alert($tax);
	if($fees != ''){
	$('#totalamt').val( Math.round((+$gross) + (+$tax) + (+$fees))+".00");
	}
});
</script>



<script type="text/javascript">
$('#cbo_uom').change(function(){
	$stock = $('#stock').val();
	$('#qty').val('');
	$('#lineamount').val('');
	$('#linetaxamt').val('');
	if($stock == ''){
	alert('Select Product Fisrt');
	}else{
	if($('#cbo_uom').val() == 'Boxes'){
	$('#stock').val($('#stockinbox').val());
	}else if($('#cbo_uom').val() == 'Strips'){
	$('#stock').val($('#stockinstrip').val());
	}else if($('#cbo_uom').val() == 'Pcs'){
	$('#stock').val($('#stockinpcs').val());
	}
	}
});
</script>


<script type="text/javascript">
$('#qty').change(function(){
	if($('#productname').val() == ''){
		alert('Please select product and then try');
		$('#qty').val('');
	}else{
	$stockinbox = $('#stockinbox').val();
	$stockinstrip = $('#stockinstrip').val();
	$stockinpcs = $('#stockinpcs').val();
	
	if($('#cbo_uom').val() == 'Boxes'){
	if($('#qty').val() >= $stockinbox ){
	alert("Entered Qty is more than stock");
	$('#qty').val('');
	$('#lineamount').val('');
	$('#linetaxamt').val('');
	}else{
	$amt = $('#qty').val() * $('#stripsinbox').val() * $('#pcsinstrip').val() * $('#salerate').val();
	$tax = $amt * $('#tax').val() /100;
	$('#linetaxamt').val($tax);
	$('#lineamount').val($amt);
	}
	}else if($('#cbo_uom').val() == 'Strips'){
	
	if($('#qty').val() >= $stockinstrip ){
	alert("Entered Qty is more than stock");
	$('#qty').val('');
	$('#lineamount').val('');
	$('#linetaxamt').val('');
	}else{
	$amt = $('#qty').val() * $('#pcsinstrip').val() * $('#salerate').val();
	$tax = $amt * $('#tax').val() /100;
	$('#linetaxamt').val($tax);
	$('#lineamount').val($amt);
	}
	}else if($('#cbo_uom').val() == 'Pcs'){
	
	if($('#qty').val() >= $stockinpcs ){
	alert("Entered Qty is more than stock");
	$('#qty').val('');
	$('#lineamount').val('');
	$('#linetaxamt').val('');
	}else{
	$amt = $('#qty').val() * $('#salerate').val();
	$tax = $amt * $('#tax').val() /100;
	$('#linetaxamt').val($tax);
	$('#lineamount').val($amt);
	}
	}
	}
});
</script>
  
  
<script>

$("#password").password({
    eyeClass: 'fa',
    eyeOpenClass: 'fa-eye',
    eyeCloseClass: 'fa-eye-slash'
})

</script>

<script>
  $(document).ready(function () {
    setInterval(refresh, 1000);
  });
</script>


<script>
$('#preview').click( function(){
	window.open( "<?php echo base_url()?>TestReport/reportpreview/<?php echo $testreport_row['id'];?>" )
});
</script>




<script type="text/javascript">
function passvar(id)
{ 
//alert(id);
$.ajax({
url:"<?php echo base_url();?>TestReport/getrows/"+id,
success: function(data)
{
$('#modulename').val(data.module_name);
$('#featurename').val(data.feature_name);
$('#highlevelscenario').val(data.high_level_scenario);
$('#checkpoints').val(data.checkpoints);
$('#executionstep').val(data.execution_steps);
$('#expectedresult').val(data.expected_result);
$('#cbo_status').val(data.test_status);
$('#updatebugid').val(data.bug_id);
$('#cbo_bug_status').val(data.bug_status);
$('#cbo_tester').val(data.tested_by);
$('#cbo_assign').val(data.assigned_to);
$('#cbo_dev_status').val(data.developer_status);
$('#comments').val(data.comments);
$('#idnum').val(data.id);
$('#idnumber').val(data.testcase_id);
//$('#comment').text(data.comments);
},
error: function(){alert('Error');}

});
}

</script>

<script type="text/javascript">
function allcomments(id)
{
//alert(id);
$.ajax({
		url:"<?php echo base_url();?>TestReport/get_comment_list/"+id,
		success: function(data){
			$(".oldcomments ul div").remove();
			$.each(data, function(key, value){
			$(".oldcomments ul").append("<div><li><span><b>"+ data[key].commented_by +"</b> ["+ data[key].commented_datetime +"]</span></li><div><pre>"+ data[key].comments+"</pre></div></div>");
			});
			}
		//error: function(){alert('Error');}
	});
}
</script>

<script>
 //DONUT CHART
    var donut = new Morris.Donut({
      element: 'sales-chart',
      resize: true,
      colors: ["#ff6347","#3cb371", "#8b7d7b","#e6b798"],
      data: [
        {label: "Failed", value: <?php echo $failed_count; ?>},
        {label: "Passed", value: <?php echo $pass_count; ?>},
        {label: "Not Completed", value: <?php echo $notcompleted_count; ?>},
        {label: "OnHold", value: <?php echo $onhold_count; ?>},
      ],
      hideHover: 'auto'
    });
	
</script>

<script>
//date_picker

$('#Doj').datepicker({
autoclose:true,
format:'dd-mm-dd'

});

//date_picker

$('#Dol').datepicker({
autoclose:true,
format:'yyyy-mm-dd'

});

//Date picker
$('#Dob').datepicker({
autoclose:true,
format:'yyyy-mm-dd'
});

//Date picker
$('.datepicker').datepicker({
autoclose: true,
format:'yyyy-mm-dd'
});

//Timepicker
$('.timepicker').timepicker({
showInputs: false
});

//bootstrap WYSIHTML5 - text editor
//$('.textarea').wysihtml5()
</script>


<script>
$(document).ready(function () {
$format = "%Y-%m-%d"; 
$dateval = mdate($format);
$val = $('#startdate').val();
alert($val);
alert($dateval);
if(true){}else{}
    
});
</script>
<script>
//Add Test Case
$('#addtestcase').click( function(){
var id = $('#cbo_project').val();
if(id =="SELECT")
alert("Please select a Project and then try");
else
window.location="<?php echo base_url();?>TestCase/addtestcase/"+id;

})
</script>
<script>
//Export Test Case
$('#exporttestcase').click( function(){
var id = $('#cbo_project').val();
if(id =="SELECT")
alert("Please select a Project and then try");
else
window.location="<?php echo base_url();?>Excel/export_test_cases/"+id;

})
</script>
<script>
//Template
$('#template').click( function(){
window.location="<?php echo base_url();?>Excel/test_case_template";
})
</script>

<script>
//import Test Case
$('#testupload').click( function(){
var id = $('#cbo_project').val();
if(id =="SELECT")
alert("Please select a Project and then try");
else
window.location="<?php echo base_url();?>Excel/uploadtestcase/"+id;

})
</script>


<script>
//Create Test Report
$('#createreport').click( function(){
	var id = $('#cbo_project').val();
	if(id =="SELECT")
	alert("Please select a Project and then try");
	else
	window.location="<?php echo base_url();?>TestReport/createtestreport/"+id;
	
});

$('#statusupdatebtn').click( function(){
	var id = $('#idnum').val();
	//alert(id);
	
	 $.ajax({
		method:'POST',
		url:"<?php echo base_url();?>TestReport/updatetestreportstatus/"+id,
		data: $('#updaterecord').serialize(),
		success : function(data){alert('Record Updated Successfully')},
		error: function(){}
		
	});

	
});


</script>


<script>
$('#senarioupdatebtn').click( function(){
	var id = $('#idnum').val();
	//alert(id);
	 $.ajax({
		method:'POST',
		url:"<?php echo base_url();?>TestReport/updatetestreportscenario/"+id,
		data: $('#updatescerecord').serialize(),
		success : function(data){alert('Record Updated Successfully')},
		error: function(){}
		
	});

	
});
</script>
<script>
$('#appdetails').click( function(){
	var id = <?php echo $_SESSION['REPORTID'];?>;
	//alert(id);
	 $.ajax({
		method:'POST',
		url:"<?php echo base_url()?>TestReport/add_login_details/"+id,
		data: $('#addappdetails').serialize(),
		success : function(data){alert('Record Updated Successfully')},
		error: function(){}
		
	});

	
});
</script>

<?php /*?><script>
$('#testupload').click( function(){
	var id = $('#cbo_project_file').val();
	var val = $('#file').val();
	if(id =="SELECT" || val == '')
	alert("Please select a Project and file then try");
	else{
	//alert(id);
	 $.ajax({
		method:'POST',
		url:"<?php echo base_url()?>Excel/import_test_cases/"+id,
		data: $('#testcaseupload').serialize(),
		success : function(data){alert('Record Updated Successfully')},
		error: function(){}
		
	});
	}
	
});
</script><?php */?>


<script>

//FAMILY ADD
  $('#add_desc').click(function(){
		//alert('xyz');
		
		desc_row = $('#app_Block li:first').clone(true);
		desc_row.find('input[type=text]').val('');
		desc_row.find('input[type=file]').val('');
		desc_row.find('input[type=hidden]').val('');
		desc_row.find('select').val('');
		$('#app_Block').append(desc_row);
	});
		
   $('.remove_desc').click(function(){
		//alert('xyz');
	if ( $('#app_Block li').length > 1 ){
		$(this).closest('li').remove();
		getTotal()
	}
   });//FAMILY END

</script>
</body>
</html>

