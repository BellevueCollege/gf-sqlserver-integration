<?php
require_once('DB.php');
require_once('Transaction.php');

class HealthcarePromotion_BAS
{
    protected $first_name;
    protected $last_name;
    protected $sid;
    protected $email;
    protected $personal_email;
    protected $phone;
    protected $preferred_contact_method;
    protected $college_last_attended;
    protected $has_earned_associates;
    protected $transcript_1;
    protected $transcript_2;
    protected $transcript_3;
    protected $signature;
    protected $transaction;
    protected $form_id;
    
    public function __construct() {

    }

    public function save() {
        $db = new DB();
        $conn = $db->getDB();
        //echo "<pre>Input encoding: " . mb_detect_encoding($this->first_name) . "</pre>";
        //echo "<pre>Textarea encoding: " . mb_detect_encoding($this->personal_stmt) . "</pre>";
        if ( $conn ) {
            try {
                $result = $this->transaction->save();   //save transaction first because of db constraint on trans id
                $tsql = 'EXEC [usp_InsertIntoHealthcarePromoAndMngmtForm]'
                            . '@TransID = :TransID,'
                            . '@Fname = :FirstName,'
                            . '@Lname = :LastName,'
                            . '@FormID = :FormID,'
                            . '@SID = :SID,'
                            . '@BCEmail = :Email,'
                            . '@PersonalEmail = :PersonalEmail,'
                            . '@Phone = :Phone,'
                            . '@PreferredContactMethod = :PreferredContactMethod,'
                            . '@CollegeLastAttended = :CollegeLastAttended,'
                            . '@GetAssociateDegree = :GetAssociateDegree,'
                            . '@UnofficialTrans1 = :UnofficialTranscript1,'
                            . '@UnofficialTrans2 = :UnofficialTranscript2,'
                            . '@UnofficialTrans3 = :UnofficialTranscript3,'
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
                                        'PreferredContactMethod' => $this->preferred_contact_method,
                                        'CollegeLastAttended' => $this->college_last_attended,
                                        'GetAssociateDegree' => $this->has_earned_associates,
                                        'UnofficialTranscript1' => $this->transcript_1,
                                        'UnofficialTranscript2' => $this->transcript_2,
                                        'UnofficialTranscript3' => $this->transcript_3,
                                        'ElectronicSignature' => $this->signature
                                    );

                    $result = $query->execute($input_data);
                    //var_dump($result);
                    //var_dump($conn->errorCode());
                    //var_dump($conn->errorInfo());
                    return $result;
            } catch (PDOException $e) {
                error_log( print_r("PDOException in HealthcarePromotion_BAS::save - " . $e->getMessage(), true) );
            } catch (Exception $e) {
                error_log( print_r("General exception in HealthcarePromotion_BAS::save - " . $e->getMessage(), true) );
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
        $this->personal_email = !empty($_entry['37']) ? rgar($_entry, '37') : null;
        $this->phone = !empty($_entry['5']) ? rgar($_entry, '5') : null;
        $this->preferred_contact_method = !empty($_entry['24']) ? rgar($_entry, '24') : null;
        $this->college_last_attended = !empty($_entry['25']) ? rgar($_entry, '25') : null;

        if ( empty($_entry['27']) ) {
            $this->has_earned_associates = null;
        } else if ( !empty($_entry['27']) && strtolower(rgar($_entry, '27')) == "yes" ) {
            $this->has_earned_associates = true;
        } else {
            $this->has_earned_associates = false;
        }

        $this->transcript_1 = !empty($_entry['39']) ? rgar($_entry, '39') : null;
        $this->transcript_2 = !empty($_entry['40']) ? rgar($_entry, '40') : null;
        $this->transcript_3 = !empty($_entry['41']) ? rgar($_entry, '41') : null;
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
            rgar($_entry, '43.1'),
            rgar($_entry, '43.2'),
            rgar($_entry, '43.3'),
            rgar($_entry, '43.4'),
            rgar($_entry, '43.5')
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