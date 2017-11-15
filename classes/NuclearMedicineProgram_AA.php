<?php
require_once('DB.php');
require_once('Transaction.php');

class NuclearMedicineProgram_AA
{
    protected $first_name;
    protected $last_name;
    protected $sid;
    protected $email;
    protected $phone;
    protected $is_reapplicant;
    protected $year_last_applied;
    protected $acceptable_locations;
    protected $personal_stmt;
    protected $resume;    
    protected $unofficial_transcript_1;
    protected $unofficial_transcript_2;
    protected $unofficial_transcript_3;
    protected $unofficial_transcript_4;
    protected $unofficial_transcript_5;    
    protected $reference_letter;    
    protected $prerequisite;
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
                $tsql = 'EXEC [usp_InsertIntoNuclearMedicineForm]'
                            . '@SID = :SID,'
                            . '@Fname = :FirstName,'
                            . '@Lname = :LastName,'
                            . '@Phone = :Phone,'
                            . '@BCEmail = :Email,'                            
                            . '@ReApplicant = :IsReapplicant,'
                            . '@YearApplied = :YearLastApplied,'                        
                            . '@AcceptableLocations = :AcceptableLocations,'
                            . '@PersonalStatementUpload = :PersonalStatement,'
                            . '@Resume = :Resume,'
                            . '@ReferenceLetter = :ReferenceLetter,'
                            . '@UnofficialTrans1 = :UnofficialTranscript1,'
                            . '@UnofficialTrans2 = :UnofficialTranscript2,'
                            . '@UnofficialTrans3 = :UnofficialTranscript3,'
                            . '@UnofficialTrans4 = :UnofficialTranscript4,'
                            . '@UnofficialTrans5 = :UnofficialTranscript5,'
                            . '@PrerequisitesUpload = :Prerequisite,'
                            . '@TransID = :TransID,'
                            . '@FormID = :FormID,'
                            . '@ElectronicSignature = :ElectronicSignature;';
                
                    $query = $conn->prepare( $tsql );                   
                    $input_data = array( 
                                        'SID' => $this->sid,
                                        'FirstName' => $this->first_name,
                                        'LastName' => $this->last_name, 
                                        'Phone' => $this->phone,
                                        'Email' => $this->email,
                                        'IsReapplicant' => $this->is_reapplicant,
                                        'YearLastApplied' => $this->year_last_applied,
                                        'AcceptableLocations' => $this->acceptable_locations,
                                        'PersonalStatement' => $this->personal_stmt,
                                        'Resume' => $this->resume,
                                        'ReferenceLetter' => $this->reference_letter,
                                        
                                        'UnofficialTranscript1' => $this->unofficial_transcript_1,
                                        'UnofficialTranscript2' => $this->unofficial_transcript_2,
                                        'UnofficialTranscript3' => $this->unofficial_transcript_3,
                                        'UnofficialTranscript4' => $this->unofficial_transcript_4,
                                        'UnofficialTranscript5' => $this->unofficial_transcript_5,
                                       
                                        'Prerequisite' => $this->prerequisite,
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
                error_log( print_r("PDOException in NuclearMedicineProgram_AA::save - " . $e->getMessage(), true) );
            } catch (Exception $e) {
                error_log( print_r("General exception in NuclearMedicineProgram_AA::save - " . $e->getMessage(), true) );
            }
        }       
        return false;
    }

    //fill in data model fields using form information
    public function build($_entry) {        
        //set model info using entry values
        $this->first_name = !empty($_entry['2.3']) ? rgar($_entry, '2.3') : null;
        $this->last_name = !empty($_entry['2.6']) ? rgar($_entry, '2.6') : null;
        $this->sid = !empty($_entry['3']) ? rgar($_entry, '3') : null;
        $this->email = !empty($_entry['4']) ? rgar($_entry, '4') : null;
        $this->phone = !empty($_entry['5']) ? rgar($_entry, '5') : null;  
       
        if ( empty($_entry['18']) ) {
            $this->is_reapplicant = null;
        } else if ( !empty($_entry['18']) && strtolower(rgar($_entry, '18')) == "yes" ) {
            $this->is_reapplicant = true;
        } else {
            $this->is_reapplicant = false;
        }  
        $this->year_last_applied = !empty($_entry['46']) ? rgar($_entry, '46') : null;        
      
        $this->acceptable_locations = !empty($_entry['50.1']) ? rgar($_entry, '50.1') : ''; 
        if(!empty($_entry['50.2']))
        {
            if(strlen($this->acceptable_locations) > 0)
                 $this->acceptable_locations .= ','.rgar($_entry, '50.2');
            else
                 $this->acceptable_locations .= rgar($_entry, '50.2');                
        }
        
        if(!empty($_entry['50.3']))
        {
            if(strlen($this->acceptable_locations) > 0)
                 $this->acceptable_locations .= ','.rgar($_entry, '50.3');
            else
                 $this->acceptable_locations .= rgar($_entry, '50.3')  ;              
        }
      
        
        $this->personal_stmt = !empty($_entry['23']) ? rgar($_entry, '23') : null;
       
        $this->unofficial_transcript_1 = !empty($_entry['25']) ? rgar($_entry, '25') : null;
        $this->unofficial_transcript_2 = !empty($_entry['26']) ? rgar($_entry, '26') : null;
        $this->unofficial_transcript_3 = !empty($_entry['27']) ? rgar($_entry, '27') : null;
        $this->unofficial_transcript_4 = !empty($_entry['52']) ? rgar($_entry, '52') : null;
        $this->unofficial_transcript_5 = !empty($_entry['53']) ? rgar($_entry, '53') : null;
        $this->prerequisite = !empty($_entry['45']) ? rgar($_entry, '45') : null;
        $this->resume = !empty($_entry['31']) ? rgar($_entry, '31') : null;
        $this->reference_letter = !empty($_entry['48']) ? rgar($_entry, '48') : null;
        $this->signature = !empty($_entry['36']) ? rgar($_entry, '36') : null;
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
            rgar($_entry, '42.1'),
            rgar($_entry, '42.2'),
            rgar($_entry, '42.3'),
            rgar($_entry, '42.4'),
            rgar($_entry, '42.5')
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