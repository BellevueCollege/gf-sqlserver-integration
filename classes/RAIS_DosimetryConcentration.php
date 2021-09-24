<?php
require_once( 'DB.php' );
require_once( 'Transaction.php' );

class RAIS_DosimetryConcentration {

	protected $first_name;
	protected $last_name;
	protected $sid;
	protected $emplid;
	protected $email;
	protected $phone;
	protected $applied_program;
	protected $college_university;
	protected $degree_earned;
	protected $year_graduated;
	protected $clinical_site;
	protected $name_of_site;
	protected $location_of_site;
	protected $have_national_certification;
	protected $certifying_organization;
	protected $anticipated_certificate;
	protected $anticipated_certificate_comp_date;

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

	//save data model to external db
	public function save() {
		$db   = new DB();
		$conn = $db->getDB();

		if ( $conn ) {
			try {
				$result = $this->transaction->save();   //save transaction first because of db constraint on trans id

				$tsql           = 'EXEC [usp_InsertIntoRAISDosimetryForm]'
							. '@TransID = :TransID,'
							. '@Fname = :FirstName,'
							. '@Lname = :LastName,'
							. '@FormID = :FormID,'
							. '@SID = :SID,'
							. '@EMPLID = :EMPLID,'
							. '@BCEmail = :Email,'
							. '@Phone = :Phone,'
							. '@AppliedProgram = :AppliedProgram,'
							. '@CollegeUniversity = :CollegeUniversity,'
							. '@DegreeEarned = :DegreeEarned,'
							. '@YearGraduated = :YearGraduated,'
							. '@ClinicalSite = :ClinicalSite,'
							. '@NameOfSite = :NameOfSite,'
							. '@LocationOfSite = :LocationOfSite,'
							. '@NationalCertification = :HaveCertification,'
							. '@CertifyingOrganization = :CertifyingOrganization,'
							. '@AnticipatedCertificate = :AnticipatedCertificate,'
							. '@AnticipatedCertificateCompDate = :AnticipatedCertCompletionDate,'
							. '@UnofficialTrans1 = :UnofficialTranscript1,'
							. '@UnofficialTrans2 = :UnofficialTranscript2,'
							. '@UnofficialTrans3 = :UnofficialTranscript3,'
							. '@PersonalStatementupload = :PersonalStatement,' // Personal stmt field changed from text to file upload
							. '@ElectronicSignature = :ElectronicSignature'
							. ';';
					$query      = $conn->prepare( $tsql );
					$input_data = array(
						'TransID'                       => $this->transaction->get_id(),
						'FirstName'                     => $this->first_name,
						'LastName'                      => $this->last_name,
						'FormID'                        => $this->form_id,
						'SID'                           => $this->sid,
						'EMPLID'                        => $this->emplid,
						'Email'                         => $this->email,
						'Phone'                         => $this->phone,
						'AppliedProgram'                => $this->applied_program,
						'CollegeUniversity'             => $this->college_university,
						'DegreeEarned'                  => $this->degree_earned,
						'YearGraduated'                 => $this->year_graduated,
						'ClinicalSite'                  => $this->clinical_site,
						'NameOfSite'                    => $this->name_of_site,
						'LocationOfSite'                => $this->location_of_site,
						'HaveCertification'             => $this->have_national_certification,
						'CertifyingOrganization'        => $this->certifying_organization,
						'AnticipatedCertificate'        => $this->anticipated_certificate,
						'AnticipatedCertCompletionDate' => $this->anticipated_certificate_comp_date,
						'UnofficialTranscript1'         => $this->transcript_1,
						'UnofficialTranscript2'         => $this->transcript_2,
						'UnofficialTranscript3'         => $this->transcript_3,
						'PersonalStatement'             => $this->personal_stmt,
						'ElectronicSignature'           => $this->signature,

					);
					$result = $query->execute( $input_data );
					//var_dump($result);
					//var_dump($conn->errorCode());
					//var_dump($conn->errorInfo());

					return $result;
			} catch ( PDOException $e ) {
				error_log( print_r( 'PDOException in RAIS_DosimetryConcentration::save - ' . $e->getMessage(), true ) );
			} catch ( Exception $e ) {
				error_log( print_r( 'General exception in RAIS_DosimetryConcentration::save - ' . $e->getMessage(), true ) );
			}
		}
		return false;
	}

	//fill in data model fields using submitted form info
	public function build( $_entry ) {
		//set model info using entry values
		$this->first_name         = ! empty( $_entry['1.3'] ) ? rgar( $_entry, '1.3' ) : null;
		$this->last_name          = ! empty( $_entry['1.6'] ) ? rgar( $_entry, '1.6' ) : null;
		$this->sid                = ! empty( $_entry['3'] ) ? rgar( $_entry, '3' ) : null;
		$this->emplid             = ! empty( $_entry['61'] ) ? rgar( $_entry, '61' ) : null;
		$this->email              = ! empty( $_entry['4'] ) ? rgar( $_entry, '4' ) : null;
		$this->phone              = ! empty( $_entry['5'] ) ? rgar( $_entry, '5' ) : null;
		$this->applied_program    = ! empty( $_entry['47'] ) ? rgar( $_entry, '47' ) : null;
		$this->college_university = ! empty( $_entry['57'] ) ? rgar( $_entry, '57' ) : null;
		$this->degree_earned      = ! empty( $_entry['58'] ) ? rgar( $_entry, '58' ) : null;
		$this->year_graduated     = ! empty( $_entry['59'] ) ? rgar( $_entry, '59' ) : null;

		if ( empty( $_entry['50'] ) ) {
			$this->clinical_site = null;
		} elseif ( ! empty( $_entry['50'] ) && strtolower( rgar( $_entry, '50' ) ) == 'yes' ) {
			$this->clinical_site = true;
		} else {
			$this->clinical_site = false;
		}

		$this->name_of_site     = ! empty( $_entry['53'] ) ? rgar( $_entry, '53' ) : null;
		$this->location_of_site = ! empty( $_entry['60'] ) ? rgar( $_entry, '60' ) : null;
		if ( empty( $_entry['34'] ) ) {
			$this->have_national_certification = null;
		} elseif ( ! empty( $_entry['34'] ) && strtolower( rgar( $_entry, '34' ) ) == 'yes' ) {
			$this->have_national_certification = true;
		} else {
			$this->have_national_certification = false;
		}

		 $this->certifying_organization          = ! empty( $_entry['54'] ) ? rgar( $_entry, '54' ) : null;
		$this->anticipated_certificate           = ! empty( $_entry['35'] ) ? rgar( $_entry, '35' ) : null;
		$this->anticipated_certificate_comp_date = ! empty( $_entry['36'] ) ? rgar( $_entry, '36' ) : null;

		$this->transcript_1  = ! empty( $_entry['14'] ) ? rgar( $_entry, '14' ) : null;
		$this->transcript_2  = ! empty( $_entry['42'] ) ? rgar( $_entry, '42' ) : null;
		$this->transcript_3  = ! empty( $_entry['43'] ) ? rgar( $_entry, '43' ) : null;
		$this->personal_stmt = ! empty( $_entry['55'] ) ? rgar( $_entry, '55' ) : null;
		$this->signature     = ! empty( $_entry['23'] ) ? rgar( $_entry, '23' ) : null;

		$this->form_id = rgar( $_entry, 'form_id' );

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
			rgar( $_entry, '46.1' ),
			rgar( $_entry, '46.2' ),
			rgar( $_entry, '46.3' ),
			rgar( $_entry, '46.4' ),
			rgar( $_entry, '46.5' )
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
