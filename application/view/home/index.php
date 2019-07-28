

<section class="features-icons bg-light" style="padding-top: 50px;">
    <div class="row">
        <div class="col text-center">
            <h1>Pain Management Consultation Report Form</h1>
        </div>
    </div>
    <div class="container">
        <div class="row">
           <div class="col-md-2"></div>
           <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                      <div id="patient_info"></div>
                    </div>
                  </div>
                  <br>
                <div class="form-group">
                    <label for="q1">1.) What type of accident was the patient involved in?</label>
                      <select class="form-control" id="q1" name="q1">
                            <option value="Motor Vehicle Accident">Motor Vehicle Accident</option>
                            <option value="Slip and Fall">Slip and Fall</option>
                            <option value="Pedestrian">Pedestrian</option>
                      </select>
                </div>
                <div class="form-group">
                    <label for="q2">2.) Where were the patient located in the vehicle?</label>
                      <select class="form-control" id="q2" name="q2">
                            <option value="Driver">Driver</option>
                            <option value="Front">Front</option>
                            <option value="Rear Left">Rear Left</option>  
                            <option value="Rear Right">Rear Right</option>
                      </select>
                </div>
                <div class="form-group">
                    <label for="q3">3.) Where was the impact?</label>
                      <select class="form-control" id="q3" name="q3">
                            <option value="Front">Front </option>
                            <option value="Driver Side">Driver Side</option>
                            <option value="Passenger Side">Passenger Side</option>  
                            <option value="Rear">Rear</option>
                      </select>
                </div>
                <div class="form-group">
                    <label for="q4">4.) Was airbag deployed?</label>
                      <select class="form-control" id="q4" name="q4">
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                      </select>
                </div>
                <div class="form-group">
                    <label for="q5">5.) Did patient lose consciousness?</label>
                      <select class="form-control" id="q5" name="q5">
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                      </select>
                </div>
                <div class="form-group">
                    <label for="q6">6.) Did patient receive ambulatory services?</label>
                      <select class="form-control" id="q6" name="q6">
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                      </select>
                </div>
                <div class="form-group">
                    <label for="q7">7.) Was a police report filed?</label>
                      <select class="form-control" id="q7" name="q7">
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                      </select>
                </div>

                    <div id="save_result"></div>
                
                <button type="button" class="btn btn-success  float-right" id="save_accident_report_btn" style="margin-bottom: 10px;">Save <i class="far fa-save"></i></button><br>
                 
               
                <div id="result_pain" ></div><br>

                 <div class="card" style="margin-bottom: 10px;margin-top: 10px" id="mycard">
                  <div class="card-header">
                            8.) Please Choose below the symptoms you have: (add fields to state more body part)
                  </div>
                  <div class="card-body">
                        <div class="form-group">
                            <label for="pain_scale">A. Please Choose Body Parts</label>
                            <select class="form-control" id="body_part" name="pain_rate">
                                <option value="null">--Please Select--</option> 
                            </select>
                        </div>
                    
                         <div class="form-group">
                            <label for="pain_scale">A. How would you rate the pain on scale 1/10?</label>
                            <select class="form-control" id="pain_scale" name="pain_scale">
                                <option value="null">--Please Select--</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="frequency">B. Describe more the symptoms</label>
                            <select class="form-control" id="frequency" name="frequency">
                                <option value="null">--Please Select--</option>
                            </select><br>
                            <select class="form-control" id="pain_location" name="pain_location">
                                <option value="null" selected="selected">--Please Select--</option>
                                
                            </select><br>
                           <!--  <label for="">Pain Kind</label>
                            <select class="form-control" id="pain_kind" name="">
                                <option value="null">--Please Select--</option>
                            </select><br> -->
                            <div class="form-group">
                                <select class="form-control" id="pain_details" name="pain_details">
                                    <option value="null">--Please Select--</option>
                                
                            </select>
                            </div>
                        </div>
                            <button type="button" class="btn btn-primary float-right" id="export_word">Export Word <i class="far fa-file-word"></i></i></button>
                          <button type="button" class="btn btn-info float-right" id="save_pain_details" style="margin-right: 10px;">Add More <i class="fas fa-plus"></i></i></button>


                  </div>
                </div>
            </div><!-- end of col-md-6  -->
    </div>
</div>
</section>

