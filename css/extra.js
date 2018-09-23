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
//document.getElementById("highlevelscenario").innerHTML = data.high_level_scenario;
$('#checkpoints').val(data.checkpoints);
$('#executionstep').val(data.execution_steps);
$('#expectedresult').val(data.expected_result);
$('#cbo_status').val(data.test_status);
$('#updatebugid').val(data.bug_id);
$('#cbo_bug_status').val(data.bug_status);
$('#cbo_tester').val(data.tested_by);
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
			$(".oldcomments ul").append("<div><li><span class='h5'>"+ data[key].commented_by +"</span><span>  ["+ data[key].commented_datetime +"]</span></li><div><pre>"+ data[key].comments+"</pre></div></div>");
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
      colors: ["green", "red", "#8b7d7b","#e6b798"],
      data: [
        {label: "Passed", value: <?php echo $pass_count; ?>},
        {label: "Failed", value: <?php echo $failed_count; ?>},
        {label: "Not Completed", value: <?php echo $notcompleted_count; ?>},
        {label: "OnHold", value: <?php echo $onhold_count; ?>},
      ],
      hideHover: 'auto'
    });
	
</script>
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree();
  });

  
  
   $(function () {
    $('#example1').DataTable(
	
	)
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
	  "scrollX": true,
	  "columnDefs": [ { "width": "30%", "targets": 4}]
    })
	
	$('#example3').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
	  "scrollX": true,
	  "columnDefs": [ { "width": "30%", "targets": 2}],
	  "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
    })
	
});




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