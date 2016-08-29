<?php
require_once('DB.php');
require_once('Transaction.php');

class HealthcareManagement_BAS
{
    protected $first_name;
    protected $last_name;
    protected $sid;
    protected $email;
    protected $personal_email;
    protected $phone;
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

    //save data model info to SQL Server
    public function save() {
        $db = new DB();
        $conn = $db->getDB();
        //echo "<pre>Input encoding: " . mb_detect_encoding($this->first_name) . "</pre>";
        //echo "<pre>Textarea encoding: " . mb_detect_encoding($this->personal_stmt) . "</pre>";
        if ( $conn ) {
            try {
                $result = $this->transaction->save();   //save transaction first because of db constraint on trans id
                $tsql = 'EXEC [usp_InsertIntoHealthcareMngmtAndLeadershipForm]'
                            . '@TransID = :TransID,'
                            . '@Fname = :FirstName,'
                            . '@Lname = :LastName,'
                            . '@FormID = :FormID,'
                            . '@SID = :SID,'
                            . '@BCEmail = :Email,'
                            . '@PersonalEmail = :PersonalEmail,'
                            . '@Phone = :Phone,'
                            . '@EnrollmentStatus = :EnrollmentStatus,'
                            . '@Concentration = :Concentration,'
                            . '@UnofficialTrans1 = :UnofficialTranscript1,'
                            . '@UnofficialTrans2 = :UnofficialTranscript2,'
                            . '@UnofficialTrans3 = :UnofficialTranscript3,'
                            . '@PersonalStatement = :PersonalStatement,'
                            . '@ElectronicSignature = :ElectronicSignature;';
                    $query = $conn->prepare( $tsql );

                    $input_data = array( 
                                        'TransID' => $this->transaction->get_id(), 
                                        'FirstName' => $this->first_name,
                                        'LastName' => $this->last_name, 
                                        'FormID' => $this->form_id,
                                        'SID' => $this->sid,
                                        'Email' => $this->email,
                                        'PersonalEmail' => $this->personal_email,
                                        'Phone' => $this->phone,
                                        'EnrollmentStatus' => $this->enroll_status,
                                        'Concentration' => $this->concentration,
                                        'UnofficialTranscript1' => $this->transcript_1,
                                        'UnofficialTranscript2' => $this->transcript_2,
                                        'UnofficialTranscript3' => $this->transcript_3,
                                        'PersonalStatement' => $this->personal_stmt,
                                        'ElectronicSignature' => $this->signature
                                    );

                    $result = $query->execute($input_data);
                    //var_dump($result);
                    //var_dump($conn->errorCode());
                    //var_dump($conn->errorInfo());
                    return $result;
            } catch (PDOException $e) {
                error_log( print_r("PDOException in HealthcareManagement_BAS::save - " . $e->getMessage(), true) );
            } catch (Exception $e) {
                error_log( print_r("General exception in HealthcareManagement_BAS::save - " . $e->getMessage(), true) );
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
        $this->personal_email = !empty($_entry['68']) ? rgar($_entry, '68') : null;
        $this->phone = !empty($_entry['5']) ? rgar($_entry, '5') : null;
        $this->enroll_status = !empty($_entry['9']) ? rgar($_entry, '9') : null;
        $this->concentration = !empty($_entry['69']) ? rgar($_entry, '69') : null;
        $this->transcript_1 = !empty($_entry['74']) ? rgar($_entry, '74') : null;
        $this->transcript_2 = !empty($_entry['75']) ? rgar($_entry, '75') : null;
        $this->transcript_3 = !empty($_entry['76']) ? rgar($_entry, '76') : null;
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
            rgar($_entry, '77.1'),
            rgar($_entry, '77.2'),
            rgar($_entry, '77.3'),
            rgar($_entry, '77.4'),
            rgar($_entry, '77.5')
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