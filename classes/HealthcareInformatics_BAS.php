<?php
require_once( 'DB.php' );
require_once( 'Transaction.php' );

class HealthcareInformatics_BAS {

	protected $first_name;
	protected $last_name;
	protected $sid;
	protected $emplid;
	protected $email;
	protected $phone;
	protected $enroll_status;
	protected $prerequisite;
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

	//save data model
	public function save() {
		$db   = new DB();
		$conn = $db->getDB();

		if ( $conn ) {
			try {
				$result = $this->transaction->save();   //save transaction first because of db constraint on trans id
				$tsql   = 'EXEC [usp_InsertIntoHealthCareInformaticsForm]'
							. '@SID = :SID,'
							. '@EMPLID = :EMPLID,'
							. '@Fname = :FirstName,'
							. '@Lname = :LastName,'
							. '@Phone = :Phone,'
							. '@BCEmail = :Email,'
							. '@EnrollmentStatus = :EnrollmentStatus,'

							. '@Prerequisite = :Prerequisite,'
							. '@PersonalStatement = :PersonalStatement,'
							. '@TransID = :TransID,'
							. '@FormID = :FormID,'
							. '@ElectronicSignature = :ElectronicSignature,'
							. '@UnofficialTranscript1 = :UnofficialTranscript1,'
							. '@UnofficialTranscript2 = :UnofficialTranscript2,'
							. '@UnofficialTranscript3 = :UnofficialTranscript3;';
					$query = $conn->prepare( $tsql );

					$input_data = array(
						'SID'                   => $this->sid,
						'EMPLID'                => $this->emplid,
						'FirstName'             => $this->first_name,
						'LastName'              => $this->last_name,
						'Phone'                 => $this->phone,
						'Email'                 => $this->email,
						'EnrollmentStatus'      => $this->enroll_status,

						'Prerequisite'          => $this->prerequisite,
						'PersonalStatement'     => $this->personal_stmt,
						'UnofficialTranscript1' => $this->transcript_1,
						'UnofficialTranscript2' => $this->transcript_2,
						'UnofficialTranscript3' => $this->transcript_3,
						'TransID'               => $this->transaction->get_id(),
						'FormID'                => $this->form_id,
						'ElectronicSignature'   => $this->signature,
					);

					$result = $query->execute( $input_data );
					//var_dump($result);
					//var_dump($conn->errorCode());
					//var_dump($conn->errorInfo());
					return $result;
			} catch ( PDOException $e ) {
				error_log( print_r( 'PDOException in HealthcareInformatics_BAS::save - ' . $e->getMessage(), true ) );
			} catch ( Exception $e ) {
				error_log( print_r( 'General exception in HealthcareInformatics_BAS::save - ' . $e->getMessage(), true ) );
			}
		}
		return false;
	}

	//fill in data model fields using form information
	public function build( $_entry ) {
		//set model info using entry values
		$this->first_name    = ! empty( $_entry['1.3'] ) ? rgar( $_entry, '1.3' ) : null;
		$this->last_name     = ! empty( $_entry['1.6'] ) ? rgar( $_entry, '1.6' ) : null;
		$this->sid           = ! empty( $_entry['3'] ) ? rgar( $_entry, '3' ) : null;
		$this->emplid        = ! empty( $_entry['73'] ) ? rgar( $_entry, '73' ) : null;
		$this->email         = ! empty( $_entry['4'] ) ? rgar( $_entry, '4' ) : null;
		$this->phone         = ! empty( $_entry['5'] ) ? rgar( $_entry, '5' ) : null;
		$this->enroll_status = ! empty( $_entry['9'] ) ? rgar( $_entry, '9' ) : null;

		$this->prerequisite = ! empty( $_entry['72'] ) ? rgar( $_entry, '72' ) : null;
		$this->transcript_1 = ! empty( $_entry['68'] ) ? rgar( $_entry, '68' ) : null;
		$this->transcript_2 = ! empty( $_entry['69'] ) ? rgar( $_entry, '69' ) : null;
		$this->transcript_3 = ! empty( $_entry['70'] ) ? rgar( $_entry, '70' ) : null;

		$this->personal_stmt = ! empty( $_entry['67'] ) ? rgar( $_entry, '67' ) : null;
		$this->signature     = ! empty( $_entry['23'] ) ? rgar( $_entry, '23' ) : null;
		$this->form_id       = rgar( $_entry, 'form_id' );

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
			rgar( $_entry, '66.1' ),
			rgar( $_entry, '66.2' ),
			rgar( $_entry, '66.3' ),
			rgar( $_entry, '66.4' ),
			rgar( $_entry, '66.5' )
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
