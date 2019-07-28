<?php

class Pain
{
      function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function insert_pain($r){
      
        $pain_details = ucwords($r['pain_details']);
        $query = "INSERT INTO pain_details (body_parts_name,pain_kind,frequency,pain_location,pain_details,report,date_created) VALUES (?,?,?,?,?,?,NOW())";
        $stmt =$this->db->prepare($query);
        $stmt->bind_param('isssss',$r['body_part'],$r['pain_kind'],$r['frequency'],$r['pain_location'],$pain_details,$r['report']);
        $stmt->execute();
        $ret_data = $stmt->affected_rows;
        $stmt->close();
        $this->db->close();
        return $ret_data;
    }
    public function get_body_parts(){
        // 
        $query = "SELECT id,name FROM body_parts";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $stmt->bind_result($id,$name);
        $data = array();
        while ($stmt->fetch()) {
            $data[] = array(   
                'id'      =>$id,
                'name'  =>ucwords($name)
             );
        }
        $stmt->close();
        return $data;
    }
    public function get_pain_details($r){
       
        
        $query = "SELECT id,pain_kind,pain_details FROM pain_details WHERE body_parts_name =? and pain_location =? and frequency = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iss', $r['body_part'],$r['loc'],$r['freq']);
        $stmt->execute();
        $stmt->bind_result($id,$pain_kind,$pain_details);
        $data = array();
        while ($stmt->fetch()) {
            $data[] = array(
                'id'        => $id,   
                'pain_kind'  =>$pain_kind,
                'pain_details' => $pain_details
             );
        }
        $stmt->close();
        
        return $data;      
    }


    public function save_patient_pain_report($r){
        $query = "INSERT INTO patient_pain_report (patient_id,pain_scale,pain_details_id,date_created) VALUES (?,?,?,NOW())";
        $stmt =$this->db->prepare($query);
        $stmt->bind_param('iii',$r['patient_id'],$r['pain_scale'],$r['pain_details_id']);

        $stmt->execute();
        $ret_data = $stmt->affected_rows;
        $stmt->close();
        $this->db->close();
        return $ret_data;

    }
    public function get_patient_pain_report($r){
        
        
        $query = "SELECT qry1.id,qry1.patient_id,qry1.pain_scale,qry1.report,qry1.pain_kind,qry1.frequency,qry1.pain_details,bp.`name`,qry1.date_created FROM (
                    SELECT a.id,patient_id,pain_scale,pain_details_id,b.report,b.body_parts_name,b.frequency,b.pain_kind,b.pain_details,a.date_created FROM patient_pain_report  as a
                    INNER JOIN pain_details as b on a.pain_details_id = b.id
                    WHERE  a.patient_id = ? ) as qry1
                    INNER JOIN body_parts as bp on qry1.body_parts_name = bp.id WHERE date(qry1.date_created) = CURDATE() ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i',$r['patient_id']);
        $stmt->execute();
        $stmt->bind_result($id,$patient_id,$pain_scale,$report,$pain_kind,$frequency,$pain_details,$body_part_name,$date_created);
        $data = array();
        while ($stmt->fetch()) {
            $data[] = array(
                'id'    => $id,
                'patient_id'        => $patient_id,   
                'body_part_name'  =>strtoupper($body_part_name),
                'pain_scale' => $pain_scale,
                'pain_kind' => $pain_kind,
                'pain_details' => $pain_details,
                'frequency' => $frequency,
                'report' => $report,
                'date_created' => $date_created
             );
        }
        $stmt->close();
        