<script>
  $.extend({
    save_patient_accident_report: function(patient_id){
        
        var accident_type = $('#q1').val();
        var patient_vehicle_loc = $('#q2').val();
        var impact_loc = $('#q3').val();
        var airbag_deployed = $('#q4').val();
        var lose_conscious = $('#q5').val();
        var receive_ambulatory_srvcs = $('#q6').val();
        var police_report_filed = $('#q7').val();
 

        $.post('painreport/save_patient_accident_report',
            {
                patient_id:patient_id,
                accident_type:accident_type,
                patient_vehicle_loc:patient_vehicle_loc,
                impact_loc:impact_loc,
                airbag_deployed:airbag_deployed,
                lose_conscious:lose_conscious,
                receive_ambulatory_srvcs:receive_ambulatory_srvcs,
                police_report_filed:police_report_filed
                },
        function( data ) {
          var html = '';
          if(data =='1'){
              
              html+='<div class="alert alert-success alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Data has been saved Succesfully</div>';

            }else{
                html+='<div class="alert alert-warning alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>WARNIG:</strong> Error in saving Data</div>';
            }
            $('#save_result').html(html);
         
        });
        
    },
    get_body_parts: function(){
        $.post('painreport/get_body_parts',
        function( data ) {
         var retdata = $.parseJSON(data)
        
          $.each(retdata, function( i, val ) {
              // html += '<option value="'+val.id+'">'+val.name+'</option>';
              $('#body_part').append($('<option>', {
                  value: val.id,
                  text: val.name
              })); 
          });
        });
    },
    get_pain_details: function(freq){
        var body_part = $('#body_part').val();
        $('#pain_details').empty();
          var loc = $('#pain_location').val();

           $.post('painreport/get_pain_details',{freq:freq,loc:loc,body_part:body_part},
            function( data ) {
             var retdata = $.parseJSON(data);
             
              $.each(retdata, function( i, val ) {
                  // html += '<option value="'+val.id+'">'+val.name+'</option>';
                  // $('#pain_kind').append($('<option>', {
                  //     value: val.pain_kind,
                  //     text: val.pain_kind
                  // })); 
                  $('#pain_details').append($('<option>', {
                      value: val.id,
                      text: val.pain_details
                  })); 
              });
            });
        // $('#pain_kind').empty();
        
       
    },
    get_null_pain_details: function(freq){
        var body_part = $('#body_part').val();
        $('#pain_details').empty();  
            var loc = 'null';
           $.post('painreport/get_pain_details',{freq:freq,loc:loc,body_part:body_part},
            function( data ) {
             var retdata = $.parseJSON(data);
             
              $.each(retdata, function( i, val ) {
              console.log(val.id);                  // html += '<option value="'+val.id+'">'+val.name+'</option>';
                  // $('#pain_kind').append($('<option>', {
                  //     value: val.pain_kind,
                  //     text: val.pain_kind
                  // })); 
                  $('#pain_details').append($('<option>', {
                      value: val.id,
                      text: val.pain_details
                  })); 
              });
            });
        // $('#pain_kind').empty();
        
       
    }
    ,
    save_patient_pain_report: function(patient_id){
        var pain_details_id = $('#pain_details').val();
        var pain_scale = $('#pain_scale').val();
        

        $.post('painreport/save_patient_pain_report',{pain_details_id:pain_details_id,pain_scale:pain_scale,patient_id:patient_id},
        function( data ) {
            // var retdata = $.parseJSON(data)
            if(data){
                $.get_patient_pain_report(patient_id);
                
            }else{
                alert('Error in Saving');
            }
         
        });

    },
    get_patient_pain_report: function(){
        var pain_details_id = $('#pain_details').val();
        var pat_id = localStorage.getItem('mydata');

        
        $.post('painreport/get_patient_pain_report',{pain_details_id:pain_details_id,patient_id:pat_id},
        function( data ) {
        var retdata = $.parseJSON(data)
        
        var html = '';
          $.each(retdata, function( i, val ) {
                html += '<div class="card" style="width: 100%;margin-bottom:10px"><div class="card-body"><h5 class="card-title">'+val.body_part_name+'</h5><h6 class="card-subtitle mb-2 text-muted">'+val.pain_kind+'</h6>';
                html+= '<p class="card-text">The level of the patient`s pain is rated as '+val.pain_scale+'/10 on the visual analog scale where 0 is ';
                html+='rated as no pain and 10 is equal to the worst imaginable pain. '+val.report+'</p><a href="#" id = "'+val.id+'" onclick ="$.remove_pain('+val.id+');" class="card-link remove_btn float-right">Remove</a></div></div>';
              
          });
          $('#result_pain').html(html);
        });
    },
    get_frequency: function(body_part){
        $('#frequency').empty();
        $.post('painreport/get_frequency',{body_part:body_part},
        function( data ) {
         var retdata = $.parseJSON(data)
            // console.log(retdata);
          $.each(retdata, function( i, val ) {
              // html += '<option value="'+val.id+'">'+val.name+'</option>';
              $('#frequency').append($('<option>', {
                  value: val.freq,
                  text: val.text
              })); 
          });
        });
    },
    get_pain_loc: function(freq){
         $('#pain_location').empty();
         var body_part = $('#body_part').val();
         // var freq = $('#frequency').val();

        $.post('painreport/get_pain_loc',{body_part:body_part,freq:freq},
        function( data ) {
         var retdata = $.parseJSON(data)
            // console.log(retdata);
          $.each(retdata, function( i, val ) {
              // html += '<option value="'+val.id+'">'+val.name+'</option>';
                var new_txt = val.pain_location
                var txt = new_txt.charAt(0).toUpperCase() + new_txt.slice(1)
              $('#pain_location').append($('<option>', {
                  value: val.pain_location,
                  text: txt
              })); 
          });
        });
    },
    enable_inputs: function(){
        $('#pain_location').removeAttr('disabled','disabled');
        $('#pain_details').removeAttr('disabled','disabled');
    },
    remove_pain: function(id){
        if(confirm('Are you sure?')){
             $.post('painreport/remove_pain',{id:id},
            function( data ) {
             // var retdata = $.parseJSON(data)
            $.get_patient_pain_report();
             
            });
        } 
    },
    export_word: function(patient_id){
       
        
        var url = 'painreport/create_word_file';
        var param = "patient_id=" + patient_id;
              
      
         $.post('painreport/create_word_file',{patient_id:patient_id},
            function( data ) {
             // var retdata = $.parseJSON(data)
             // console.log(data);

             
            });
         $.download(url,param);
    },
    download: function(url, data, method){

    //url and data options required
    if( url && data ){
        //data can be string of parameters or array/object
        data = typeof data == 'string' ? data : $.param(data);
        //split params into form inputs
        var inputs = '';
        $.each(data.split('&'), function(){
            var pair = this.split('=');
            inputs+='<input type="hidden" name="'+ pair[0] +'" value="'+ pair[1] +'" />';
        });
        //send request
        $('<form action="'+ url +'" method="'+ (method||'post') +'">'+inputs+'</form>')
        .appendTo('body').submit().remove();
    };

    },
    get_patient_id: function(){ //get patient info for display
         $.post('painreport/get_patient_id_last_insert',
            function( data ) {
             var retdata = $.parseJSON(data)
             // console.log(retdata[0].patient_id);
              var html = '';
                   $.each(retdata, function( i, val ) {
                    html+='<h4>Patient name: '+retdata[0].patname+'</h4>';
                  localStorage.setItem('mydata',retdata[0].patient_id);
                  });
              $('#patient_info').html(html);
                
       
            
            });
    },
    insert_patient_info:function(){
        $.post('painreport/insert_patient_info',
            function( data ) {
             
        // $.get_patient_id();
      });
    } 

  })
