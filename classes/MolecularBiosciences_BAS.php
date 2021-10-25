<?php
require_once( 'DB.php' );
require_once( 'Transaction.php' );

class MolecularBiosciences_BAS {

	protected $first_name;
	protected $last_name;
	protected $sid;
	protected $emplid;
	protected $email;
	protected $phone;
	protected $is_reapplicant;
	protected $application_period;
	protected $enroll_status;

	protected $assoc_completed;
	protected $assoc_school_name;
	protected $assoc_yq;
	protected $which_degree_bc;
	protected $lower_coursework;

	protected $personal_stmt;
	protected $diversity_stmt;

	protected $transcript;

	protected $signature;
	protected $transaction;
	protected $form_id;

	//public constructor
	public function __construct() {

	}

	//save data model to external db
	public function save() {
		$db   = new DB();
		$conn = $db->getDB();

		if ( $conn ) {
			try {
				$result = $this->transaction->save();   //save transaction first because of fk constraint in db
				$tsql   = 'EXEC [usp_InsertIntoMolecularBiosciencesForm]'
							. '@SID = :SID,'
							. '@EMPLID = :EMPLID,'
							. '@Fname = :FirstName,'
							. '@Lname = :LastName,'
							. '@Phone = :Phone,'
							. '@Email = :Email,'
							. '@IsReapplicant = :IsReapplicant,'
							. '@ApplicationPeriod = :ApplicationPeriod,'
							. '@EnrollmentStatus = :EnrollmentStatus,'

							. '@AssociatesCompleted = :AssocCompleted,'
							. '@AssociatesSchoolName = :AssocSchoolName,'
							. '@AssociatesYQ = :AssocYQ,'
							. '@WhichDegreeBC = :WhichDegreeBC,'
							. '@LLCourseWork = :LowerCoursework,'

							. '@PersonalStatement = :PersonalStatement,'
							. '@DiversityStatement = :DiversityStatement,'

							. '@UnofficialTranscript = :UnofficialTranscript,'

							. '@TransID = :TransID,'
							. '@FormID = :FormID,'
							. '@ElectronicSignature = :ElectronicSignature;';
					$query      = $conn->prepare( $tsql );
					$input_data = array(
						'FirstName'            => $this->first_name,
						'LastName'             => $this->last_name,
						'SID'                  => $this->sid,
						'EMPLID'               => $this->emplid,
						'Email'                => $this->email,
						'Phone'                => $this->phone,
						'IsReapplicant'        => $this->is_reapplicant,
						'ApplicationPeriod'    => $this->application_period,
						'EnrollmentStatus'     => $this->enroll_status,

						'AssocCompleted'       => $this->assoc_completed,
						'AssocSchoolName'      => $this->assoc_school_name,
						'AssocYQ'              => $this->assoc_yq,
						'WhichDegreeBC'        => $this->which_degree_bc,
						'LowerCoursework'      => $this->lower_coursework,

						'PersonalStatement'    => $this->personal_stmt,
						'DiversityStatement'   => $this->diversity_stmt,

						'UnofficialTranscript' => $this->transcript,

						'TransID'              => $this->transaction->get_id(),
						'FormID'               => $this->form_id,
						'ElectronicSignature'  => $this->signature,
					);

					$result = $query->execute( $input_data );
					//                    var_dump($input_data);
					//                    var_dump($result);
					//                    var_dump($conn->errorCode());
					//                    var_dump($conn->errorInfo());
					return $result;
			} catch ( PDOException $e ) {
				error_log( print_r( 'PDOException in MolecularBiosciences_BAS::save - ' . $e->getMessage(), true ) );
			} catch ( Exception $e ) {
				error_log( print_r( 'General exception in MolecularBiosciences_BAS::save - ' . $e->getMessage(), true ) );
			}
		}
		return false;
	}

	//fill in data model fields using submitted form info
	public function build( $_entry ) {
		//set model info using entry values
		$this->first_name = ! empty( $_entry['1.3'] ) ? rgar( $_entry, '1.3' ) : null;
		$this->last_name  = ! empty( $_entry['1.6'] ) ? rgar( $_entry, '1.6' ) : null;
		$this->sid        = ! empty( $_entry['3'] ) ? rgar( $_entry, '3' ) : null;
		$this->emplid     = ! empty( $_entry['131'] ) ? rgar( $_entry, '131' ) : null;
		$this->email      = ! empty( $_entry['4'] ) ? rgar( $_entry, '4' ) : null;
		$this->phone      = ! empty( $_entry['5'] ) ? rgar( $_entry, '5' ) : null;

		if ( empty( $_entry['24'] ) ) {
			$this->is_reapplicant = null;
		} elseif ( ! empty( $_entry['24'] ) && strtolower( rgar( $_entry, '24' ) ) == 'yes' ) {
			$this->is_reapplicant = true;
		} else {
			$this->is_reapplicant = false;
		}

		$this->application_period = ! empty( $_entry['121'] ) ? rgar( $_entry, '121' ) : null;
		$this->enroll_status      = ! empty( $_entry['122'] ) ? rgar( $_entry, '122' ) : null;

		$this->assoc_completed = ! empty( $_entry['123'] ) ? rgar( $_entry, '123' ) : null;

		//Conditional Options
		$this->assoc_school_name = ! empty( $_entry['28'] ) ? rgar( $_entry, '28' ) : null;
		$this->assoc_yq          = ! empty( $_entry['124'] ) ? rgar( $_entry, '124' ) : null;
		$this->which_degree_bc   = ! empty( $_entry['125'] ) ? rgar( $_entry, '125' ) : null;

		$this->lower_coursework = ! empty( $_entry['127'] ) ? rgar( $_entry, '127' ) : null;
		$this->transcript       = ! empty( $_entry['128'] ) ? rgar( $_entry, '128' ) : null;

		$this->personal_stmt  = ! empty( $_entry['129'] ) ? rgar( $_entry, '129' ) : null;
		$this->diversity_stmt = ! empty( $_entry['130'] ) ? rgar( $_entry, '130' ) : null;

		$this->signature = ! empty( $_entry['23'] ) ? rgar( $_entry, '23' ) : null;
		$this->form_id   = rgar( $_entry, 'form_id' );

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
			rgar( $_entry, '117.1' ),
			rgar( $_entry, '117.2' ),
			rgar( $_entry, '117.3' ),
			rgar( $_entry, '117.4' ),
			rgar( $_entry, '117.5' )
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
