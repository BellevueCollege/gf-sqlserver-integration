<?php
require_once('DB.php');
require_once('Transaction.php');

class DataAnalytics_BAS
{
    protected $first_name;
    protected $last_name;
    protected $sid;
    protected $email;
    protected $personal_email;
    protected $phone;
    protected $highest_ed;
    protected $program_start;
    protected $enroll_status;
    protected $transcript_1;
    protected $transcript_2;
    protected $transcript_3;
    protected $personal_stmt;
    protected $signature;
    protected $transaction;
    const FORM_ID = 9;  //as set in SQL Server forms table
    
    public function __construct() {

    }

    public function save() {
        $db = new DB();
        $conn = $db->getDB();
        //var_dump($conn);
        //echo "<pre>Input encoding: " . mb_detect_encoding($this->first_name) . "</pre>";
        //echo "<pre>Textarea encoding: " . mb_detect_encoding($this->personal_stmt) . "</pre>";
        if ( $conn ) {
            try {
                $result = $this->transaction->save();   //save transaction first because of db constraint on trans id
                $tsql = 'EXEC [usp_InsertIntoDataAnalyticsForm]'
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
                            . '@UnofficialTrans1 = :UnofficialTranscript1,'
                            . '@UnofficialTrans2 = :UnofficialTranscript2,'
                            . '@UnofficialTrans3 = :UnofficialTranscript3,'
                            . '@PersonalStatement = :PersonalStatement,'
                            . '@EnrollmentStatus = :EnrollmentStatus,'
                            . '@ElectronicSignature = :ElectronicSignature;';
                    $query = $conn->prepare( $tsql );
                    //var_dump($query);
                    $input_data = array( 
                                        'TransID' => $this->transaction->get_id(), 
                                        'FirstName' => $this->first_name,
                                        'LastName' => $this->last_name, 
                                        'FormID' => self::FORM_ID,
                                        'SID' => $this->sid,
                                        'BCEmail' => $this->email,
                                        'PersonalEmail' => $this->personal_email,
                                        'Phone' => $this->phone,
                                        'EducationLevel' => $this->highest_ed,
                                        'IntendedProgramStart' => $this->program_start,
                                        'UnofficialTranscript1' => $this->transcript_1,
                                        'UnofficialTranscript2' => $this->transcript_2,
                                        'UnofficialTranscript3' => $this->transcript_3,
                                        'PersonalStatement' => $this->personal_stmt,
                                        'EnrollmentStatus' => $this->enroll_status,
                                        'ElectronicSignature' => $this->signature
                                    );
                    /*echo '<pre>';
                    var_dump($input_data);
                    echo '</pre>';*/
                    $result = $query->execute($input_data);
                    //var_dump($result);
                    //var_dump($conn->errorCode());
                    //var_dump($conn->errorInfo());
                    //$result = $this->transaction->save();
                    return $result;
            } catch (PDOException $e) {
                error_log( print_r("PDOException in DataAnalytics_BAS::save - " . $e->getMessage(), true) );
            } catch (Exception $e) {
                error_log( print_r("General exception in DataAnalytics_BAS::save - " . $e->getMessage(), true) );
            }
        }       
        return false;
    }

    public function build($_entry) {
        //set model info
        $this->first_name = !empty($_entry['1.3']) ? rgar($_entry, '1.3') : null;
        $this->last_name = !empty($_entry['1.6']) ? rgar($_entry, '1.6') : null;
        $this->sid = !empty($_entry['3']) ? rgar($_entry, '3') : null;
        $this->email = !empty($_entry['4']) ? rgar($_entry, '4') : null;
        $this->personal_email = !empty($_entry['54']) ? rgar($_entry, '54') : null;
        $this->phone = !empty($_entry['5']) ? rgar($_entry, '5') : null;
        $this->highest_ed = !empty($_entry['6']) ? rgar($_entry, '6') : null;
        $this->program_start = !empty($_entry['8']) ? rgar($_entry, '8') : null;
        $this->enroll_status = !empty($_entry['9']) ? rgar($_entry, '9') : null;
        $this->transcript_1 = !empty($_entry['14']) ? rgar($_entry, '14') : null;
        $this->transcript_2 = !empty($_entry['56']) ? rgar($_entry, '56') : null;
        $this->transcript_3 = !empty($_entry['57']) ? rgar($_entry, '57') : null;
        $this->personal_stmt = !empty($_entry['12']) ? rgar($_entry, '12') : null;
        $this->signature = !empty($_entry['23']) ? rgar($_entry, '23') : null;
        $this->transaction = new Transaction(
            rgar($_entry, 'transaction_id'),
            self::FORM_ID,
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
            rgar($_entry, '59.1'),
            rgar($_entry, '59.2'),
            rgar($_entry, '59.3'),
            rgar($_entry, '59.4'),
            rgar($_entry, '59.5')
        );
    }

	public function get_transaction(){
		return $this->transaction;
	}

	public function get_form_id(){
		return self::FORM_ID;
	}

}