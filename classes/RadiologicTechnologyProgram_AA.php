<?php

require_once('DB.php');
require_once('Transaction.php');

class RadiologicTechnologyProgram_AA
{
    protected $first_name;
    protected $last_name;
    protected $sid;
    protected $email;
    protected $phone;

//    protected $eng_comp_course;
//    protected $eng_comp_term_completed;
//    protected $eng_comp_grade_earned;
//    protected $eng_comp_school_attended;
//
//    protected $int_alg_course;
//    protected $int_alg_term_completed;
//    protected $int_alg_grade_earned;
//    protected $int_alg_school_attended;
//    
//    protected $ha_phyI_course;
//    protected $ha_phyI_term_completed;
//    protected $ha_phyI_grade_earned;
//    protected $ha_phyI_school_attended;
//
//    protected $ha_phyII_course;
//    protected $ha_phyII_term_completed;
//    protected $ha_phyII_grade_earned;
//    protected $ha_phyII_school_attended;
//    
//    protected $cultural_div_course;
//    protected $cultural_div_term_completed;
//    protected $cultural_div_grade_earned;
//    protected $cultural_div_school_attended;
//    
    protected $did_attend_orientation_session;
    protected $date_attended;
    
    protected $is_reapplicant;
    protected $year_last_applied;
    
    protected $pceI_clinic_hospital_name;
    protected $pceI_type_of_work_performed;
    protected $pceI_no_of_hours;
    protected $pceI_start_and_end_date;
    protected $pceII_clinic_hospital_name;
    protected $pceII_type_of_work_performed;
    protected $pceII_no_of_hours;
    protected $pceII_start_and_end_date;

    protected $personal_stmt;
    
    protected $college_transcript_1;
    protected $college_transcript_2;
    protected $college_transcript_3;
    protected $college_transcript_4;
    
    protected $patient_care_radiology_exp;
    protected $prerequisite;
    protected $signature;
    protected $transaction;
    protected $form_id;
    
    //public constructor
    public function __construct() {

    }

