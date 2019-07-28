

<section class="features-icons bg-light" style="padding-top: 50px;">
    <div class="row">
        <div class="col text-center">
            <h1>Manage Database</h1>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
           <!-- <div class="col-md-2"></div> -->
           <div class="col-md-12">
              <div  id="result_container">
            </div><!-- end of col-md-6  -->
            <button class=" button btn btn-primary float-right" id="add_pain_btn" data-toggle="modal" data-target="#add_pain_modal">Add Pain Report</button>
    </div>
</div>
</section>
<!-- UPDATE MODAL -->
<div class="modal fade bd-example-modal-lg" id="modal_update" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">View</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="result_body">
            
        </div>
      </div>
      <div class="modal-footer">
        <div id="alert_msg">  
        </div>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="modal_update_pain">Save Changes</button>
      </div>
    </div>
  </div>
</div>
<!-- ADD MODAL -->
<div class="modal fade bd-example-modal-lg" id="add_pain_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                
                    <div class="form-group"><label for="pain_scale">Body parts name</label><select class="form-control" id="add_body_part" name=""></select></div>
                   <div class="form-group"><label for="">Pain Kind</label><input type="text" class="form-control" id="pain_kind" value=""></div>
                   <div class="form-group"><label for="">Frequency</label><input type="text" class="form-control" id="frequency" value=""></div>
                   <div class="form-group"><label for="">Pain Location</label><input type="text" class="form-control" id="pain_location" value=""></div>
                  <div class="form-group"><label for="">Pain Details</label><input type="text" class="form-control" id="pain_details" value=""></div>
                  <div class="form-group"><label for="">Report</label><textarea class="form-control" rows="5" id="report"></textarea></div>
      </div>
      <div class="modal-footer">
        <div id="add_ret_msg">  
        </div>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="modal_add_pain">Save Changes</button>
      </div>
    </div>
  </div>
</div>
<!-- DELETE MODAL -->
<div class="modal" id="delete_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">DELETE</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete?</p>
      </div>
      <div class="modal-footer">
        <div id="delete_ret_msg">  
        </div>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="confirm_delete">Confirm</button>
      </div>
    </div>
  </div>
</div>

