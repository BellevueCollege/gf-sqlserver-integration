<?php
require_once('DB.php');
require_once('Transaction.php');

class HealthcareInformatics_BAS
{
    protected $first_name;
    protected $last_name;
    protected $sid;
    protected $email;
    protected $phone;
    protected $enroll_status;

//    protected $req1_howmeet;
//    protected $req1_school;
//    protected $req1_degree;
//    protected $req1_courses;
//
//    protected $req2_course;
//    protected $req2_quarter;
//    protected $req2_grade;
//    protected $req2_school;
//
//    protected $req3_course;
//    protected $req3_quarter;
//    protected $req3_grade;
//    protected $req3_school;
//
//    protected $req4_course;
//    protected $req4_quarter;
//    protected $req4_grade;
//    protected $req4_school;
//
//    protected $req5_course;
//    protected $req5_quarter;
//    protected $req5_grade;
//    protected $req5_school;    
//
//    protected $req6_course;
//    protected $req6_quarter;
//    protected $req6_grade;
//    protected $req6_school;
//
//    protected $req7_lab_course;
//    protected $req7_lab_quarter;
//    protected $req7_lab_grade;
//    protected $req7_lab_school;
//
//    protected $req7_life_course;
//    protected $req7_life_quarter;
//    protected $req7_life_grade;
//    protected $req7_life_school;
    
    protected $prerequisite;
    

    protected $transcript_1;
    protected $transcript_2;
    protected $transcript_3;
    protected $personal_stmt;
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
                $tsql = 'EXEC [usp_InsertIntoHealthCareInformaticsForm]'
                            . '@SID = :SID,'
                            . '@Fname = :FirstName,'
                            . '@Lname = :LastName,'
                            . '@Phone = :Phone,'
                            . '@BCEmail = :Email,'
                            . '@EnrollmentStatus = :EnrollmentStatus,'

//                            . '@Req1MetAdmissionBy = :Req1MetAdmissionBy,'
//                            . '@Req1DegreeCompleted = :Req1DegreeCompleted,'
//                            . '@Req1CoursesCompleted = :Req1CoursesCompleted,'
//                            . '@Req1SchoolAttended = :Req1SchoolAttended,'
//
//                            . '@Req2CourseNameNumber = :Req2Course,'
//                            . '@Req2QuarterSemester = :Req2Quarter,'
//                            . '@Req2GradeEarned = :Req2Grade,'
//                            . '@Req2SchoolAttended = :Req2School,'
//
//                            . '@Req3CourseNameNumber = :Req3Course,'
//                            . '@Req3QuarterSemester = :Req3Quarter,'
//                            . '@Req3GradeEarned = :Req3Grade,'
//                            . '@Req3SchoolAttended = :Req3School,'
//
//                            . '@Req4CourseNameNumber = :Req4Course,'
//                            . '@Req4QuarterSemester = :Req4Quarter,'
//                            . '@Req4GradeEarned = :Req4Grade,'
//                            . '@Req4SchoolAttended = :Req4School,'
//
//                            . '@Req5CourseNameNumber = :Req5Course,'
//                            . '@Req5QuarterSemester = :Req5Quarter,'
//                            . '@Req5GradeEarned = :Req5Grade,'
//                            . '@Req5SchoolAttended = :Req5School,'
//
//                            . '@Req6CourseNameNumber = :Req6Course,'
//                            . '@Req6QuarterSemester = :Req6Quarter,'
//                            . '@Req6GradeEarned = :Req6Grade,'
//                            . '@Req6SchoolAttended = :Req6School,'
//
//                            . '@Req7aCourseNameNumber = :Req7ACourse,'
//                            . '@Req7aQuarterSemester = :Req7AQuarter,'
//                            . '@Req7aGradeEarned = :Req7AGrade,'
//                            . '@Req7aSchoolAttended = :Req7ASchool,'
//
//                            . '@Req7bCourseNameNumber = :Req7BCourse,'
//                            . '@Req7bQuarterSemester = :Req7BQuarter,'
//                            . '@Req7bGradeEarned = :Req7BGrade,'
//                            . '@Req7bSchoolAttended = :Req7BSchool,'

