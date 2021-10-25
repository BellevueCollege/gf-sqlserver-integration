<?php
require_once( 'DB.php' );
require_once( 'Transaction.php' );

class DiagnosticUltrasoundTechnologyProgram_AA {

	protected $first_name;
	protected $last_name;
	protected $sid;
	protected $emplid;
	protected $bc_email;
	protected $personal_email;
	protected $phone;
	protected $is_reapplicant;
	protected $year_last_applied;
	protected $information_session;
	protected $information_session_date;
	protected $concentration;
	protected $prerequisite_upload;
	protected $prerequisite_equ_worksheet;
	protected $unofficial_transcript_1;
	protected $unofficial_transcript_2;
	protected $unofficial_transcript_3;
	protected $unofficial_transcript_4;
	protected $supplemental_prerequisite_doc;
	protected $personal_stmt;
	protected $resume;
	protected $patientcare_volunteering_form;
	protected $cna_training_certificate;
	protected $additional_exp_doc;
	protected $head_shot_photo;
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
				$tsql   = 'EXEC [usp_InsertIntoDiagnosticUltrasoundTechnologyForm]'
							. '@SID = :SID,'
							. '@EMPLID = :EMPLID,'
							. '@Fname = :FirstName,'
							. '@Lname = :LastName,'
							. '@Phone = :Phone,'
							. '@BCEmail = :Email,'
							. '@PersonalEmail = :PersonalEmail,'
							. '@ReApplicant = :IsReapplicant,'
							. '@YearsApplied = :YearLastApplied,'
							. '@InformationSession = :InformationSession,'
							. '@InformationSessionDate = :InformationSessionDate,'
							. '@Concentration = :Concentration,'
							. '@PrerequisitesUpload = :PrerequisitesUpload,'
							. '@PrerequisiteEquWorksheet = :PrerequisiteEquWorksheet,'
							. '@UnofficialTrans1 = :UnofficialTranscript1,'
							. '@UnofficialTrans2 = :UnofficialTranscript2,'
							. '@UnofficialTrans3 = :UnofficialTranscript3,'
							. '@UnofficialTrans4 = :UnofficialTranscript4,'
							. '@SupplementalPrerequisiteDoc = :SupplementalPrerequisiteDoc,'
							. '@PersonalStatementUpload = :PersonalStatement,'
							. '@Resume = :Resume,'
							. '@PatientCareVolunteeringForm = :PatientCareVolunteeringForm,'
							. '@CNATrainingCertificateExamResults = :CNATrainingCertificateExamResults,'
							. '@AdditionalExpDoc = :AdditionalExpDoc,'
							. '@HeadShotPhoto = :HeadShotPhoto,'
							. '@TransID = :TransID,'
							. '@FormID = :FormID,'
							. '@ElectronicSignature = :ElectronicSignature;';

