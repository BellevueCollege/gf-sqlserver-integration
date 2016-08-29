<?php
require_once('DB.php');
require_once('Transaction.php');

class InteriorDesign_BA
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
    protected $portfolio;
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
                $tsql = 'EXEC [usp_InsertIntoBAInteriorDesignForm]'
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
                            . '@PortfolioFile = :PortfolioFile,'
                            . '@EnrollmentStatus = :EnrollmentStatus,'
                            . '@ElectronicSignature = :ElectronicSignature;';
                    $query = $conn->prepare( $tsql );
                    $input_data = array( 'SID' => $this->sid,
                                        'FirstName' => $this->first_name,
                                        'LastName' => $this->last_name, 
                                        'Email' => $this->email,
                                        'Phone' => $this->phone,
                                        'EducationLevel' => $this->highest_ed,
                                        'IntendedProgramStart' => $this->program_start,
                                        'EnrollmentStatus' => $this->enroll_status,
                                        'UnofficialTranscript1' => $this->transcript_1,
                                        'UnofficialTranscript2' => $this->transcript_2,
                                        'UnofficialTranscript3' => $this->transcript_3,
                                        'PortfolioFile' => $this->portfolio,
                                        'ElectronicSignature' => $this->signature,
                                        'TransID' => $this->transaction->get_id(),
                                        'FormID' => $this->form_id
                                    );
                    $result = $query->execute($input_data);
                    //var_dump($result);
                    //var_dump($conn->errorCode());
                    //var_dump($conn->errorInfo());
                    return $result;
            } catch (PDOException $e) {
                error_log( print_r("PDOException in InteriorDesignBA::save - " . $e->getMessage(), true) );
            } catch (Exception $e) {
                error_log( print_r("General exception in InteriorDesignBA::save - " . $e->getMessage(), true) );
            }
        }       
        return false;
    }

    //fill data model fields from submitted form info
    public function build($_entry) {
        //set model info
        $this->first_name = !empty($_entry['1.3']) ? rgar($_entry, '1.3') : null;
        $this->last_name = !empty($_entry['1.6']) ? rgar($_entry, '1.6') : null;
        $this->sid = !empty($_entry['3']) ? rgar($_entry, '3') : null;
        $this->email = !empty($_entry['4']) ? rgar($_entry, '4') : null;
        $this->phone = !empty($_entry['5']) ? rgar($_entry, '5') : null;
        $this->highest_ed = !empty($_entry['6']) ? rgar($_entry, '6') : null;
        $this->program_start = !empty($_entry['8']) ? rgar($_entry, '8') : null;
        $this->enroll_status = !empty($_entry['9']) ? rgar($_entry, '9') : null;
        $this->transcript_1 = !empty($_entry['14']) ? rgar($_entry, '14') : null;
        $this->transcript_2 = !empty($_entry['53']) ? rgar($_entry, '53') : null;
        $this->transcript_3 = !empty($_entry['55']) ? rgar($_entry, '55') : null;
        $this->portfolio = !empty($_entry['24']) ? rgar($_entry, '24') : null;
        $this->signature = !empty($_entry['23']) ? rgar($_entry, '23') : null;
        $this->form_id = rgar($_entry, 'form_id');

        //build transaction model
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
            rgar($_entry, '57.1'),
            rgar($_entry, '57.2'),
            rgar($_entry, '57.3'),
            rgar($_entry, '57.4'),
            rgar($_entry, '57.5')
        );
    }

    //get transaction object
	public function get_transaction(){
		return $this->transaction;
	}

    //return form id
	public function get_form_id(){
		return $this->form_id;
	}

}