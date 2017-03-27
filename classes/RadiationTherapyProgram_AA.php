<?php
require_once('DB.php');
require_once('Transaction.php');

class RadiationTherapyProgram_AA
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
//    protected $other_hundred_math_course;
//    protected $other_hundred_math_term_completed;
//    protected $other_hundred_math_grade_earned;
//    protected $other_hundred_math_school_attended;
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
//    protected $comm_intro_course;
//    protected $comm_intro_term_completed;
//    protected $comm_intro_grade_earned;
//    protected $comm_intro_school_attended;
//    
//    protected $cultural_div_course;
//    protected $cultural_div_term_completed;
//    protected $cultural_div_grade_earned;
//    protected $cultural_div_school_attended;
    
    protected $did_attend_info_session;
    protected $date_attended;
    
    protected $is_reapplicant;
    protected $year_last_applied;
    
    protected $did_compl_hospital_obs;
    protected $date_completed;
    
    protected $clinical_site_name;

    protected $personal_stmt;
    
    protected $college_transcript_1;
    protected $college_transcript_2;
    protected $college_transcript_3;
    protected $college_transcript_4;
    
    protected $hospital_observation_form;
    
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
                $tsql = 'EXEC [usp_InsertIntoAARadiationTherapyForm]'
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
//                            . '@OtherhundredMathCourse = :OtherhundredMathCourse,'
//                            . '@OtherhundredMathTermCompleted = :OtherhundredMathTermCompleted,'
//                            . '@OtherhundredMathGradeEarned = :OtherhundredMathGradeEarned,'
//                            . '@OtherhundredMathSchoolAttended = :OtherhundredMathSchoolAttended,'
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
//                            . '@CommIntroCourse = :CommIntroCourse,'
//                            . '@CommIntroTermCompleted = :CommIntroTermCompleted,'
//                            . '@CommIntroGradeEarned = :CommIntroGradeEarned,'
//                            . '@CommIntroSchoolAttended = :CommIntroSchoolAttended,'
//                        
//                            . '@CulturalDivCourse = :CulturalDivCourse,'
//                            . '@CulturalDivTermCompleted = :CulturalDivTermCompleted,'
//                            . '@CulturalDivGradeEarned = :CulturalDivGradeEarned,'
//                            . '@CulturalDivSchoolAttended = :CulturalDivSchoolAttended,'
                        
                            . '@DidAttendInfoSession = :DidAttendInfoSession,'
                            . '@DateAttended = :DateAttended,'
                        
                            . '@IsReapplicant = :IsReapplicant,'
                            . '@YearLastApplied = :YearLastApplied,'
                        
                            . '@DidComplHospitalObs = :DidComplHospitalObs,'
                            . '@DateCompleted = :DateCompleted,'
                        
                            . '@ClinicalSiteName = :ClinicalSiteName,'
                            . '@PersonalStatement = :PersonalStatement,'
                        
                            . '@UnofficialTranscript1 = :UnofficialTranscript1,'
                            . '@UnofficialTranscript2 = :UnofficialTranscript2,'
                            . '@UnofficialTranscript3 = :UnofficialTranscript3,'
                            . '@UnofficialTranscript4 = :UnofficialTranscript4,'
                        
                            . '@HospitalObservationForm = :HospitalObservationForm,'
                            . '@Prerequisite = :Prerequisite,'
                            . '@TransID = :TransID,'
                            . '@FormID = :FormID,'
                            . '@ElectronicSignature = :ElectronicSignature;';
                
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
//                                        'OtherhundredMathCourse' => $this->other_hundred_math_course,
//                                        'OtherhundredMathTermCompleted' => $this->other_hundred_math_term_completed,
//                                        'OtherhundredMathGradeEarned' => $this->other_hundred_math_grade_earned,
//                                        'OtherhundredMathSchoolAttended' => $this->other_hundred_math_school_attended,
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
//                                        'CommIntroCourse' => $this->comm_intro_course,
//                                        'CommIntroTermCompleted' => $this->comm_intro_term_completed,
//                                        'CommIntroGradeEarned' => $this->comm_intro_grade_earned,
//                                        'CommIntroSchoolAttended' => $this->comm_intro_school_attended,
//                        
//                                        'CulturalDivCourse' => $this->cultural_div_course,
//                                        'CulturalDivTermCompleted' => $this->cultural_div_term_completed,
//                                        'CulturalDivGradeEarned' => $this->cultural_div_grade_earned,
//                                        'CulturalDivSchoolAttended' => $this->cultural_div_school_attended,
//                        
                                        'DidAttendInfoSession' => $this->did_attend_info_session,
                                        'DateAttended' => $this->date_attended,
                        
                                        'IsReapplicant' => $this->is_reapplicant,
                                        'YearLastApplied' => $this->year_last_applied,
                        
                                        'DidComplHospitalObs' => $this->did_compl_hospital_obs,
                                        'DateCompleted' => $this->date_completed,
                        
                                        'ClinicalSiteName' => $this->clinical_site_name,
                                        'PersonalStatement' => $this->personal_stmt,
                        
                                        'UnofficialTranscript1' => $this->college_transcript_1,
                                        'UnofficialTranscript2' => $this->college_transcript_2,
                                        'UnofficialTranscript3' => $this->college_transcript_3,
                                        'UnofficialTranscript4' => $this->college_transcript_4,
                        
                                        'HospitalObservationForm' => $this->hospital_observation_form,
                                        'Prerequisite' => $this->prerequisite,
                                        'TransID' => $this->transaction->get_id(), 
                                        'FormID' => $this->form_id,
                                        'ElectronicSignature' => $this->signature
                                    );
                                    
                    $result = $query->execute($input_data);                   
                    //var_dump($result);
                    //var_dump($conn->errorCode());
                    //var_dump($conn->errorInfo());
                    return $result;
            } catch (PDOException $e) {
                error_log( print_r("PDOException in RadiationTherapyProgram_AA::save - " . $e->getMessage(), true) );
            } catch (Exception $e) {
                error_log( print_r("General exception in RadiationTherapyProgram_AA::save - " . $e->getMessage(), true) );
            }
        }       
        return false;
    }

    //fill in data model fields using form information
    public function build($_entry) {
        //set model info using entry values
        $this->first_name = !empty($_entry['2.3']) ? rgar($_entry, '2.3') : null;
        $this->last_name = !empty($_entry['2.6']) ? rgar($_entry, '2.6') : null;
        $this->sid = !empty($_entry['3']) ? rgar($_entry, '3') : null;
        $this->email = !empty($_entry['4']) ? rgar($_entry, '4') : null;
        $this->phone = !empty($_entry['5']) ? rgar($_entry, '5') : null;
        
        //process transfer english info
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
//        //process Other 100 level math course info
//        if ( !empty($_entry['11']) ){
//            $class_data = unserialize(rgar( $_entry, '11' ));
//
//            $this->other_hundred_math_course = !empty($class_data[0]["Course"]) ? $class_data[0]["Course"] : null;
//            $this->other_hundred_math_term_completed = !empty($class_data[0]["Term completed"]) ? $class_data[0]["Term completed"] : null;
//            $this->other_hundred_math_grade_earned = !empty($class_data[0]["Grade"]) ? $class_data[0]["Grade"] : null;
//            $this->other_hundred_math_school_attended = !empty($class_data[0]["School"]) ? $class_data[0]["School"] : null;
//        } else {
//            $this->other_hundred_math_course = null;
//            $this->other_hundred_math_term_completed = null;
//            $this->other_hundred_math_grade_earned = null;
//            $this->other_hundred_math_school_attended = null;
//        }
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
//        //process Introduction to Communication info
//        if ( !empty($_entry['14']) ){
//            $class_data = unserialize(rgar( $_entry, '14' ));
//
//            $this->comm_intro_course = !empty($class_data[0]["Course"]) ? $class_data[0]["Course"] : null;
//            $this->comm_intro_term_completed = !empty($class_data[0]["Term completed"]) ? $class_data[0]["Term completed"] : null;
//            $this->comm_intro_grade_earned = !empty($class_data[0]["Grade"]) ? $class_data[0]["Grade"] : null;
//            $this->comm_intro_school_attended = !empty($class_data[0]["School"]) ? $class_data[0]["School"] : null;
//        } else {
//            $this->comm_intro_course = null;
//            $this->comm_intro_term_completed = null;
//            $this->comm_intro_grade_earned = null;
//            $this->comm_intro_school_attended = null;
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
            $this->did_attend_info_session = null;
        } else if ( !empty($_entry['16']) && strtolower(rgar($_entry, '16')) == "yes" ) {
            $this->did_attend_info_session = true;
        } else {
            $this->did_attend_info_session = false;
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
        
        if ( empty($_entry['20']) ) {
            $this->did_compl_hospital_obs = null;
        } else if ( !empty($_entry['20']) && strtolower(rgar($_entry, '20')) == "yes" ) {
            $this->did_compl_hospital_obs = true;
        } else {
            $this->did_compl_hospital_obs = false;
        }  
        
        $this->date_completed = !empty($_entry['21']) ? rgar($_entry, '21') : null;
        $this->clinical_site_name = !empty($_entry['22']) ? rgar($_entry, '22') : null;
        $this->personal_stmt = !empty($_entry['23']) ? rgar($_entry, '23') : null;
        $this->college_transcript_1 = !empty($_entry['25']) ? rgar($_entry, '25') : null;
        $this->college_transcript_2 = !empty($_entry['26']) ? rgar($_entry, '26') : null;
        $this->college_transcript_3 = !empty($_entry['27']) ? rgar($_entry, '27') : null;
        $this->college_transcript_4 = !empty($_entry['28']) ? rgar($_entry, '28') : null;
        $this->hospital_observation_form = !empty($_entry['31']) ? rgar($_entry, '31') : null;
        $this->prerequisite = !empty($_entry['42']) ? rgar($_entry, '42') : null;
        
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
            rgar($_entry, '38.1'),
            rgar($_entry, '38.2'),
            rgar($_entry, '38.3'),
            rgar($_entry, '38.4'),
            rgar($_entry, '38.5')
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