                            . '@Prerequisite = :Prerequisite,'
                            . '@PersonalStatement = :PersonalStatement,'                                                                             
                            . '@TransID = :TransID,'
                            . '@FormID = :FormID,'
                            . '@ElectronicSignature = :ElectronicSignature,'
                            . '@UnofficialTranscript1 = :UnofficialTranscript1,'
                            . '@UnofficialTranscript2 = :UnofficialTranscript2,'
                            . '@UnofficialTranscript3 = :UnofficialTranscript3;';
                    $query = $conn->prepare( $tsql );

                    $input_data = array( 
                                        'SID' => $this->sid,
                                        'FirstName' => $this->first_name,
                                        'LastName' => $this->last_name, 
                                        'Phone' => $this->phone,
                                        'Email' => $this->email,
                                        'EnrollmentStatus' => $this->enroll_status,

//                                        'Req1MetAdmissionBy' => $this->req1_howmeet,
//                                        'Req1DegreeCompleted' => $this->req1_degree,
//                                        'Req1CoursesCompleted' => $this->req1_courses,
//                                        'Req1SchoolAttended' => $this->req1_school,
//                                        
//                                        'Req2Course' => $this->req2_course,
//                                        'Req2Quarter' => $this->req2_quarter,
//                                        'Req2Grade' => $this->req2_grade,
//                                        'Req2School' => $this->req2_school,
//
//                                        'Req3Course' => $this->req3_course,
//                                        'Req3Quarter' => $this->req3_quarter,
//                                        'Req3Grade' => $this->req3_grade,
//                                        'Req3School' => $this->req3_school,
//
//                                        'Req4Course' => $this->req4_course,
//                                        'Req4Quarter' => $this->req4_quarter,
//                                        'Req4Grade' => $this->req4_grade,
//                                        'Req4School' => $this->req4_school,
//
//                                        'Req5Course' => $this->req5_course,
//                                        'Req5Quarter' => $this->req5_quarter,
//                                        'Req5Grade' => $this->req5_grade,
//                                        'Req5School' => $this->req5_school,
//
//                                        'Req6Course' => $this->req6_course,
//                                        'Req6Quarter' => $this->req6_quarter,
//                                        'Req6Grade' => $this->req6_grade,
//                                        'Req6School' => $this->req6_school,
//
//                                        'Req7ACourse' => $this->req7_lab_course,
//                                        'Req7AQuarter' => $this->req7_lab_quarter,
//                                        'Req7AGrade' => $this->req7_lab_grade,
//                                        'Req7ASchool' => $this->req7_lab_school,
//
//                                        'Req7BCourse' => $this->req7_life_course,
//                                        'Req7BQuarter' => $this->req7_life_quarter,
//                                        'Req7BGrade' => $this->req7_life_grade,
//                                        'Req7BSchool' => $this->req7_life_school,
                                        'Prerequisite' => $this->prerequisite,
                                        'PersonalStatement' => $this->personal_stmt,
                                        'UnofficialTranscript1' => $this->transcript_1,
                                        'UnofficialTranscript2' => $this->transcript_2,
                                        'UnofficialTranscript3' => $this->transcript_3,                       
                             
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
                error_log( print_r("PDOException in HealthcareInformatics_BAS::save - " . $e->getMessage(), true) );
            } catch (Exception $e) {
                error_log( print_r("General exception in HealthcareInformatics_BAS::save - " . $e->getMessage(), true) );
            }
        }       
        return false;
    }

    //fill in data model fields using form information
    public function build($_entry) {
        //set model info using entry values
        $this->first_name = !empty($_entry['1.3']) ? rgar($_entry, '1.3') : null;
        $this->last_name = !empty($_entry['1.6']) ? rgar($_entry, '1.6') : null;
        $this->sid = !empty($_entry['3']) ? rgar($_entry, '3') : null;
        $this->email = !empty($_entry['4']) ? rgar($_entry, '4') : null;
        $this->phone = !empty($_entry['5']) ? rgar($_entry, '5') : null;
        $this->enroll_status = !empty($_entry['9']) ? rgar($_entry, '9') : null;

//        $this->req1_howmeet = !empty($_entry['25']) ? rgar($_entry, '25') : null;
//        $this->req1_school = !empty($_entry['24']) ? rgar($_entry, '24') : null;
//        $this->req1_degree = !empty($_entry['26']) ? rgar($_entry, '26') : null;
//        $this->req1_courses = !empty($_entry['27']) ? rgar($_entry, '27') : null;
//
//        $this->req2_course = !empty($_entry['29']) ? rgar($_entry, '29') : null;
//        $this->req2_quarter = !empty($_entry['30']) ? rgar($_entry, '30') : null;
//        $this->req2_grade = !empty($_entry['31']) ? rgar($_entry, '31') : null;
//        $this->req2_school = !empty($_entry['32']) ? rgar($_entry, '32') : null;
//
//        $this->req3_course = !empty($_entry['34']) ? rgar($_entry, '34') : null;
//        $this->req3_quarter = !empty($_entry['35']) ? rgar($_entry, '35') : null;
//        $this->req3_grade = !empty($_entry['36']) ? rgar($_entry, '36') : null;
//        $this->req3_school = !empty($_entry['37']) ? rgar($_entry, '37') : null;
//
//        $this->req4_course = !empty($_entry['39']) ? rgar($_entry, '39') : null;
//        $this->req4_quarter = !empty($_entry['40']) ? rgar($_entry, '40') : null;
//        $this->req4_grade = !empty($_entry['41']) ? rgar($_entry, '41') : null;
//        $this->req4_school = !empty($_entry['42']) ? rgar($_entry, '42') : null;
//
//        $this->req5_course = !empty($_entry['44']) ? rgar($_entry, '44') : null;
//        $this->req5_quarter = !empty($_entry['45']) ? rgar($_entry, '45') : null;
//        $this->req5_grade = !empty($_entry['46']) ? rgar($_entry, '46') : null;
//        $this->req5_school = !empty($_entry['47']) ? rgar($_entry, '47') : null;    
//
//        $this->req6_course = !empty($_entry['49']) ? rgar($_entry, '49') : null;
//        $this->req6_quarter = !empty($_entry['50']) ? rgar($_entry, '50') : null;
//        $this->req6_grade = !empty($_entry['51']) ? rgar($_entry, '51') : null;
//        $this->req6_school = !empty($_entry['52']) ? rgar($_entry, '52') : null;
//
//        $this->req7_lab_course = !empty($_entry['54']) ? rgar($_entry, '54') : null;
//        $this->req7_lab_quarter = !empty($_entry['55']) ? rgar($_entry, '55') : null;
//        $this->req7_lab_grade = !empty($_entry['56']) ? rgar($_entry, '56') : null;
//        $this->req7_lab_school = !empty($_entry['57']) ? rgar($_entry, '57') : null;
//
//        $this->req7_life_course = !empty($_entry['58']) ? rgar($_entry, '58') : null;
//        $this->req7_life_quarter = !empty($_entry['59']) ? rgar($_entry, '59') : null;
//        $this->req7_life_grade = !empty($_entry['60']) ? rgar($_entry, '60') : null;
//        $this->req7_life_school = !empty($_entry['61']) ? rgar($_entry, '61') : null;

        $this->prerequisite = !empty($_entry['71']) ? rgar($_entry, '71') : null;
        $this->transcript_1 = !empty($_entry['68']) ? rgar($_entry, '68') : null;
        $this->transcript_2 = !empty($_entry['69']) ? rgar($_entry, '69') : null;
        $this->transcript_3 = !empty($_entry['70']) ? rgar($_entry, '70') : null;
        
        $this->personal_stmt = !empty($_entry['67']) ? rgar($_entry, '67') : null;
        $this->signature = !empty($_entry['23']) ? rgar($_entry, '23') : null;
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
            rgar($_entry, '66.1'),
            rgar($_entry, '66.2'),
            rgar($_entry, '66.3'),
            rgar($_entry, '66.4'),
            rgar($_entry, '66.5')
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