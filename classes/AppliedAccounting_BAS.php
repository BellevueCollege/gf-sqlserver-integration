<?php
require_once('DB.php');
require_once('Transaction.php');

class AppliedAccounting_BAS
{
    protected $first_name;
    protected $last_name;
    protected $sid;
    protected $email;
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
    protected $form_id;
    
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
                $tsql = 'EXEC [usp_InsertIntoAppliedAccountingForm]'
                            . '@TransID = :TransID,'
                            . '@Fname = :FirstName,'
                            . '@Lname = :LastName,'
                            . '@FormID = :FormID,'
                            . '@SID = :SID,'
                            . '@Email = :Email,'
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
                                        'FormID' => $this->form_id,
                                        'SID' => $this->sid,
                                        'Email' => $this->email,
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
                    $result = $this->transaction->save();
                    return $result;
            } catch (PDOException $e) {
                error_log( print_r("PDOException in AppliedAccounting_BAS::save - " . $e->getMessage(), true) );
            } catch (Exception $e) {
                error_log( print_r("General exception in AppliedAccounting_BAS::save - " . $e->getMessage(), true) );
            }
        }       
        return false;
    }

    public function build($_entry) {
        //set model info using entry values
        $this->first_name = !empty($_entry['1.3']) ? rgar($_entry, '1.3') : null;
        $this->last_name = !empty($_entry['1.6']) ? rgar($_entry, '1.6') : null;
        $this->sid = !empty($_entry['3']) ? rgar($_entry, '3') : null;
        $this->email = !empty($_entry['4']) ? rgar($_entry, '4') : null;
        $this->phone = !empty($_entry['5']) ? rgar($_entry, '5') : null;
        $this->highest_ed = !empty($_entry['6']) ? rgar($_entry, '6') : null;
        $this->program_start = !empty($_entry['8']) ? rgar($_entry, '8') : null;
        $this->enroll_status = !empty($_entry['9']) ? rgar($_entry, '9') : null;
        $this->transcript_1 = !empty($_entry['14']) ? rgar($_entry, '14') : null;
        $this->transcript_2 = !empty($_entry['31']) ? rgar($_entry, '31') : null;
        $this->transcript_3 = !empty($_entry['32']) ? rgar($_entry, '32') : null;
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