<?php


class Manage extends Controller
{

    public function index()
    {
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/home/manage.php';
        require APP . 'view/_templates/footer.php';
    }

    public function get_all_pain_details(){
        $data = $this->pain->get_all_pain_details();
        $new_data =  array();
        foreach ($data as $key => $value) {
           
           $report = str_replace('. ',"." , trim(preg_replace('/\s+/', ' ', $value['report'])));

         
           $new_data[] = array(

                'id'                => $value['id']
                ,'body_parts_name'  =>$value['body_parts_name'] 
                ,'pain_kind'        =>$value['pain_kind']
                ,'frequency'        =>$value['frequency']
                ,'pain_location'    =>$value['pain_location']
                ,'pain_details'     => $value['pain_details']
                ,'report'           =>$report
                ,'date_created'     =>$value['date_created']

           );

        }
          // $results = [ 
          //               "sEcho"                 => 1,
          //               "iTotalRecords"         => count($new_data),
          //               "iTotalDisplayRecords"  => count($new_data),
          //               "aaData"                => $new_data
          //       ];
               

      echo json_encode($new_data);
       
    }
    public function get_specific_pain_details(){

        $r = $_REQUEST;
        $data = $this->pain->get_specific_pain_details($r);
        echo json_encode($data);
    }
    public function update_pain_details(){
        $r = $_REQUEST;
        
       
         if($r['body_parts']  == '' || $r['frequency'] == '' || $r['pain_location'] == '' || $r['pain_details'] == '' || $r['report'] == '' || $r['pain_kind'] == ''){
                $data = 0;
         }else{
                $r['report'] = str_replace('. ',". " , trim(preg_replace('/\s+/', ' ', $r['report'])));
                $data = $this->pain->update_pain_details($r);
         }     
        echo json_encode($data);
    }
    public function get_body_parts(){
        $data = $this->pain->get_body_parts();
        echo json_encode($data);
    }
    public function insert_pain(){
        $r = $_REQUEST;
        if($r['body_part']  == '' || $r['frequency'] == '' || $r['pain_location'] == '' || $r['pain_details'] == '' || $r['report'] == '' || $r['pain_kind'] == ''){
                $data = 0;
         }else{
                $r['report'] = str_replace('. ',". " , trim(preg_replace('/\s+/', ' ', $r['report'])));
                 $data = $this->pain->insert_pain($r);
         }     
        echo json_encode($data);
        
    }
    public function delete_pain_details(){
        
        $id = $_REQUEST['id'];
        $data = $this->pain->delete_pain_details($id);
        echo json_encode($data);


    }

}