<script>
  $.extend({
    get_all_pain_details: function(){
           $.post('get_all_pain_details',
            function( retdata ) {
             var data = $.parseJSON(retdata);
          
              $("#result_container").html('<h5>Pain Report Details</h5></br><table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-condensed table-hover" id="pain_list">');
                 $('#pain_list').dataTable({

                                
                                 "aoColumns": [
                                    { "sTitle": "Id&nbsp&nbsp","sWidth":"10px"},
                                    { "sTitle": "Body Parts Name","sWidth":"20px" },
                                    { "sTitle": "Pain Kind","sWidth":"30px" },
                                    { "sTitle": "Frequency" ,"sWidth":"30px"},
                                    { "sTitle": "Pain Location","sWidth":"50px" },
                                    { "sTitle": "Pain Details","sWidth":"40px" },
                                    { "sTitle": "Report" },
                                    { "sTitle": "Action","sWidth":"200px" }
                                    
                                 ]
                  });
                 $.each(data, function(i,val){
                        var edit_link = '<a href="#" id="'+val.id+'" class="edit_button" name="'+val.id+'" data-toggle="modal" data-target="#modal_user">'+val.id+'</a>';
                        var update_link = '<button type="button" id="'+val.id+'" class="update_button btn btn-info" name="'+val.id+'" data-toggle="modal" data-target="#modal_update" onclick="$.view('+val.id+');"><i class="far fa-edit"></i>Update</button>';
                        update_link+='<button type="button" id="'+val.id+'" class="delete_button btn btn-danger" name="'+val.id+'" data-toggle="modal" data-target="#delete_modal" onclick="$.get_id('+val.id+');" style="margin-left:5px;"><i class="fa fa-trash"></i>Delete</button>';

                        $('#pain_list').dataTable().fnAddData([edit_link,val.body_parts_name,val.pain_kind,val.frequency,val.pain_location,val.pain_details,val.report,update_link]);
                    }) 
             
                 
    

           

             
            });
      },
      view: function(id){
        
         localStorage.setItem('painid',id);
          $.post('get_specific_pain_details',{id:id},
              function( retdata ) {
             var data = $.parseJSON(retdata);

              var withtxt = 'with';
               if(data[0].frequency == 'Constant without' || data[0].frequency == 'Intermittent without'){
                  var withtxt = '';
                }
                var pain_details = ''
                if(data[0].pain_details !== 'Null'){
                    var pain_details = 'to '+data[0].pain_details;
                }
              
              

               var html = '<div class="panel panel-default">';
                  html+= '<div class="panel-body"><h5>'+data[0].frequency+', '+withtxt+' radiating symptoms '+pain_details+'</h5><p><span><strong>Neck Pain:</strong></span> The level of the patient`s pain is rated as x/10 on the visual analog scale where 0 is rated as no pain and 10 is equal to the worst imaginable pain. '+data[0].report+'</p></div><br>';

                   // html+= '<div class="form-group"><label for="">Body parts name:</label><input type="text" class="form-control" id="body_parts" value="'+data[0].body_parts_name+'" disabled></div>';
                   // html+= '<div class="form-group"><label for="">Body parts name:</label><input type="text" class="form-control" id="body_parts" value="'+data[0].body_parts_name+'" disabled></div>';
                   html+= '<div class="form-group"><label for="pain_scale">Body parts name</label><select class="form-control" id="body_parts" name=""></select></div>';
                   html+= '<div class="form-group"><label for="">Pain Kind</label><input type="text" class="form-control" id="pain_kind" value="'+data[0].pain_kind+'"></div>';
                   html+= '<div class="form-group"><label for="">Frequency</label><input type="text" class="form-control" id="frequency" value="'+data[0].frequency+'"></div>';
                   html+= '<div class="form-group"><label for="">Pain Location</label><input type="text" class="form-control" id="pain_location" value="'+data[0].pain_location+'"></div>';
                  html+=  '<div class="form-group"><label for="">Pain Details</label><input type="text" class="form-control" id="pain_details" value="'+data[0].pain_details+'"></div>';
                  html+=  '<div class="form-group"><label for="">Report</label><textarea class="form-control" rows="5" id="report">'+data[0].report+'</textarea></div>';
                  var id = 'body_parts';
                   $.get_body_parts(id);
          $('#result_body').html(html);
          });
      },
      update_pain_details:function(){
        var id = localStorage.getItem('painid');
        var body_parts = $('#body_parts').val();
        var frequency = $('#frequency').val();
        var pain_location = $('#pain_location').val();
        var pain_details = $('#pain_details').val();
        var pain_kind = $('#pain_kind').val();
        var report = $('#report').val(); 

         $.post('update_pain_details',{id:id,body_parts:body_parts,frequency:frequency,pain_location:pain_location,pain_details:pain_details,report:report,pain_kind:pain_kind},
              function( retdata ) {
             var data = $.parseJSON(retdata);
            var html='';
            if (retdata == '1'){
              html+='<div class="alert alert-success  float-left" role="alert">Saved Succesfully</div>';
            }else{
              html+='<div class="alert alert-warning  float-left" role="alert">Error: Please Fill all Fields</div>';
            }
            $('#alert_msg').html(html);
            
          });
      },
       get_body_parts: function(id){
        $.post('get_body_parts',
        function( data ) {
         var retdata = $.parseJSON(data)
      
          $.each(retdata, function( i, val ) {
              // html += '<option value="'+val.id+'">'+val.name+'</option>';
              $('#'+id+'').append($('<option>', {
                  value: val.id,
                  text: val.name
              })); 
          });
        });
    },
    save_pain_details: function(){
        var  body_part = $('#add_body_part').val();
       var frequency = $('#frequency').val();
       var  pain_location = $('#pain_location').val();
       var  pain_kind= $('#pain_kind').val();
       var pain_details = $('#pain_details').val();
       var report = $('#report').val();

       $.post('insert_pain',{'body_part':body_part, 'frequency':frequency, 'pain_location':pain_location,'pain_kind':pain_kind,'pain_details':pain_details,'report':report},
            
            function( data ) {
             var html='';
            if (data == '1'){
              html+='<div class="alert alert-success  float-left" role="alert">Saved Succesfully</div>';
            }else{
              html+='<div class="alert alert-warning  float-left" role="alert">Error: Please Fill all Fields</div>';
            }
            $('#add_ret_msg').html(html);
        });

    },
    get_id: function(id){
      localStorage.setItem('idtodelete', id);
    },
    delete_pain_details:function(id){
        $.post('delete_pain_details',{id:id},
        function( retdata ) {
         var data = $.parseJSON(retdata);

           var html='';
            if (data == '1'){
              html+='<div class="alert alert-success  float-left" role="alert">Deleted Succesfully</div>';
            }else{
              html+='<div class="alert alert-warning  float-left" role="alert">Error: Can`t Delete Data</div>';
            }
            $('#delete_ret_msg').html(html);
          
        });

    }
  });
</script>
<script>
    
$(document).ready(function(){ 

     $.get_all_pain_details();
    $('#modal_update_pain').on('click', function(){
        $.update_pain_details();   
    });

    $('#add_pain_btn').on('click', function(){
      var id ='add_body_part'
      $.get_body_parts(id);
    });
     $('#modal_add_pain').on('click', function(){
        $.save_pain_details(); 
    });
     $('#confirm_delete').on('click',function(){
      var id =  localStorage.getItem('idtodelete');
      $.delete_pain_details(id);
      
     })
 


    // $('#save_pain').on('click', function(){
    //    var  body_part = $('#body_part').val();
    //    var frequency = $('#frequency').val();
    //    var  pain_location = $('#pain_location').val();
    //    var  pain_kind= $('#pain_kind').val();
    //    var pain_details = $('#pain_details').val();
    //    var report = $('#report').val();

    //    $.post('painreport/insert_pain',{'body_part':body_part, 'frequency':frequency, 'pain_location':pain_location,'pain_kind':pain_kind,'pain_details':pain_details,'report':report},
            
    //         function( data ) {
    //          if(data == '1'){
    //           alert('success');
    //          }else{
    //           alert('failed');
    //          }
    //     });
       
    // })   
            
});
</script>





 