					$query      = $conn->prepare( $tsql );
					$input_data = array(
						'SID'                         => $this->sid,
						'EMPLID'                      => $this->emplid,
						'FirstName'                   => $this->first_name,
						'LastName'                    => $this->last_name,
						'Phone'                       => $this->phone,
						'Email'                       => $this->email,
						'PersonalEmail'               => $this->personal_email,
						'IsReapplicant'               => $this->is_reapplicant,
						'YearLastApplied'             => $this->year_last_applied,
						'InformationSession'          => $this->information_session,
						'InformationSessionDate'      => $this->information_session_date,
						'Concentration'               => $this->concentration,
						'PrerequisitesUpload'         => $this->prerequisite_upload,
						'PrerequisiteEquWorksheet'    => $this->prerequisite_equ_worksheet,
						'UnofficialTranscript1'       => $this->unofficial_transcript_1,
						'UnofficialTranscript2'       => $this->unofficial_transcript_2,
						'UnofficialTranscript3'       => $this->unofficial_transcript_3,
						'UnofficialTranscript4'       => $this->unofficial_transcript_4,
						'SupplementalPrerequisiteDoc' => $this->supplemental_prerequisite_doc,
						'PersonalStatement'           => $this->personal_stmt,
						'Resume'                      => $this->resume,
						'PatientCareVolunteeringForm' => $this->patientcare_volunteering_form,
						'CNATrainingCertificateExamResults' => $this->cna_training_certificate,
						'AdditionalExpDoc'            => $this->additional_exp_doc,
						'HeadShotPhoto'               => $this->head_shot_photo,
						'TransID'                     => $this->transaction->get_id(),
						'FormID'                      => $this->form_id,
						'ElectronicSignature'         => $this->signature,
					);
					$result     = $query->execute( $input_data );
					//var_dump($result);
					//var_dump($conn->errorCode());
					//var_dump($conn->errorInfo());
					return $result;
			} catch ( PDOException $e ) {
				error_log( print_r( 'PDOException in DiagnosticUltrasoundTechnologyProgram_AA::save - ' . $e->getMessage(), true ) );
			} catch ( Exception $e ) {
				error_log( print_r( 'General exception in DiagnosticUltrasoundTechnologyProgram_AA::save - ' . $e->getMessage(), true ) );
			}
		}
		return false;
	}

	//fill in data model fields using form information
	public function build( $_entry ) {
		//set model info using entry values
		$this->first_name     = ! empty( $_entry['2.3'] ) ? rgar( $_entry, '2.3' ) : null;
		$this->last_name      = ! empty( $_entry['2.6'] ) ? rgar( $_entry, '2.6' ) : null;
		$this->sid            = ! empty( $_entry['3'] ) ? rgar( $_entry, '3' ) : null;
		$this->emplid         = ! empty( $_entry['64'] ) ? rgar( $_entry, '64' ) : null;
		$this->email          = ! empty( $_entry['58'] ) ? rgar( $_entry, '58' ) : null;
		$this->personal_email = ! empty( $_entry['4'] ) ? rgar( $_entry, '4' ) : null;
		$this->phone          = ! empty( $_entry['5'] ) ? rgar( $_entry, '5' ) : null;

		if ( empty( $_entry['18'] ) ) {
			$this->is_reapplicant = null;
		} elseif ( ! empty( $_entry['18'] ) && strtolower( rgar( $_entry, '18' ) ) == 'yes' ) {
			$this->is_reapplicant = true;
		} else {
			$this->is_reapplicant = false;
		}
		$this->year_last_applied = ! empty( $_entry['46'] ) ? rgar( $_entry, '46' ) : null;
		if ( empty( $_entry['51'] ) ) {
			$this->information_session = null;
		} elseif ( ! empty( $_entry['51'] ) && strtolower( rgar( $_entry, '51' ) ) == 'yes' ) {
			$this->information_session = true;
		} else {
			$this->information_session = false;
		}
		$this->information_session_date   = ! empty( $_entry['52'] ) ? rgar( $_entry, '52' ) : null;
		$this->concentration              = ! empty( $_entry['53'] ) ? rgar( $_entry, '53' ) : null;
		$this->prerequisite_upload        = ! empty( $_entry['45'] ) ? rgar( $_entry, '45' ) : null;
		$this->prerequisite_equ_worksheet = ! empty( $_entry['45'] ) ? rgar( $_entry, '45' ) : null;

		$this->unofficial_transcript_1       = ! empty( $_entry['25'] ) ? rgar( $_entry, '25' ) : null;
		$this->unofficial_transcript_2       = ! empty( $_entry['26'] ) ? rgar( $_entry, '26' ) : null;
		$this->unofficial_transcript_3       = ! empty( $_entry['27'] ) ? rgar( $_entry, '27' ) : null;
		$this->unofficial_transcript_4       = ! empty( $_entry['28'] ) ? rgar( $_entry, '28' ) : null;
		$this->supplemental_prerequisite_doc = ! empty( $_entry['56'] ) ? rgar( $_entry, '56' ) : null;
		 $this->personal_stmt                = ! empty( $_entry['23'] ) ? rgar( $_entry, '23' ) : null;

		$this->resume                        = ! empty( $_entry['31'] ) ? rgar( $_entry, '31' ) : null;
		$this->patientcare_volunteering_form = ! empty( $_entry['55'] ) ? rgar( $_entry, '55' ) : null;
		$this->cna_training_certificate      = ! empty( $_entry['57'] ) ? rgar( $_entry, '57' ) : null;
		$this->additional_exp_doc            = ! empty( $_entry['60'] ) ? rgar( $_entry, '60' ) : null;
		$this->head_shot_photo               = ! empty( $_entry['61'] ) ? rgar( $_entry, '61' ) : null;
		$this->signature                     = ! empty( $_entry['36'] ) ? rgar( $_entry, '36' ) : null;
		$this->form_id                       = rgar( $_entry, 'form_id' );

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
			rgar( $_entry, '42.1' ),
			rgar( $_entry, '42.2' ),
			rgar( $_entry, '42.3' ),
			rgar( $_entry, '42.4' ),
			rgar( $_entry, '42.5' )
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
