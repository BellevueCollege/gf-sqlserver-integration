<?php

require_once('DB.php');

class Transaction
{
    //private $db;    //db connection
    protected $id;  //transaction id
    protected $form_id; //ID of form transaction belongs to
    protected $sid; //SID
    protected $first_name;  //first name
    protected $last_name;   //last name
    protected $email;   //email
    protected $amount;  //payment amount
    protected $status;  //payment status
    protected $authorization_date;  //authorization date of transaction
    protected $settlement_date;     //settlement date of transaction
    protected $billing_first_name;    //billing first name
    protected $billing_last_name;   //billing last name
    protected $billing_address_1;   //billing address line 1
    protected $billing_address_2;   //billing address line 2
    protected $billing_city;    //billing city
    protected $billing_state;   //billing state
    protected $billing_zip; //billing zip

    //public constructor
    public function __construct($_id, 
                                $_form_id, 
                                $_sid,
                                $_first_name,
                                $_last_name,
                                $_email,
                                $_amount,
                                $_status,
                                $_authorization_date,
                                $_settlement_date,
                                $_billing_first_name,
                                $_billing_last_name,
                                $_billing_address_1,
                                $_billing_address_2,
                                $_billing_city,
                                $_billing_state,
                                $_billing_zip) {

        $this->id = $_id;
        $this->form_id = $_form_id;
        $this->sid = $_sid;
        $this->first_name = $_first_name;
        $this->last_name = $_last_name;
        $this->email = $_email;
        $this->amount = $_amount;
        $this->status = !empty($_status) ? $_status : DEFAULT_PAYMENT_STATUS;
        $this->authorization_date = $_authorization_date;
        $this->settlement_date = $_settlement_date;
        $this->billing_first_name = $_billing_first_name;
        $this->billing_last_name = $_billing_last_name;
        $this->billing_address_1 = $_billing_address_1;
        $this->billing_address_2 = $_billing_address_2;
        $this->billing_city = $_billing_city;
        $this->billing_state = $_billing_state;
        $this->billing_zip = $_billing_zip;

    }	

    //save transaction info to external db
    public function save() {
        $db = new DB();
        $conn = $db->getDB();
        if ( $conn ) {
            try {
                //echo 'have transaction connection';
                $tsql = 'EXEC [usp_InsertTransactionDetails]'
                        . '@TranStatus = :TransactionStatus,'
                        . '@SettleTime = :SettlementTime,'
                        . '@TransID = :TransactionID,'
                        . '@Fname = :FirstName,'
                        . '@Lname = :LastName,'
                        . '@BillStreet1 = :BillingStreet1,'
                        . '@BillStreet2 = :BillingStreet2,'
                        . '@City = :City,'
                        . '@State = :State,'
                        . '@Zip = :Zip,'
                        . '@PayAmt = :PaymentAmount,'
                        . '@FormID = :FormID,'
                        . '@SID = :SID,'
                        . '@Email = :Email;';
                $query = $conn->prepare( $tsql );
                $input_data = array( 
                            'TransactionStatus' => $this->status,
                            'SettlementTime' => $this->settlement_date,
                            'TransactionID' => $this->id,
                            'FirstName' => $this->first_name,
                            'LastName' => $this->last_name,
                            'BillingStreet1' => $this->billing_address_1,
                            'BillingStreet2' => $this->billing_address_2,
                            'City' => $this->billing_city,
                            'State' => $this->billing_state,
                            'Zip' => $this->billing_zip,
                            'PaymentAmount' => $this->amount,
                            'FormID' => $this->form_id,
                            'SID' => $this->sid,
                            'Email' => $this->email
                        );

                $result = $query->execute($input_data);      
                //var_dump($result);
                //var_dump($conn->errorCode());
                //var_dump($conn->errorInfo());  
                return $result;
            } catch (PDOException $e){
                error_log( print_r("PDOException in Transaction::save - " . $e->getMessage(), true) );
            } catch (Exception $e) {
                error_log( print_r("General exception in Transaction::save - " . $e->getMessage(), true) );
            }
        }
        return false;
    }	

    public function get_id() {
        return $this->id;
    }
		
}