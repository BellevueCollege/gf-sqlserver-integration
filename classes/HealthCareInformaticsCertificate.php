<?php
require_once( 'DB.php' );
require_once( 'Transaction.php' );

class HealthCareInformaticsCertificate {

	protected $first_name;
	protected $last_name;
	protected $sid;
	protected $emplid;
	protected $email;
	protected $phone;
	protected $enroll_status;

	protected $transcript_1;
	protected $transcript_2;
	protected $transcript_3;
	protected $prerequisite;
	protected $personal_stmt;
	protected $signature;
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
				$tsql   = 'EXEC [usp_InsertIntoCertHealthCareInformaticsForm]'
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
							. '@electronicSignature = :ElectronicSignature,'
							. '@Prerequisite = :Prerequisite,'
							. '@PersonalStatement = :PersonalStatement,'
							. '@TransID = :TransID,'

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
						'PersonalStatement'     => $this->personal_stmt,
						'TransID'               => $this->transaction->get_id(),
						'ElectronicSignature'   => $this->signature,
						'FormID'                => $this->form_id,
					);
					$result     = $query->execute( $input_data );
					//var_dump($result);
					//var_dump($conn->errorCode());
					//var_dump($conn->errorInfo());
					return $result;
			} catch ( PDOException $e ) {
				error_log( print_r( 'PDOException in HealthCareInformaticsCertificate::save - ' . $e->getMessage(), true ) );
			} catch ( Exception $e ) {
				error_log( print_r( 'General exception in HealthCareInformaticsCertificate::save - ' . $e->getMessage(), true ) );
			}
		}
		return false;
	}

	//fill in data model fields using form information
	public function build( $_entry ) {
		//var_dump($_entry);
		//set model info using entry values
		$this->first_name    = ! empty( $_entry['2.3'] ) ? rgar( $_entry, '2.3' ) : null;
		$this->last_name     = ! empty( $_entry['2.6'] ) ? rgar( $_entry, '2.6' ) : null;
		$this->sid           = ! empty( $_entry['3'] ) ? rgar( $_entry, '3' ) : null;
		$this->emplid        = ! empty( $_entry['46'] ) ? rgar( $_entry, '46' ) : null;
		$this->email         = ! empty( $_entry['4'] ) ? rgar( $_entry, '4' ) : null;
		$this->phone         = ! empty( $_entry['5'] ) ? rgar( $_entry, '5' ) : null;
		$this->enroll_status = ! empty( $_entry['7'] ) ? rgar( $_entry, '7' ) : null;

		$this->transcript_1 = ! empty( $_entry['41'] ) ? rgar( $_entry, '41' ) : null;
		$this->transcript_2 = ! empty( $_entry['42'] ) ? rgar( $_entry, '42' ) : null;
		$this->transcript_3 = ! empty( $_entry['43'] ) ? rgar( $_entry, '43' ) : null;

		$this->personal_stmt = ! empty( $_entry['29'] ) ? rgar( $_entry, '29' ) : null;

		$this->prerequisite = ! empty( $_entry['37'] ) ? rgar( $_entry, '37' ) : null;
		$this->signature    = ! empty( $_entry['45'] ) ? rgar( $_entry, '45' ) : null;
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
			rgar( $_entry, '35.1' ),
			rgar( $_entry, '35.2' ),
			rgar( $_entry, '35.3' ),
			rgar( $_entry, '35.4' ),
			rgar( $_entry, '35.5' )
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