    //save data model
    public function save() {
        $db = new DB();
        $conn = $db->getDB();

        if ( $conn ) {
            try {
                $result = $this->transaction->save();   //save transaction first because of db constraint on trans id
                $tsql = 'EXEC [usp_InsertIntoAARadiologicTechForm]'
                            . '@SID = :SID,'
                            . '@Fname = :FirstName,'
                            . '@Lname = :LastName,'
                            . '@Phone = :Phone,'
                            . '@Email = :Email,'
                        
//                            . '@EngCompCourse = :EngCompCourse,'
//                            . '@EngCompTermCompleted = :EngCompTermCompleted,'
//                            . '@EngCompGradeEarned = :EngCompGradeEarned,'
//                            . '@EngCompSchoolAttended = :EngCompSchoolAttended,'
//                        
//                            . '@IntAlgCourse = :IntAlgCourse,'
//                            . '@IntAlgTermCompleted = :IntAlgTermCompleted,'
//                            . '@IntAlgGradeEarned = :IntAlgGradeEarned,'
//                            . '@IntAlgSchoolAttended = :IntAlgSchoolAttended,'
//                        
//                            . '@HAPhysICourse = :HAPhysICourse,'
//                            . '@HAPhysITermCompleted = :HAPhysITermCompleted,'
//                            . '@HAPhysIGradeEarned = :HAPhysIGradeEarned,'
//                            . '@HAPhysISchoolAttended = :HAPhysISchoolAttended,'
//                        
//                            . '@HAPhysIICourse = :HAPhysIICourse,'
//                            . '@HAPhysIITermCompleted = :HAPhysIITermCompleted,'
//                            . '@HAPhysIIGradeEarned = :HAPhysIIGradeEarned,'
//                            . '@HAPhysIISchoolAttended = :HAPhysIISchoolAttended,'
//                      
//                            . '@CulturalDivCourse = :CulturalDivCourse,'
//                            . '@CulturalDivTermCompleted = :CulturalDivTermCompleted,'
//                            . '@CulturalDivGradeEarned = :CulturalDivGradeEarned,'
//                            . '@CulturalDivSchoolAttended = :CulturalDivSchoolAttended,'
                        
                            . '@DidAttendOrientationSession = :DidAttendOrientationSession,'
                            . '@DateAttended = :DateAttended,'
                        
                            . '@IsReapplicant = :IsReapplicant,'
                            . '@YearLastApplied = :YearLastApplied,'
                        
                            . '@PCEIClinicHospitalName = :PCEIClinicHospitalName,'
                            . '@PCEITypeofworkPerformed = :PCEITypeofworkPerformed,'
                            . '@PCEINoofHours = :PCEINoofHours,'
                            . '@PCEIStartandEndDate = :PCEIStartandEndDate,'
                            . '@PCEIIClinicHospitalName = :PCEIIClinicHospitalName,'
                            . '@PCEIITypeofworkPerformed = :PCEIITypeofworkPerformed,'
                            . '@PCEIINoofHours = :PCEIINoofHours,'
                            . '@PCEIIStartandEndDate = :PCEIIStartandEndDate,'
                        
                            . '@PersonalStatement = :PersonalStatement,'
                        
                            . '@UnofficialTranscript1 = :UnofficialTranscript1,'
                            . '@UnofficialTranscript2 = :UnofficialTranscript2,'
                            . '@UnofficialTranscript3 = :UnofficialTranscript3,'
                            . '@UnofficialTranscript4 = :UnofficialTranscript4,'
                            . '@Prerequisite = :Prerequisite,'
                        
                            . '@PatientcareorRadiologyForm = :PatientcareorRadiologyForm,'                         
                            . '@TransID = :TransID,'
                            . '@FormID = :FormID,'
                            . '@ElectronicSignature = :ElectronicSignature;';
                            //error_log("parameters :".$tsql);
                    $query = $conn->prepare( $tsql );                   
                    $input_data = array( 
                                        'SID' => $this->sid,
                                        'FirstName' => $this->first_name,
                                        'LastName' => $this->last_name, 
                                        'Phone' => $this->phone,
                                        'Email' => $this->email,
                        
//                                        'EngCompCourse' => $this->eng_comp_course,
//                                        'EngCompTermCompleted' => $this->eng_comp_term_completed,
//                                        'EngCompGradeEarned' => $this->eng_comp_grade_earned,
//                                        'EngCompSchoolAttended' => $this->eng_comp_school_attended,
//                        
//                                        'IntAlgCourse'  => $this->int_alg_course,
//                                        'IntAlgTermCompleted' => $this->int_alg_term_completed,
//                                        'IntAlgGradeEarned' => $this->int_alg_grade_earned,
//                                        'IntAlgSchoolAttended' => $this->int_alg_school_attended,
//                                                               
//                                        'HAPhysICourse' => $this->ha_phyI_course,
//                                        'HAPhysITermCompleted' => $this->ha_phyI_term_completed,
//                                        'HAPhysIGradeEarned' => $this->ha_phyI_grade_earned,
//                                        'HAPhysISchoolAttended' => $this->ha_phyI_school_attended,
//                        
//                                        'HAPhysIICourse' => $this->ha_phyII_course,
//                                        'HAPhysIITermCompleted' => $this->ha_phyII_term_completed,
//                                        'HAPhysIIGradeEarned' => $this->ha_phyII_grade_earned,
//                                        'HAPhysIISchoolAttended' => $this->ha_phyII_school_attended,
//                                             
//                                        'CulturalDivCourse' => $this->cultural_div_course,
//                                        'CulturalDivTermCompleted' => $this->cultural_div_term_completed,
//                                        'CulturalDivGradeEarned' => $this->cultural_div_grade_earned,
//                                        'CulturalDivSchoolAttended' => $this->cultural_div_school_attended,
                        
                                        'DidAttendOrientationSession' => $this->did_attend_orientation_session,
                                        'DateAttended' => $this->date_attended,
                        
                                        'IsReapplicant' => $this->is_reapplicant,
                                        'YearLastApplied' => $this->year_last_applied,
                        
                                        'PCEIClinicHospitalName' => $this->pceI_clinic_hospital_name,
                                        'PCEITypeofworkPerformed' => $this->pceI_type_of_work_performed,
                                        'PCEINoofHours' => $this->pceI_no_of_hours,
                                        'PCEIStartandEndDate' => $this->pceI_start_and_end_date,
                                        'PCEIIClinicHospitalName' => $this->pceII_clinic_hospital_name,
                                        'PCEIITypeofworkPerformed' => $this->pceII_type_of_work_performed,
                                        'PCEIINoofHours' => $this->pceII_no_of_hours,                           
                                        'PCEIIStartandEndDate' => $this->pceII_start_and_end_date,
                        
                                        'PersonalStatement' => $this->personal_stmt,
                        
                                        'UnofficialTranscript1' => $this->college_transcript_1,
                                        'UnofficialTranscript2' => $this->college_transcript_2,
                                        'UnofficialTranscript3' => $this->college_transcript_3,
                                        'UnofficialTranscript4' => $this->college_transcript_4,
                        
                                        'PatientcareorRadiologyForm' => $this->patient_care_radiology_exp,
                                        'Prerequisite' => $this->prerequisite,
                                        'TransID' => $this->transaction->get_id(), 
                                        'FormID' => $this->form_id,
                                        'ElectronicSignature' => $this->signature
                                    );
                      //error_log("input data :".print_r($input_data,true));              
                    $result = $query->execute($input_data);                   
                    //var_dump($result);
                    //var_dump($conn->errorCode());
                    //var_dump($conn->errorInfo());
                    return $result;
            } catch (PDOException $e) {
                error_log( print_r("PDOException in RadiologicTechnologyProgram_AA::save - " . $e->getMessage(), true) );
            } catch (Exception $e) {
                error_log( print_r("General exception in RadiologicTechnologyProgram_AA::save - " . $e->getMessage(), true) );
            }
        }       
        return false;
    }