        return $data;
    }
    public function get_frequency($r){

        
        $query = "SELECT DISTINCT frequency from pain_details WHERE body_parts_name = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i',$r['body_part']);
        $stmt->execute();
        $stmt->bind_result($frequency);
        $data = array();
        while ($stmt->fetch()) {
            $data[] = array(   
                'frequency' =>$frequency
             );
        }
        $stmt->close();
        return $data;
    }
    public function get_pain_loc($r){
       
        
        $query = "SELECT DISTINCT pain_location from pain_details WHERE body_parts_name = ? and frequency =?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('is',$r['body_part'],$r['freq']);
        $stmt->execute();
        $stmt->bind_result($pain_location);
        $data = array();
        while ($stmt->fetch()) {
            $data[] = array(   
                'pain_location' =>$pain_location
             );
        }
        $stmt->close();
        return $data;
    }
    public function remove_pain($r){
        
        $query = "DELETE FROM patient_pain_report WHERE id =?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i',$r['id']);
        $stmt->execute();
        $ret_data = $stmt->affected_rows;
        $stmt->close();
        $this->db->close();
        return $ret_data;

    }
    public function save_patient_accident_report($r){
        
        
        $query = "INSERT INTO patient_accident_report 
            (patient_id,accident_type,patient_vehicle_loc,impact_loc,airbag_deployed,lose_conscious,received_ambulatory_srvcs,police_report,date_created) 
            VALUES (?,?,?,?,?,?,?,?,NOW())";
        $stmt =$this->db->prepare($query);
        $stmt->bind_param('isssssss',$r['patient_id'],$r['accident_type'],$r['patient_vehicle_loc'],$r['impact_loc'],$r['airbag_deployed'],$r['lose_conscious'],$r['receive_ambulatory_srvcs'],$r['police_report_filed']);
        $stmt->execute();
        $ret_data = $stmt->affected_rows;
        $stmt->close();
        $this->db->close();
        return $ret_data;
    }
    public function get_patient_accident_report($data){

        
        $query = "SELECT patient_id,accident_type,patient_vehicle_loc,impact_loc,airbag_deployed,lose_conscious,received_ambulatory_srvcs,police_report from patient_accident_report WHERE patient_id =?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i',$data['patient_id']);
        $stmt->execute();
        $stmt->bind_result($a,$b,$c,$d,$e,$f,$g,$h);
        $data = array();
        while ($stmt->fetch()) {
            $data[] = array(   
                'patient_id'                =>$a ,
                'accident_type'             =>$b ,
                'patient_vehicle_loc'       =>$c ,
                'impact_loc'                =>$d ,
                'airbag_deployed'           =>$e ,
                'lose_conscious'            =>$f ,
                'received_ambulatory_srvcs' =>$g ,
                'police_report'             =>$h
             );
        }
        $stmt->close();
        return $data;
    }
    public function insert_patient_info($r){
        $doi = $r['doi'];
        $dob = $r['dob'];
        $new_doi = date("Y-m-d", strtotime($doi));
        $new_dob = date("Y-m-d", strtotime($dob));
        
        $query = "INSERT INTO patient_info 
            (patient_id,patname,doctor,referrer,doi,dob,date_created) 
            VALUES (?,?,?,?,?,?,NOW()) ON DUPLICATE KEY UPDATE date_created = NOW()";
        $stmt =$this->db->prepare($query);
        $stmt->bind_param('isssss',$r['patid'],$r['patname'],$r['doctor'],$r['referrer'],$new_doi,$new_dob);
        $stmt->execute();
        $last_insert_id = $stmt->insert_id;
        $stmt->close();
        $this->db->close();
        return $last_insert_id;

    }
    public function get_patient_id_last_insert(){
        
        $query = "SELECT patient_id,patname,doctor,referrer,doi,dob,date_created from patient_info ORDER BY date_created DESC LIMIT 1";
      
        $stmt = $this->db->prepare($query);
        // $stmt->bind_param('i',$r['body_part']);
        $stmt->execute();
        $stmt->bind_result($patient_id,$patname,$doctor,$referrer,$doi,$dob,$date_created);
        $data = array();
        while ($stmt->fetch()) {
            $data[] = array(   
                'patient_id'    => $patient_id
                ,'patname'      => $patname
                ,'doctor'       => $doctor
                ,'referrer'     => $referrer
                ,'doi'          => $doi
                ,'dob'          => $dob
                ,'date_created' => $date_created
             );
        }
        $stmt->close();
        return $data;

    }

     public function get_all_pain_details(){
       
        
        $query = "SELECT pain_details.id,body_parts.`name`,pain_kind,frequency,pain_location,pain_details,report,date_created FROM pain_details left join body_parts  on pain_details.body_parts_name = body_parts.id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $stmt->bind_result($id,$body_parts_name,$pain_kind,$frequency,$pain_location,$pain_details,$report,$date_created);
        $data = array();
        while ($stmt->fetch()) {
            $data[] = array(
                'id'                => $id
                ,'body_parts_name'  =>$body_parts_name 
                ,'pain_kind'        =>$pain_kind
                ,'frequency'        =>$frequency
                ,'pain_location'    =>$pain_location
                ,'pain_details'     => $pain_details
                ,'report'           =>$report
                ,'date_created'     =>$date_created

             );
        }
        $stmt->close();
        
        return $data;      
    }
    public function get_specific_pain_details($r){
          $query = "SELECT pain_details.id,body_parts.`name`,pain_kind,frequency,pain_location,pain_details,report,date_created FROM pain_details left join body_parts  on pain_details.body_parts_name = body_parts.id WHERE pain_details.id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i',$r['id']);
        $stmt->execute();
        $stmt->bind_result($id,$body_parts_name,$pain_kind,$frequency,$pain_location,$pain_details,$report,$date_created);
        $data = array();
        while ($stmt->fetch()) {
            $data[] = array(
                'id'                => $id
                ,'body_parts_name'  =>$body_parts_name 
                ,'pain_kind'        =>$pain_kind
                ,'frequency'        =>$frequency
                ,'pain_location'    =>$pain_location
                ,'pain_details'     => $pain_details
                ,'report'           =>$report
                ,'date_created'     =>$date_created

             );
        }
        $stmt->close();
        
        return $data;


    }
    public function update_pain_details($r){
        
        $query = "UPDATE pain_details SET body_parts_name =?
                    ,pain_kind = ?
                    ,frequency = ?
                    ,pain_location = ?
                    ,pain_details = ?
                    ,report = ?
                    ,date_created = NOW() where id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssssssi',$r['body_parts'],$r['pain_kind'],$r['frequency'],$r['pain_location'],$r['pain_details'],$r['report'],$r['id']);
        $stmt->execute();
        $ret_data = $stmt->affected_rows;
        $stmt->close();
        $this->db->close();
        return $ret_data;
    }
	public function delete_pain_details($id){


        $query = "DELETE FROM pain_details WHERE id =?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $ret_data = $stmt->affected_rows;
        $stmt->close();
        $this->db->close();
        return $ret_data;

    }
	

}