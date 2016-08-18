<?php
require_once('DB.php');
require_once('Transaction.php');

class InteriorDesignBA
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
    const FORM_ID = 7;
    
    public function __construct() {

    }

    public function save() {
        $db = new DB();
        $conn = $db->getDB();
        var_dump($conn);
        if ( $conn ) {
            try {
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
                    var_dump($query);
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
                                        'FormID' => self::FORM_ID
                                    );
                    
                    $result = $query->execute($input_data);
                    //var_dump($result);
                    //var_dump($conn->errorCode());
                    //var_dump($conn->errorInfo());
                    $result = $this->transaction->save();
                    return $result;
            } catch (PDOException $e) {
                error_log( print_r("PDOException in InteriorDesignBA::save - " . $e->getMessage(), true) );
            } catch (Exception $e) {
                error_log( print_r("General exception in InteriorDesignBA::save - " . $e->getMessage(), true) );
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
        $this->phone = !empty($_entry['5']) ? rgar($_entry, '5') : null;
        $this->highest_ed = !empty($_entry['6']) ? rgar($_entry, '6') : null;
        $this->program_start = !empty($_entry['8']) ? rgar($_entry, '8') : null;
        $this->enroll_status = !empty($_entry['9']) ? rgar($_entry, '9') : null;
        $this->transcript_1 = !empty($_entry['14']) ? rgar($_entry, '14') : null;
        $this->transcript_2 = !empty($_entry['53']) ? rgar($_entry, '53') : null;
        $this->transcript_3 = !empty($_entry['55']) ? rgar($_entry, '55') : null;
        $this->portfolio = !empty($_entry['24']) ? rgar($_entry, '24') : null;
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
            'blah',
            rgar($_entry, '57.1'),
            rgar($_entry, '57.2'),
            rgar($_entry, '57.3'),
            rgar($_entry, '57.4'),
            rgar($_entry, '57.5')
        );
        //$this->trans_id = rgar($_entry, 'transaction_id');
    }

	public function get_first_name(){
		return $this->first_name;
	}

	public function set_first_name($_first_name){
		$this->first_name = $_first_name;
	}

	public function get_last_name(){
		return $this->last_name;
	}

	public function set_last_name($_last_name){
		$this->last_name = $_last_name;
	}

	public function get_sid(){
		return $this->sid;
	}

	public function set_sid($_sid){
		$this->sid = $_sid;
	}

	public function get_email(){
		return $this->email;
	}

	public function set_email($_email){
		$this->email = $_email;
	}

	public function get_phone(){
		return $this->phone;
	}

	public function set_phone($_phone){
		$this->phone = $_phone;
	}

	public function get_highest_ed(){
		return $this->highest_ed;
	}

	public function set_highest_ed($_highest_ed){
		$this->highest_ed = $_highest_ed;
	}

	public function get_program_start(){
		return $this->program_start;
	}

	public function set_program_start($_program_start){
		$this->program_start = $_program_start;
	}

	public function get_enroll_status(){
		return $this->enroll_status;
	}

	public function set_enroll_status($_enroll_status){
		$this->enroll_status = $_enroll_status;
	}

	public function get_transcript_1(){
		return $this->transcript_1;
	}

	public function set_transcript_1($_transcript_1){
		$this->transcript_1 = $_transcript_1;
	}

	public function get_transcript_2(){
		return $this->transcript_2;
	}

	public function set_transcript_2($_transcript_2){
		$this->transcript_2 = $_transcript_2;
	}

	public function get_transcript_3(){
		return $this->transcript_3;
	}

	public function set_transcript_3($_transcript_3){
		$this->transcript_3 = $_transcript_3;
	}

	public function get_portfolio(){
		return $this->portfolio;
	}

	public function set_portfolio($_portfolio){
		$this->portfolio = $_portfolio;
	}

	public function get_signature(){
		return $this->signature;
	}

	public function set_signature($_signature){
		$this->signature = $_signature;
	}

	public function get_transaction(){
		return $this->transaction;
	}

	public function set_transaction($_trans){
		$this->transaction = $_trans;
	}

	public function get_form_id(){
		return self::FORM_ID;
	}

}