    //fill in data model fields using form information
    public function build($_entry) {
        
        //error_log(print_r($_entry,true));
        //exit();
        //set model info using entry values
        $this->first_name = !empty($_entry['2.3']) ? rgar($_entry, '2.3') : null;
        $this->last_name = !empty($_entry['2.6']) ? rgar($_entry, '2.6') : null;
        $this->sid = !empty($_entry['3']) ? rgar($_entry, '3') : null;
        $this->email = !empty($_entry['4']) ? rgar($_entry, '4') : null;
        $this->phone = !empty($_entry['5']) ? rgar($_entry, '5') : null;
        
//        //process transfer english info
//        if ( !empty($_entry['8']) ){
//            $class_data = unserialize(rgar( $_entry, '8' ));
//
//            $this->eng_comp_course = !empty($class_data[0]["Course"]) ? $class_data[0]["Course"] : null;
//            $this->eng_comp_term_completed = !empty($class_data[0]["Term completed"]) ? $class_data[0]["Term completed"] : null;
//            $this->eng_comp_grade_earned = !empty($class_data[0]["Grade"]) ? $class_data[0]["Grade"] : null;
//            $this->eng_comp_school_attended = !empty($class_data[0]["School"]) ? $class_data[0]["School"] : null;
//        } else {
//            $this->eng_comp_course = null;
//            $this->eng_comp_term_completed = null;
//            $this->eng_comp_grade_earned = null;
//            $this->eng_comp_school_attended = null;
//        }
//        
//        //process Intermediate Algebra or Precalculus info
//        if ( !empty($_entry['10']) ){
//            $class_data = unserialize(rgar( $_entry, '10' ));
//
//            $this->int_alg_course = !empty($class_data[0]["Course"]) ? $class_data[0]["Course"] : null;
//            $this->int_alg_term_completed = !empty($class_data[0]["Term completed"]) ? $class_data[0]["Term completed"] : null;
//            $this->int_alg_grade_earned = !empty($class_data[0]["Grade"]) ? $class_data[0]["Grade"] : null;
//            $this->int_alg_school_attended = !empty($class_data[0]["School"]) ? $class_data[0]["School"] : null;
//        } else {
//            $this->int_alg_course = null;
//            $this->int_alg_term_completed = null;
//            $this->int_alg_grade_earned = null;
//            $this->int_alg_school_attended = null;
//        }
//        
//        
//        //process human anatomy & physiology I
//        if ( !empty($_entry['12']) ){
//            $class_data = unserialize(rgar( $_entry, '12' ));
//
//            $this->ha_phyI_course = !empty($class_data[0]["Course"]) ? $class_data[0]["Course"] : null;
//            $this->ha_phyI_term_completed = !empty($class_data[0]["Term completed"]) ? $class_data[0]["Term completed"] : null;
//            $this->ha_phyI_grade_earned = !empty($class_data[0]["Grade"]) ? $class_data[0]["Grade"] : null;
//            $this->ha_phyI_school_attended = !empty($class_data[0]["School"]) ? $class_data[0]["School"] : null;
//        } else {
//            $this->ha_phyI_course = null;
//            $this->ha_phyI_term_completed = null;
//            $this->ha_phyI_grade_earned = null;
//            $this->ha_phyI_school_attended = null;
//        }
//        
//        //process human anatomy & physiology II
//        if ( !empty($_entry['13']) ){
//            $class_data = unserialize(rgar( $_entry, '13' ));
//
//            $this->ha_phyII_course = !empty($class_data[0]["Course"]) ? $class_data[0]["Course"] : null;
//            $this->ha_phyII_term_completed = !empty($class_data[0]["Term completed"]) ? $class_data[0]["Term completed"] : null;
//            $this->ha_phyII_grade_earned = !empty($class_data[0]["Grade"]) ? $class_data[0]["Grade"] : null;
//            $this->ha_phyII_school_attended = !empty($class_data[0]["School"]) ? $class_data[0]["School"] : null;
//        } else {
//            $this->ha_phyII_course = null;
//            $this->ha_phyII_term_completed = null;
//            $this->ha_phyII_grade_earned = null;
//            $this->ha_phyII_school_attended = null;
//        }
//        
//        //process cultural diversity course info
//        if ( !empty($_entry['15']) ){
//            $class_data = unserialize(rgar( $_entry, '15' ));
//
//            $this->cultural_div_course = !empty($class_data[0]["Course"]) ? $class_data[0]["Course"] : null;
//            $this->cultural_div_term_completed = !empty($class_data[0]["Term completed"]) ? $class_data[0]["Term completed"] : null;
//            $this->cultural_div_grade_earned = !empty($class_data[0]["Grade"]) ? $class_data[0]["Grade"] : null;
//            $this->cultural_div_school_attended = !empty($class_data[0]["School"]) ? $class_data[0]["School"] : null;
//        } else {
//            $this->cultural_div_course = null;
//            $this->cultural_div_term_completed = null;
//            $this->cultural_div_grade_earned = null;
//            $this->cultural_div_school_attended = null;
//        }
//        
        
        if ( empty($_entry['16']) ) {
            $this->did_attend_orientation_session = null;
        } else if ( !empty($_entry['16']) && strtolower(rgar($_entry, '16')) == "yes" ) {
            $this->did_attend_orientation_session = true;
        } else {
            $this->did_attend_orientation_session = false;
        }  
        
        
        $this->date_attended = !empty($_entry['17']) ? rgar($_entry, '17') : null;
        
        if ( empty($_entry['18']) ) {
            $this->is_reapplicant = null;
        } else if ( !empty($_entry['18']) && strtolower(rgar($_entry, '18')) == "yes" ) {
            $this->is_reapplicant = true;
        } else {
            $this->is_reapplicant = false;
        }  
        $this->year_last_applied = !empty($_entry['19']) ? rgar($_entry, '19') : null;
        
        if ( !empty($_entry['38']) ){
            $class_data = unserialize(rgar( $_entry, '38' ));

            $this->pceI_clinic_hospital_name = !empty($class_data[0]["Clinic/Hospital"]) ? $class_data[0]["Clinic/Hospital"] : null;
            $this->pceI_type_of_work_performed = !empty($class_data[0]["Type of work performed"]) ? $class_data[0]["Type of work performed"] : null;
            $this->pceI_no_of_hours = !empty($class_data[0]["No. of hours"]) ? $class_data[0]["No. of hours"] : null;
            $this->pceI_start_and_end_date = !empty($class_data[0]["Start and End dates"]) ? $class_data[0]["Start and End dates"] : null;
            $this->pceII_clinic_hospital_name = !empty($class_data[1]["Clinic/Hospital"]) ? $class_data[1]["Clinic/Hospital"] : null;
            $this->pceII_type_of_work_performed = !empty($class_data[1]["Type of work performed"]) ? $class_data[1]["Type of work performed"] : null;
            $this->pceII_no_of_hours = !empty($class_data[1]["No. of hours"]) ? $class_data[1]["No. of hours"] : null;
            $this->pceII_start_and_end_date = !empty($class_data[1]["Start and End dates"]) ? $class_data[1]["Start and End dates"] : null;
        } else {
            $this->pceI_clinic_hospital_name = null;
            $this->pceI_type_of_work_performed = null;
            $this->pceI_no_of_hours = null;
            $this->pceI_start_and_end_date = null;
            $this->pceII_clinic_hospital_name = null;
            $this->pceII_type_of_work_performed = null;
            $this->pceII_no_of_hours = null;
            $this->pceII_start_and_end_date = null;
        }
        
        $this->personal_stmt = !empty($_entry['23']) ? rgar($_entry, '23') : null;
        $this->college_transcript_1 = !empty($_entry['25']) ? rgar($_entry, '25') : null;
        $this->college_transcript_2 = !empty($_entry['26']) ? rgar($_entry, '26') : null;
        $this->college_transcript_3 = !empty($_entry['27']) ? rgar($_entry, '27') : null;
        $this->college_transcript_4 = !empty($_entry['28']) ? rgar($_entry, '28') : null;
        $this->patient_care_radiology_exp = !empty($_entry['31']) ? rgar($_entry, '31') : null;
        $this->prerequisite = !empty($_entry['45']) ? rgar($_entry, '45') : null;
        
        $this->signature = !empty($_entry['36']) ? rgar($_entry, '36') : null;
        $this->form_id = rgar($_entry, 'form_id');

        //build transaction object
        $this->transaction = new Transaction(
            rgar($_entry, 'transaction_id'),
            $this->form_id,
            $this->sid,
            $this->first_name,
            $this->last_name,
            $this->email,
            rgar($_entry, 'payment_amount'),
            null,
            rgar($_entry, 'payment_date'),
            null,
            null,
            null,
            rgar($_entry, '42.1'),
            rgar($_entry, '42.3'),
            rgar($_entry, '42.4'),
            rgar($_entry, '42.5'),
            rgar($_entry, '42.6')
        );
    }

    //return transaction
	public function get_transaction(){
		return $this->transaction;
	}

    //return form ID
	public function get_form_id(){
		return $this->form_id;
	}

}