</script>
<script>
  $( document ).ready(function() {
    $.get_patient_id(); //getting the info of patient
    var patient_id = localStorage.getItem('mydata');
    
    $.get_body_parts();
  
   $.enable_inputs();  // enable input when bopdy_part changed

    $('#body_part').on('change', function(){
        $.enable_inputs();
        var body_part = $(this).val();
        $.get_frequency(body_part);
    })
    $('#frequency').on('mouseup',function(){
        var freq = $(this).val();
       if(freq == 'constant_wo' || freq == 'intermittent_wo'){
          $.get_pain_loc(freq);
          $.get_null_pain_details(freq);
       }else{

           $.get_pain_loc(freq);
          $.get_pain_details(freq);

       }

       //  $('#pain_location').attr('disabled','disabled');
       //  $('#pain_details').attr('disabled','disabled');
       // }else{
       //  $('#pain_location').removeAttr('disabled','disabled');
       //  $('#pain_details').removeAttr('disabled','disabled');
       // }
       
        

    })
    $('#pain_location').on('click',function(){
        var freq = $('#frequency').val();
        $.get_pain_details(freq);
    })
    $('#save_pain_details').on('click',function(){

        var pain_scale = $('#pain_scale').val();
        if(pain_scale == null || pain_scale == 'null' ){
            alert('pain Scale is empty');
        }else{
           $.save_patient_pain_report(patient_id); 
        }
    })

    // save the first section
    $('#save_accident_report_btn').on('click',function(){
        $.save_patient_accident_report(patient_id);
    })
    $('#export_word').on('click',function(){
        $.export_word(patient_id);
        // alert();
    })
 




    $('#q1').on('change',function(){
        var selected = $(this).children("option:selected").val();
        if(selected == 'Pedestrian'){
            $('#q2').attr('disabled','disabled');
        }else{
            $('#q2').removeAttr('disabled');
        }
    });


// inserting pain_details
    $('#save_pain').on('click', function(){
       var  body_part = $('#body_part').val();
       var frequency = $('#frequency').val();
       var  pain_location = $('#pain_location').val();
       var  pain_kind= $('#pain_kind').val();
       var pain_details = $('#pain_details').val();
       var report = $('#report').val();

       $.post('painreport/insert_pain',{'body_part':body_part, 'frequency':frequency, 'pain_location':pain_location,'pain_kind':pain_kind,'pain_details':pain_details,'report':report},
            
            function( data ) {
             if(data == '1'){
              alert('success');
             }else{
              alert('failed');
             }
        });
       
    })   
            
});
</script>





 
