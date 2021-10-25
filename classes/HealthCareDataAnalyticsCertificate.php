<?php
require_once( 'DB.php' );
require_once( 'Transaction.php' );

class HealthCareDataAnalyticsCertificate {

	protected $first_name;
	protected $last_name;
	protected $sid;
	protected $emplid;
	protected $email;
	protected $phone;
	protected $enroll_status;
	protected $resume;

	protected $transcript_1;
	protected $transcript_2;
	protected $transcript_3;
	protected $prerequisite;
	protected $signature;
	protected $personal_stmt;
	protected $transaction;
	protected $form_id;

	//public constructor
	public function __construct() {

	}

	//save data model
	public function save() {
		$db   = new DB();
		$conn = $db->getDB();
		if ( $conn ) {
			try {
				$result = $this->transaction->save();   //save transaction first because of db constraint on trans id
				$tsql   = 'EXEC [usp_InsertIntoCertHealthCareDataAnalyticsForm]'
							. '@SID = :SID,'
							. '@EMPLID = :EMPLID,'
							. '@Fname = :FirstName,'
							. '@Lname = :LastName,'
							. '@Phone = :Phone,'
							. '@BCEmail = :Email,'
							. '@EnrollmentStatus = :EnrollmentStatus,'

							. '@UnofficialTranscript1 = :UnofficialTranscript1,'
							. '@UnofficialTranscript2 = :UnofficialTranscript2,'
							. '@UnofficialTranscript3 = :UnofficialTranscript3,'
							. '@Prerequisite = :Prerequisite,'
							. '@Resume = :Resume,'
							. '@PersonalStatement = :PersonalStatement,'
							. '@TransID = :TransID,'
							. '@ElectronicSignature = :ElectronicSignature,'
							. '@FormID = :FormID;';
					$query = $conn->prepare( $tsql );

					$input_data = array(
						'SID'                   => $this->sid,
						'EMPLID'                => $this->emplid,
						'FirstName'             => $this->first_name,
						'LastName'              => $this->last_name,
						'Phone'                 => $this->phone,
						'Email'                 => $this->email,
						'EnrollmentStatus'      => $this->enroll_status,

						'UnofficialTranscript1' => $this->transcript_1,
						'UnofficialTranscript2' => $this->transcript_2,
						'UnofficialTranscript3' => $this->transcript_3,
						'Prerequisite'          => $this->prerequisite,
						'Resume'                => $this->resume,
						'PersonalStatement'     => $this->personal_stmt,
						'TransID'               => $this->transaction->get_id(),
						'FormID'                => $this->form_id,
						'ElectronicSignature'   => $this->signature,
					);
					$result     = $query->execute( $input_data );
					//error_log("input data :".print_r($input_data,true));
					//var_dump($result);
					//var_dump($conn->errorCode());
					//var_dump($conn->errorInfo());
					return $result;
			} catch ( PDOException $e ) {
				error_log( print_r( 'PDOException in HealthCareDataAnalyticsCertificate::save - ' . $e->getMessage(), true ) );
			} catch ( Exception $e ) {
				error_log( print_r( 'General exception in HealthCareDataAnalyticsCertificate::save - ' . $e->getMessage(), true ) );
			}
		}
		return false;
	}

	//fill in data model fields using form information
	public function build( $_entry ) {
		//var_dump($_entry);
		//error_log(print_r($_entry,true));
		//set model info using entry values
		$this->first_name    = ! empty( $_entry['1.3'] ) ? rgar( $_entry, '1.3' ) : null;
		$this->last_name     = ! empty( $_entry['1.6'] ) ? rgar( $_entry, '1.6' ) : null;
		$this->sid           = ! empty( $_entry['2'] ) ? rgar( $_entry, '2' ) : null;
		$this->emplid        = ! empty( $_entry['48'] ) ? rgar( $_entry, '48' ) : null;
		$this->email         = ! empty( $_entry['3'] ) ? rgar( $_entry, '3' ) : null;
		$this->phone         = ! empty( $_entry['4'] ) ? rgar( $_entry, '4' ) : null;
		$this->enroll_status = ! empty( $_entry['6'] ) ? rgar( $_entry, '6' ) : null;

		$this->transcript_1  = ! empty( $_entry['44'] ) ? rgar( $_entry, '44' ) : null;
		$this->transcript_2  = ! empty( $_entry['45'] ) ? rgar( $_entry, '45' ) : null;
		$this->transcript_3  = ! empty( $_entry['46'] ) ? rgar( $_entry, '46' ) : null;
		$this->resume        = ! empty( $_entry['28'] ) ? rgar( $_entry, '28' ) : null;
		$this->personal_stmt = ! empty( $_entry['30'] ) ? rgar( $_entry, '30' ) : null;

		$this->prerequisite = ! empty( $_entry['42'] ) ? rgar( $_entry, '42' ) : null;
		$this->signature    = ! empty( $_entry['41'] ) ? rgar( $_entry, '41' ) : null;
		$this->form_id      = rgar( $_entry, 'form_id' );

		//build transaction object
		$this->transaction = new Transaction(
			rgar( $_entry, 'transaction_id' ),
			$this->form_id,
			$this->sid,
			$this->emplid,
			$this->first_name,
			$this->last_name,
			$this->email,
			rgar( $_entry, 'payment_amount' ),
			null,
			rgar( $_entry, 'payment_date' ),
			null,
			null,
			null,
			rgar( $_entry, '37.1' ),
			rgar( $_entry, '37.2' ),
			rgar( $_entry, '37.3' ),
			rgar( $_entry, '37.4' ),
			rgar( $_entry, '37.5' )
		);
	}

	//return transaction
	public function get_transaction() {
		return $this->transaction;
	}

	//return form ID
	public function get_form_id() {
		return $this->form_id;
	}

}

