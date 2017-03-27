<?php
require_once('DB.php');
require_once('Transaction.php');

class HealthCareInformaticsCertificate
{
    protected $first_name;
    protected $last_name;
    protected $sid;
    protected $email;
    protected $phone;
    protected $enroll_status;
    
//    protected $req1_degree;
//    protected $req1_school;
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

//    protected $req4_course;
//    protected $req4_quarter;
//    protected $req4_grade;
//    protected $req4_school;
    
    protected $prerequisite;
    protected $personal_stmt;
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
                $tsql = 'EXEC [usp_InsertIntoCertHealthCareInformaticsForm]'
                            . '@SID = :SID,'
                            . '@Fname = :FirstName,'
                            . '@Lname = :LastName,'
                            . '@Phone = :Phone,'
                            . '@BCEmail = :Email,'
                            . '@EnrollmentStatus = :EnrollmentStatus,'

                            
//                            . '@Req1DegreeTitle = :Req1DegreeTitle,'                            
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
                            . '@Prerequisite = :Prerequisite,'
                            . '@PersonalStatement = :PersonalStatement,'
                            . '@TransID = :TransID,'
                            . '@FormID = :FormID;';
                    $query = $conn->prepare( $tsql );
                    
                    $input_data = array( 
                                        'SID' => $this->sid,
                                        'FirstName' => $this->first_name,
                                        'LastName' => $this->last_name, 
                                        'Phone' => $this->phone,
                                        'Email' => $this->email,
                                        'EnrollmentStatus' => $this->enroll_status,

                                        
//                                        'Req1DegreeTitle' => $this->req1_degree,
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
                                        'Prerequisite' => $this->prerequisite,
                                        'PersonalStatement' => $this->personal_stmt,
                                        'TransID' => $this->transaction->get_id(), 
                                        'FormID' => $this->form_id
                                    );                                                                        
                    $result = $query->execute($input_data);
                    //var_dump($result);
                    //var_dump($conn->errorCode());
                    //var_dump($conn->errorInfo());
                    return $result;
            } catch (PDOException $e) {
                error_log( print_r("PDOException in HealthCareInformaticsCertificate::save - " . $e->getMessage(), true) );
            } catch (Exception $e) {
                error_log( print_r("General exception in HealthCareInformaticsCertificate::save - " . $e->getMessage(), true) );
            }
        }       
        return false;
    }

    //fill in data model fields using form information
    public function build($_entry) {
        //var_dump($_entry);
        //set model info using entry values
        $this->first_name = !empty($_entry['2.3']) ? rgar($_entry, '2.3') : null;
        $this->last_name = !empty($_entry['2.6']) ? rgar($_entry, '2.6') : null;
        $this->sid = !empty($_entry['3']) ? rgar($_entry, '3') : null;
        $this->email = !empty($_entry['4']) ? rgar($_entry, '4') : null;
        $this->phone = !empty($_entry['5']) ? rgar($_entry, '5') : null;
        $this->enroll_status = !empty($_entry['7']) ? rgar($_entry, '7') : null;

//        $this->req1_degree = !empty($_entry['10']) ? rgar($_entry, '10') : null;
//        $this->req1_school = !empty($_entry['11']) ? rgar($_entry, '11') : null;               
//
//        $this->req2_course = !empty($_entry['13']) ? rgar($_entry, '13') : null;
//        $this->req2_quarter = !empty($_entry['14']) ? rgar($_entry, '14') : null;
//        $this->req2_grade = !empty($_entry['15']) ? rgar($_entry, '15') : null;
//        $this->req2_school = !empty($_entry['20']) ? rgar($_entry, '20') : null;
//
//        $this->req3_course = !empty($_entry['18']) ? rgar($_entry, '18') : null;
//        $this->req3_quarter = !empty($_entry['19']) ? rgar($_entry, '19') : null;
//        $this->req3_grade = !empty($_entry['21']) ? rgar($_entry, '21') : null;
//        $this->req3_school = !empty($_entry['16']) ? rgar($_entry, '16') : null;
//
//        $this->req4_course = !empty($_entry['23']) ? rgar($_entry, '23') : null;
//        $this->req4_quarter = !empty($_entry['24']) ? rgar($_entry, '24') : null;
//        $this->req4_grade = !empty($_entry['25']) ? rgar($_entry, '25') : null;
//        $this->req4_school = !empty($_entry['26']) ? rgar($_entry, '26') : null;

        

        $this->personal_stmt = !empty($_entry['29']) ? rgar($_entry, '29') : null;
        
        $this->prerequisite = !empty($_entry['37']) ? rgar($_entry, '37') : null;
        
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
            rgar($_entry, '35.1'),
            rgar($_entry, '35.2'),
            rgar($_entry, '35.3'),
            rgar($_entry, '35.4'),
            rgar($_entry, '35.5')
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

