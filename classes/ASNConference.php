<?php
require_once('DB.php');
require_once('Transaction.php');

class ASNConference
{
    protected $first_name;
    protected $last_name;
    protected $email;
    protected $phone;
    protected $applicant;
    protected $attending_type;
    protected $lunch_information;
    protected $food_allergy;
    protected $access_needs;
    protected $registration;
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
                $trans_id = null;            
                if (is_object($this->transaction) && (count(array($this->transaction)) > 0))
                { 
                    $result = $this->transaction->save();   //save transaction first because of db constraint on trans id
                    $trans_id = $this->transaction->get_id();
                }
                
                $tsql = 'EXEC [usp_InsertIntoASNConferenceForm]'
                            . '@TransID = :TransID,'
                            . '@Fname = :FirstName,'
                            . '@Lname = :LastName,'
                            . '@FormID = :FormID,'
                            . '@Email = :Email,'
                            . '@Phone = :Phone,'
                            . '@TypeofPerson = :ApplicantType,'
                            . '@LunchInformation = :LunchInformation,'
                            . '@FoodAllergy = :FoodAllergy,'
                            . '@AccessNeeds = :AccessNeeds,'                            
                            . '@RegistrationType = :Registration,'
                            . '@AttendingType = :AttendingType;'                          
                            ;                
                    $query = $conn->prepare( $tsql );                    
                    
                    $input_data = array(
                                        'TransID' => $trans_id, 
                                        'FirstName' => $this->first_name,
                                        'LastName' => $this->last_name, 
                                        'FormID' => $this->form_id,
                                        'Email' => $this->email,
                                        'Phone' => $this->phone,
                                        'ApplicantType' => $this->applicant,
                                        'LunchInformation' => $this->lunch_information,
                                        'FoodAllergy' => $this->food_allergy,
                                        'AccessNeeds' => $this->access_needs,
                                        'Registration' => $this->registration,
                                        'AttendingType' => $this->attending_type
                                    );
                    $result = $query->execute($input_data);
                    
                    //var_dump($result);                    
                   // var_dump($conn->errorCode());
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
    
    public function build($_entry) {           
        //set model info
        $this->first_name = !empty($_entry['14.3']) ? rgar($_entry, '14.3') : null;
        $this->last_name = !empty($_entry['14.6']) ? rgar($_entry, '14.6') : null;
        
        $this->email = !empty($_entry['16']) ? rgar($_entry, '16') : null;
        $this->phone = !empty($_entry['15']) ? rgar($_entry, '15') : null;
        $applicant_s1 = !empty($_entry['10.1']) ? rgar($_entry, '10.1') : null;
        $applicant_s2 = !empty($_entry['10.2']) ? rgar($_entry, '10.2') : null;
        $applicant_s3 = !empty($_entry['10.3']) ? rgar($_entry, '10.3') : null;
        $applicant_s4 = !empty($_entry['10.4']) ? rgar($_entry, '10.4') : null;
        $applicant_s5 = !empty($_entry['10.5']) ? rgar($_entry, '10.5') : null;
        $applicant_s6 = !empty($_entry['10.6']) ? rgar($_entry, '10.6') : null;
        $applicant_s7 = !empty($_entry['10.7']) ? rgar($_entry, '10.7') : null;
        $applicant_s8 = !empty($_entry['10.8']) ? rgar($_entry, '10.8') : null;
        $applicant_s9 = !empty($_entry['10.9']) ? rgar($_entry, '10.9') : null;
        
        $applicant_array = [$applicant_s1,$applicant_s2,$applicant_s3,$applicant_s4,$applicant_s5,$applicant_s6,$applicant_s7,$applicant_s8,$applicant_s9];
        $applicant_array = array_filter($applicant_array);
        $this->applicant = implode("$",$applicant_array );
        
        $this->attending_type = !empty($_entry['20']) ? rgar($_entry, '20') : null;
        
        $lunch_s1 = !empty($_entry['9.1']) ? rgar($_entry, '9.1') : null;
        $lunch_s2 = !empty($_entry['9.2']) ? rgar($_entry, '9.2') : null;
        $lunch_s3 = !empty($_entry['9.3']) ? rgar($_entry, '9.3') : null;
        $lunch_s4 = !empty($_entry['9.4']) ? rgar($_entry, '9.4') : null;
        
        $lunch_array = [$lunch_s1, $lunch_s2, $lunch_s3, $lunch_s4];
        $lunch_array = array_filter($lunch_array);
        $this->lunch_information = implode("$",$lunch_array );

        $this->food_allergy = !empty($_entry['5']) ? rgar($_entry, '5') : null;
        
        $this->access_needs = !empty($_entry['17']) ? rgar($_entry, '17') : null;
        
        $this->registration = !empty($_entry['18']) ? rgar($_entry, '18') : null;
      
        $this->form_id = rgar($_entry, 'form_id');
         //build transaction object
        if(!empty($_entry['transaction_id']))
        {
            $this->transaction = new Transaction(
                rgar($_entry, 'transaction_id'),
                $this->form_id,
                null,
                $this->first_name,
                $this->last_name,
                $this->email,
                rgar($_entry, 'payment_amount'),
                null,
                rgar($_entry, 'payment_date'),
                null,
                null,
                null,
                rgar($_entry, '23.1'),
                rgar($_entry, '23.2'),
                rgar($_entry, '23.3'),
                rgar($_entry, '23.4'),
                rgar($_entry, '23.5')
            );
           
        }
       
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

