<?php
require_once('DB.php');
require_once('Transaction.php');

class IST_BAS
{
    protected $first_name;
    protected $last_name;
    protected $sid;
    protected $email;
    protected $pers_email;
    protected $phone;
    protected $highest_ed;
    protected $program_start;
    protected $cur_employed;
    protected $cur_employed_status;
    protected $cur_employed_employer;
    protected $enroll_status;
    protected $concentration;
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

    //save data model to external db
    public function save() {
        $db = new DB();
        $conn = $db->getDB();

        if ( $conn ) {
            try {
                $result = $this->transaction->save();   //save transaction first because of db constraint on trans id
                $tsql = 'EXEC [usp_InsertIntoInfoSystemsNTechnologyForm]'
                            . '@TransID = :TransID,'
                            . '@Fname = :FirstName,'
                            . '@Lname = :LastName,'
                            . '@FormID = :FormID,'
                            . '@SID = :SID,'
                            . '@BCEmail = :BCEmail,'
                            . '@PersonalEmail = :PersonalEmail,'
                            . '@Phone = :Phone,'
                            . '@EducationLevel = :EducationLevel,'
                            . '@IntendedPS = :IntendedProgramStart,'
                            . '@CurrentlyEmployed = :CurrentlyEmployed,'
                            . '@Concentration = :Concentration,'
                            . '@Employer = :Employer,'
                            . '@EmploymentLevel = :EmploymentLevel,'
                            . '@UnofficialTrans1 = :UnofficialTranscript1,'
                            . '@UnofficialTrans2 = :UnofficialTranscript2,'
                            . '@UnofficialTrans3 = :UnofficialTranscript3,'
                            . '@PersonalStatement = :PersonalStatement,'
                            . '@EnrollmentStatus = :EnrollmentStatus,'
                            . '@ElectronicSignature = :ElectronicSignature;';
                    $query = $conn->prepare( $tsql );
                    $input_data = array(
                                        'TransID' => $this->transaction->get_id(), 
                                        'FirstName' => $this->first_name,
                                        'LastName' => $this->last_name, 
                                        'FormID' => $this->form_id,
                                        'SID' => $this->sid,
                                        'BCEmail' => $this->email,
                                        'PersonalEmail' => $this->pers_email,
                                        'Phone' => $this->phone,
                                        'EducationLevel' => $this->highest_ed,
                                        'IntendedProgramStart' => $this->program_start,
                                        'CurrentlyEmployed' => $this->cur_employed,
                                        'Concentration' => $this->concentration,
                                        'Employer' => $this->cur_employed_employer,
                                        'EmploymentLevel' => $this->cur_employed_status,
                                        'UnofficialTranscript1' => $this->transcript_1,
                                        'UnofficialTranscript2' => $this->transcript_2,
                                        'UnofficialTranscript3' => $this->transcript_3,
                                        'PersonalStatement' => $this->personal_stmt,
                                        'EnrollmentStatus' => $this->enroll_status,
                                        'ElectronicSignature' => $this->signature
                                    );
                    $result = $query->execute($input_data);
                    //var_dump($result);
                    //var_dump($conn->errorCode());
                    //var_dump($conn->errorInfo());
                    return $result;
            } catch (PDOException $e) {
                error_log( print_r("PDOException in IST_BAS::save - " . $e->getMessage(), true) );
            } catch (Exception $e) {
                error_log( print_r("General exception in IST_BAS::save - " . $e->getMessage(), true) );
            }
        }       
        return false;
    }

    //fill in data model fields using submitted form info
    public function build($_entry) {
        //set model info
        $this->first_name = !empty($_entry['1.3']) ? rgar($_entry, '1.3') : null;
        $this->last_name = !empty($_entry['1.6']) ? rgar($_entry, '1.6') : null;
        $this->sid = !empty($_entry['3']) ? rgar($_entry, '3') : null;
        $this->email = !empty($_entry['4']) ? rgar($_entry, '4') : null;
        $this->pers_email = !empty($_entry['61']) ? rgar($_entry, '61') : null;
        $this->phone = !empty($_entry['5']) ? rgar($_entry, '5') : null;
        $this->highest_ed = !empty($_entry['6']) ? rgar($_entry, '6') : null;

        if ( empty($_entry['67']) ) {
            $this->cur_employed = null;
        } else if ( !empty($_entry['67']) && strtolower(rgar($_entry, '67')) == "yes" ) {
            $this->cur_employed = true;
        } else {
            $this->cur_employed = false;
        }
        $this->cur_employed_status = !empty($_entry['69']) ? rgar($_entry, '69') : null;
        $this->cur_employed_employer = !empty($_entry['70']) ? rgar($_entry, '70') : null;

        $this->program_start = !empty($_entry['8']) ? rgar($_entry, '8') : null;
        $this->enroll_status = !empty($_entry['9']) ? rgar($_entry, '9') : null;
        $this->concentration = !empty($_entry['55']) ? rgar($_entry, '55') : null;
        $this->transcript_1 = !empty($_entry['14']) ? rgar($_entry, '14') : null;
        $this->transcript_2 = !empty($_entry['65']) ? rgar($_entry, '65') : null;
        $this->transcript_3 = !empty($_entry['66']) ? rgar($_entry, '66') : null;
        $this->personal_stmt = !empty($_entry['12']) ? rgar($_entry, '12') : null;
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
            rgar($_entry, 'payment_status'),
            rgar($_entry, 'payment_date'),
            null,
            null,
            null,
            rgar($_entry, '72.1'),
            rgar($_entry, '72.2'),
            rgar($_entry, '72.3'),
            rgar($_entry, '72.4'),
            rgar($_entry, '72.5')
        );
    }

    //return form id
	public function get_form_id(){
		return self::FORM_ID;
	}

}