<?php


class Painreport extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/home/index.php';
        require APP . 'view/_templates/footer.php';
    }

    
    public function insert_patient_info(){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
        $r = $_REQUEST;
        // print_r($r);die();
        $id = $this->pain->insert_patient_info($r);
        echo json_encode($id);
    }

    public function get_patient_id_last_insert(){
        
        $data = $this->pain->get_patient_id_last_insert();
       
        echo json_encode($data);

    }
    
    public function insert_pain(){
        $r = $_REQUEST;
        $ret_data =$this->pain->insert_pain($r);
        echo json_encode($ret_data);
        
    }
    public function get_body_parts(){
        $data = $this->pain->get_body_parts();
        echo json_encode($data);
    }

   
    public function get_pain_details(){
        $r = $_REQUEST;

        $data = $this->pain->get_pain_details($r);

        echo json_encode($data);
    }
    public function save_patient_pain_report(){
        $r = $_REQUEST;

        $data = $this->pain->save_patient_pain_report($r);
        echo json_encode($data);
    }
    public function get_patient_pain_report(){
        $r = $_REQUEST;

        $data = $this->pain->get_patient_pain_report($r);
        echo json_encode($data);
    }
    public function get_frequency(){
        $r = $_REQUEST;
        $data = $this->pain->get_frequency($r);
        $ret_data = array();
        foreach ($data as $key => $value) {
            $text = ($value['frequency'] == "constant") ? 'Constant' : $value['frequency'] ;
            $text = ($value['frequency'] == "intermittent") ? 'Intermittent' : $text;
            $text = ($value['frequency'] == "constant_wo") ? 'Constant without radiating symptoms' : $text;
            $text = ($value['frequency'] == "intermittent_wo") ? 'Intermittent without radiating symptoms' : $text;
            $ret_data[] = array(
                'freq' => $value['frequency'],
                'text' => $text
            );
        }
        
        echo json_encode($ret_data);
    }
    public function get_pain_loc(){
        $r = $_REQUEST;
        $data = $this->pain->get_pain_loc($r);
        echo json_encode($data);
    }
    public function remove_pain(){
        $r = $_REQUEST;
        $data = $this->pain->remove_pain($r);
        echo json_encode($data);
    }
    public function save_patient_accident_report(){
        $r = $_REQUEST;
        $data = $this->pain->save_patient_accident_report($r);
        echo json_encode($data);
    }
    
    public function create_word_file(){
        $r = $_REQUEST;
        $data = $this->pain->get_patient_accident_report($r);
        $accident_type = $data[0]['accident_type'];
        $patient_vehicle_loc = $data[0]['patient_vehicle_loc'];
        $impact_loc = $data[0]['impact_loc'];
        $airbag_deployed = $data[0]['airbag_deployed'];
        $lose_conscious = $data[0]['lose_conscious'];
        $ambulatory_srvcs =$data[0]['received_ambulatory_srvcs'];
        $police_report = $data[0]['police_report'];

        $pat_info = $this->pain->get_patient_id_last_insert();

        // require_once('//libs/phpword/PHPWord.php');


        /* Note: any element you append to a document must reside inside of a Section. */
        $PHPWord = new PHPWord();

        
        $section = $PHPWord->createSection();
        // Add header
        $PHPWord->addParagraphStyle('paragraph_style', array('align'=> 'center','spaceBefore' => 0, 'spaceAfter' => 0, 'spacing' => 0));
        $PHPWord->addParagraphStyle('nospacing', array('spaceBefore' => 0, 'spaceAfter' => 0, 'spacing' => 0));

        
        $headername = array('name'=>'Garamond', 'size'=>20,'bold'=>true,'italic'=>true);
        $headerdesc = array('name'=>'Garamond', 'size'=>12,'bold'=>true);
        $headertel = array('name'=>'Garamond', 'size'=>16,'bold'=>true);
        $header = $section->createHeader();
        $table = $header->addTable();
        $table->addRow();
        $table->addCell(9000)->addText('Sanjiv Kumar Jain, M.D.',$headername,'paragraph_style');
        $table->addRow(20);
        $table->addCell(9000)->addText('Diplomate, American Board of Anesthesia',$headerdesc,'paragraph_style');
        $table->addRow(20);
        $table->addCell(9000)->addText('Diplomate, American Board of Anesthesia-Pain Management',$headerdesc,'paragraph_style');
                $table->addRow();
        $table->addCell(9000)->addText('Diplomate, American Board of Pain Medicine',$headerdesc,'paragraph_style');
                $table->addRow();
        $table->addCell(9000)->addText('Diplomate, American Board of Hospice and Palliative Medicine',$headerdesc,'paragraph_style');
                $table->addRow();
        $table->addCell(9000)->addText('Specializing in Anesthesia, Pain Management, and Internal Medicine',$headerdesc,'paragraph_style');
                $table->addRow();
        $table->addCell(9000)->addText('12 Centerpointe Drive, Suite 104, La Palma, CA 90623',$headertel,'paragraph_style');
                $table->addRow();
        $table->addCell(9000)->addText('Tel: 213-984-2889 Fax: 213-271-1513',$headertel,'paragraph_style');
        $table->addRow(50);
        $table->addCell(9000)->addText('___________________________________________________________________________',$headerdesc,'paragraph_style');

        $section->addTextBreak(1);
        $text_desc =  array('name'=>'Times New Roman', 'size'=>14,'bold'=>false,'align'=>'left');
        $text_desc_12 =  array('name'=>'Times New Roman', 'size'=>12,'bold'=>false,'align'=>'left');
        $text_desc_12_both =  array('name'=>'Times New Roman', 'size'=>12,'bold'=>false,'align'=>'both');
        $text_bold_left = array('name'=>'Times New Roman', 'size'=>14,'bold'=>true,'align'=>'left');
        $text_bold_center_underline = array('name'=>'Times New Roman', 'size'=>14,'bold'=>true,'align'=>'both','underline'=> 'single');
        $section->addText('NSJ Law Group',$text_desc,'nospacing');
        $section->addText('433 N. Camden Drive., Suite 600',$text_desc,'nospacing');
        $section->addText('Beverly Hills, CA 90210',$text_desc,'nospacing');
        $section->addTextBreak(1);

        $table = $section->addTable();
        $table->addRow();
        $table->addCell(3000)->addText('Patient`s Name:     ',$text_bold_left,'nospacing');
        $table->addCell(5000)->addText(strtoupper($pat_info[0]['patname']) ,$text_bold_left,'nospacing');
        $table->addRow();
        $table->addCell(3000)->addText('Date of Birth:      ',$text_bold_left,'nospacing');
        $table->addCell(5000)->addText($pat_info[0]['dob'],$text_desc,'nospacing');
        $table->addRow();
        $table->addCell(3000)->addText('Date of Injury: ',$text_bold_left,'nospacing');
        $table->addCell(5000)->addText($pat_info[0]['doi'],$text_desc,'nospacing');
        $table->addRow();
        $table->addCell(3000)->addText('Date of Service:    ',$text_bold_left,'nospacing');
        $table->addCell(5000)->addText(date("Y-m-d"),$text_desc,'nospacing');
    

        $section->addTextBreak(1);

        $title = 'INITIAL PAIN MANAGEMENT CONSULTATION REPORT';
        $section->addText($title,$text_bold_center_underline,'paragraph_style');
        $section->addTextBreak(1);
    
        $address = 'To Whom It May Concern:';
        $section->addText($address,$text_desc_12,'');


        $message = 'This patient has been seen for an Interventional Pain Management Consultation for an evaluation of the pain arising from this patient`s personal injury. The following report has been obtained by an evaluation of available medical records by careful patient questioning and by a brief pertinent physical examination. The purpose of this evaluation is to determine the appropriateness of the need for Interventional Pain Management Therapy in this patient. This is not an Orthopedic report.';
        $paragraphStyleme = array('spaceBefore' => 0, 'spaceAfter' => 0, 'spacing' => 0,'align'=>'both');
        $section->addText($message,$text_desc_12_both,$paragraphStyleme);
        $section->addTextBreak(1);
        

        $history = 'History of Present Illness:';
        $section->addText($history,$text_bold_left,'nospacing');
        $section->addTextBreak(1);
        
        $doi_month = date('F', strtotime($pat_info[0]['doi']));
        $doi_date = date('d', strtotime($pat_info[0]['doi']));
        $doi_year = date('Y', strtotime($pat_info[0]['doi']));
        
        $non_pedes = 'The patient sustained personal injuries secondary to a '.$accident_type.' that occurred on '.$doi_month.' '.$doi_date.', '.$doi_year.'.';
        $pedes = 'The patient was a '.$accident_type.' who was involved in MVA occurred on '.$doi_month.' '.$doi_date.', '.$doi_year.'.';
        $accident = ($accident_type == 'Pedestrian') ? $pedes : $non_pedes;
        $section->addText($accident,$text_desc_12_both,'nospacing');
        $section->addText('',$text_desc_12_both,$paragraphStyleme);

        $patient_loc = 'He/She was the seat belted '.$patient_vehicle_loc.' passenger of a vehicle that had a '.$impact_loc.' side impact.';
        $section->addText($patient_loc,$text_desc_12_both,'nospacing');
        $section->addText('',$text_desc_12_both,$paragraphStyleme);

        ##airbag deployed?
        $airbag = ($airbag_deployed == 'yes') ? 'Airbag deployed.' : 'Airbag did not deploy.' ;
        $section->addText($airbag,$text_desc_12_both,'nospacing');
        $section->addText('',$text_desc_12_both,$paragraphStyleme);

        ##lose_consciousness?
        $conscious = ($lose_conscious == 'yes') ? 'with' : 'without' ;
        $conscious_text = 'Upon impact, He/she was severely jolted and sustained whiplash injury to (his/her) body '.$conscious.' loss of consciousness and head trauma.';
        $section->addText($conscious_text,$text_desc_12_both,'nospacing');
        $section->addText('',$text_desc_12_both,$paragraphStyleme);

        ##received ambulatory services?
        $ambulatory = ($ambulatory_srvcs == 'yes') ? 'had' : 'denies' ;
        $ambulatory_text = 'He/She '.$ambulatory.' ambulatory services at the scene of accident and he/she was not transferred to hospital.';
        $section->addText($ambulatory_text,$text_desc_12_both,'nospacing');
        $section->addText('',$text_desc_12_both,$paragraphStyleme);

        ##filed police report?
        $police = ($police_report == 'yes') ? 'Police report was made.' : 'Police report was not made.' ;
        $section->addText($police,$text_desc_12_both,'nospacing');
        $section->addText('',$text_desc_12_both,$paragraphStyleme);

        ##more pains

        $section2 = $PHPWord->createSection();

        // $d = $this->pain->get_patient_pain_report($r);
    
    
        // Add header
        $PHPWord->addParagraphStyle('paragraph_style', array('align'=> 'center','spaceBefore' => 0, 'spaceAfter' => 0, 'spacing' => 0));
        $PHPWord->addParagraphStyle('nospacing', array('spaceBefore' => 0, 'spaceAfter' => 0, 'spacing' => 0));

        $txt_b_c_12 = array('name'=>'Times New Roman', 'size'=>12,'bold'=>true,'align'=>'both');
        
        $header2 = $section2->createHeader();
        $table2 = $header2->addTable();
        $table2->addRow();
        $table2->addCell(9000)->addText(''.strtoupper($pat_info[0]['patname']).'    '.date("m/d/Y").'   Pain Management Consult',$txt_b_c_12,'paragraph_style');
        $section2->addTextBreak(1);

        

        $intro_to_pain = 'As a result of injuries, he/she now complains of the Following:' ;
        $section2->addText($intro_to_pain,$text_desc_12_both,$paragraphStyleme);
        $section2->addTextBreak(1);

        
        $section2->addText('Present Complaints:',$text_bold_left,'nospacing');
        $section2->addTextBreak(1);

        $d = $this->pain->get_patient_pain_report($r);
        
        
        $key = 1;
        foreach ($d as $pain => $value) {
            $new_key = $key++;
            $patient_id     = $value['patient_id']; 
            $body_part_name = $value['body_part_name'];
            $pain_scale     = $value['pain_scale'];
            $pain_kind      = $value['pain_kind'];
            $report         =  str_replace("  "," ",$value['report']);
            $pain_details   = ($value['pain_details'] == 'null') ? '': ' to '.$value['pain_details']; 


            $frequency = '';
            if($value['frequency'] == 'constant_wo'){
                $frequency = 'Constant without';
            }else{ 
                if($value['frequency'] == 'intermittent_wo'){
                    $frequency = 'Intermittent without';
                }else{ 
                    $frequency = ucwords($value['frequency']).' with';
                }
            }
    
            $section2->addText(''.$new_key.'. '.$frequency.' radiating symptoms'.$pain_details.'.',$text_desc_12_both,'nospacing');
            
            $section2->addText(' '.$pain_kind.': The level of the patient`s pain is rated as '.$pain_scale.'/10 on the visual analog scale where 0 is rated as no pain and 10 is equal to the worst imaginable pain. '.$report.'',$text_desc_12_both,'nospacing');
            $section2->addTextBreak(1);
        }
        $section2->addTextBreak(1);
        $text_desc_10 =  array('name'=>'Times New Roman', 'size'=>10,'bold'=>false,'align'=>'left');
        $txt_12 = array('name'=>'Times New Roman', 'size'=>12,'bold'=>false,'align'=>'left');
        $section2->addText('Respectfully,',$text_desc_10,'nospacing');
        $section2->addImage('img/e-signature.png', array('width'=> 140, 'height'=> 90));
        $section2->addText('Sanjiv Kumar Jain, M.D.',$txt_b_c_12,'nospacing');
        $section2->addText('Pain Management Specialist, Anesthesiologist, Internal Medicine Specialist',$txt_12,'nospacing');
        $section2->addText('CA License No. A047841',$txt_12,'nospacing');
        $section2->addText('',$text_desc_12_both,$paragraphStyleme);
        $a = date("Y-m-d");
        $section2->addText('Dated this '.date('jS', strtotime($a)).' day of '.date('F', strtotime($a)).', '.date('Y', strtotime($a)).' at Los Angeles County, California',$text_desc_10,'nospacing');
        $section2->addText('',$text_desc_12_both,$paragraphStyleme);
        $section2->addText('SKJ/GKC/SRB',$txt_12,'nospacing');


    $name =strtoupper($pat_info[0]['patname']);
     $filename = $name.'.docx';
     //save our document as this file name
     header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
     //mime type
     header('Content-Disposition: attachment;filename="' . $filename . '"');
     //tell browser what's the file name
     header('Cache-Control: max-age=0');
     //no cache
     $objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
     $objWriter->save('php://output');
    }

}
