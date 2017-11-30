<?php

require_once('DB.php');
require_once('Transaction.php');

class NursingAssistantCertifiedProgram
{
    protected $first_name;
    protected $last_name;
    protected $sid;
    protected $email;
    protected $phone;
    protected $qtr_applied;
    protected $information_session_date;
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
                
                $tsql = 'EXEC [usp_InsertIntoNursingAssistantForm]'
                            . '@TransID = :TransID,'
                            . '@Fname = :FirstName,'
                            . '@Lname = :LastName,'
                            . '@Phone = :Phone,'
                            . '@FormID = :FormID,'
                            . '@SID = :SID,'
                            . '@QuarterApplying = :QuarterApplying,'
                            . '@DateAttendedInfoSession = :DateAttendedInfoSession,'
                            . '@BCEmail = :BCEmail;';
                $query = $conn->prepare( $tsql );
                    $input_data = array(
                                        'TransID' => $this->transaction->get_id(), 
                                        'FirstName' => $this->first_name,
                                        'LastName' => $this->last_name,
                                        'Phone' => $this->phone,
                                        'FormID' => $this->form_id,
                                        'SID' => $this->sid,                                        
                                        'QuarterApplying' => $this->qtr_applied,
                                        'DateAttendedInfoSession' => $this->information_session_date,
                                        'BCEmail' => $this->email
                                        );                    
                    $result = $query->execute($input_data);
                    
                    //var_dump($result);
                    //var_dump($conn->errorCode());
                    //var_dump($conn->errorInfo());
                    return $result;
            } catch (PDOException $e) {
                error_log( print_r("PDOException in NursingAssistantCertifiedProgram::save - " . $e->getMessage(), true) );
            } catch (Exception $e) {
                error_log( print_r("General exception in NursingAssistantCertifiedProgram::save - " . $e->getMessage(), true) );
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
       
        $this->phone = !empty($_entry['5']) ? rgar($_entry, '5') : null;
        $this->qtr_applied = !empty($_entry['8']) ? rgar($_entry, '8') : null;
        $this->information_session_date = !empty($_entry['42']) ? rgar($_entry, '42') : null;
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
    
    //return form id
	public function get_form_id(){
		return $this->form_id;
	}

}
                          

