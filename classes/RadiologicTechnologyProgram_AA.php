<?php

require_once( 'DB.php' );
require_once( 'Transaction.php' );

class RadiologicTechnologyProgram_AA {

	protected $first_name;
	protected $last_name;
	protected $sid;
	protected $email;
	protected $phone;
	protected $other_email;
	//    protected $eng_comp_course;
	//    protected $eng_comp_term_completed;
	//    protected $eng_comp_grade_earned;
	//    protected $eng_comp_school_attended;
	//
	//    protected $int_alg_course;
	//    protected $int_alg_term_completed;
	//    protected $int_alg_grade_earned;
	//    protected $int_alg_school_attended;
	//
	//    protected $ha_phyI_course;
	//    protected $ha_phyI_term_completed;
	//    protected $ha_phyI_grade_earned;
	//    protected $ha_phyI_school_attended;
	//
	//    protected $ha_phyII_course;
	//    protected $ha_phyII_term_completed;
	//    protected $ha_phyII_grade_earned;
	//    protected $ha_phyII_school_attended;
	//
	//    protected $cultural_div_course;
	//    protected $cultural_div_term_completed;
	//    protected $cultural_div_grade_earned;
	//    protected $cultural_div_school_attended;
	//
	protected $did_attend_information_session;

	protected $did_attend_in_person;
	protected $certificate_of_attendance;


	protected $date_attended;

	protected $is_reapplicant;
	protected $year_last_applied;

	protected $pceI_clinic_hospital_name;
	protected $pceI_type_of_work_performed;
	protected $pceI_no_of_hours;
	protected $pceI_start_and_end_date;
	protected $pceII_clinic_hospital_name;
	protected $pceII_type_of_work_performed;
	protected $pceII_no_of_hours;
	protected $pceII_start_and_end_date;

	protected $personal_stmt;
	protected $reapplicant_stmt;
	protected $unofficial_transcript_1;
	protected $unofficial_transcript_2;
	protected $unofficial_transcript_3;
	protected $unofficial_transcript_4;

	protected $patient_care_radiology_exp;
	protected $prerequisite;
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
				$tsql   = 'EXEC [usp_InsertIntoAARadiologicTechForm]'
							. '@SID = :SID,'
							. '@Fname = :FirstName,'
							. '@Lname = :LastName,'
							. '@Phone = :Phone,'
							. '@Email = :Email,'
							. '@OtherEmail = :OtherEmail,'
							. '@DidAttendInformationSession = :DidAttendInformationSession,'

							. '@DateAttended = :DateAttended,'

							. '@IsReapplicant = :IsReapplicant,'
							. '@YearLastApplied = :YearLastApplied,'

							. '@PCEIClinicHospitalName = :PCEIClinicHospitalName,'
							. '@PCEITypeofworkPerformed = :PCEITypeofworkPerformed,'
							. '@PCEINoofHours = :PCEINoofHours,'
							. '@PCEIStartandEndDate = :PCEIStartandEndDate,'
							. '@PCEIIClinicHospitalName = :PCEIIClinicHospitalName,'
							. '@PCEIITypeofworkPerformed = :PCEIITypeofworkPerformed,'
							. '@PCEIINoofHours = :PCEIINoofHours,'
							. '@PCEIIStartandEndDate = :PCEIIStartandEndDate,'

							. '@PersonalStatement = :PersonalStatement,'
							. '@ReApplicantStatement = :ReApplicantStatement,'
							. '@UnofficialTranscript1 = :UnofficialTranscript1,'
							. '@UnofficialTranscript2 = :UnofficialTranscript2,'
							. '@UnofficialTranscript3 = :UnofficialTranscript3,'
							. '@UnofficialTranscript4 = :UnofficialTranscript4,'
							. '@Prerequisite = :Prerequisite,'

							. '@PatientcareorRadiologyForm = :PatientcareorRadiologyForm,'
							. '@TransID = :TransID,'
							. '@FormID = :FormID,'
							. '@ElectronicSignature = :ElectronicSignature,'

							// Related to Info Session
							. '@DidAttendInPerson = :DidAttendInPerson,'
							. '@CertificateofAttendance = :CertificateofAttendance;';
							//error_log("parameters :".$tsql);
					$query      = $conn->prepare( $tsql );
					$input_data = array(
						'SID'                         => $this->sid,
						'FirstName'                   => $this->first_name,
						'LastName'                    => $this->last_name,
						'Phone'                       => $this->phone,
						'Email'                       => $this->email,
						'OtherEmail'                  => $this->other_email,
						'DidAttendInformationSession' => $this->did_attend_information_session,
						'DidAttendInPerson'           => $this->did_attend_in_person,
						'CertificateofAttendance'     => $this->certificate_of_attendance,

						'DateAttended'                => $this->date_attended,

						'IsReapplicant'               => $this->is_reapplicant,
						'YearLastApplied'             => $this->year_last_applied,

						'PCEIClinicHospitalName'      => $this->pceI_clinic_hospital_name,
						'PCEITypeofworkPerformed'     => $this->pceI_type_of_work_performed,
						'PCEINoofHours'               => $this->pceI_no_of_hours,
						'PCEIStartandEndDate'         => $this->pceI_start_and_end_date,
						'PCEIIClinicHospitalName'     => $this->pceII_clinic_hospital_name,
						'PCEIITypeofworkPerformed'    => $this->pceII_type_of_work_performed,
						'PCEIINoofHours'              => $this->pceII_no_of_hours,
						'PCEIIStartandEndDate'        => $this->pceII_start_and_end_date,

						'PersonalStatement'           => $this->personal_stmt,
						'ReApplicantStatement'        => $this->reapplicant_stmt,
						'UnofficialTranscript1'       => $this->unofficial_transcript_1,
						'UnofficialTranscript2'       => $this->unofficial_transcript_2,
						'UnofficialTranscript3'       => $this->unofficial_transcript_3,
						'UnofficialTranscript4'       => $this->unofficial_transcript_4,

						'PatientcareorRadiologyForm'  => $this->patient_care_radiology_exp,
						'Prerequisite'                => $this->prerequisite,
						'TransID'                     => $this->transaction->get_id(),
						'FormID'                      => $this->form_id,
						'ElectronicSignature'         => $this->signature,
					);
					  //error_log("input data :".print_r($input_data,true));
					$result = $query->execute( $input_data );
					//var_dump($result);
					//var_dump($conn->errorCode());
					//var_dump($conn->errorInfo());
					return $result;
			} catch ( PDOException $e ) {
				error_log( print_r( 'PDOException in RadiologicTechnologyProgram_AA::save - ' . $e->getMessage(), true ) );
			} catch ( Exception $e ) {
				error_log( print_r( 'General exception in RadiologicTechnologyProgram_AA::save - ' . $e->getMessage(), true ) );
			}
		}
		return false;
	}

	//fill in data model fields using form information
	public function build( $_entry ) {

		//set model info using entry values
		$this->first_name  = ! empty( $_entry['2.3'] ) ? rgar( $_entry, '2.3' ) : null;
		$this->last_name   = ! empty( $_entry['2.6'] ) ? rgar( $_entry, '2.6' ) : null;
		$this->sid         = ! empty( $_entry['3'] ) ? rgar( $_entry, '3' ) : null;
		$this->email       = ! empty( $_entry['4'] ) ? rgar( $_entry, '4' ) : null;
		$this->other_email = ! empty( $_entry['46'] ) ? rgar( $_entry, '46' ) : null;
		$this->phone       = ! empty( $_entry['5'] ) ? rgar( $_entry, '5' ) : null;
		if ( empty( $_entry['16'] ) ) {
			$this->did_attend_information_session = null;
		} elseif ( ! empty( $_entry['16'] ) && strtolower( rgar( $_entry, '16' ) ) == 'yes' ) {
			$this->did_attend_information_session = true;
		} else {
			$this->did_attend_information_session = false;
		}

		if ( empty( $_entry['48'] ) ) {
			$this->did_attend_in_person = null;
		} elseif ( ! empty( $_entry['48'] ) && strtolower( rgar( $_entry, '48' ) ) == 'in person information session' ) {
			$this->did_attend_in_person = true;
		} else {
			$this->did_attend_in_person = false;
		}

		$this->date_attended = ! empty( $_entry['17'] ) ? rgar( $_entry, '17' ) : null;

		$this->certificate_of_attendance = ! empty( $_entry['49'] ) ? rgar( $_entry, '49' ) : null;

		if ( empty( $_entry['18'] ) ) {
			$this->is_reapplicant = null;
		} elseif ( ! empty( $_entry['18'] ) && strtolower( rgar( $_entry, '18' ) ) == 'yes' ) {
			$this->is_reapplicant = true;
		} else {
			$this->is_reapplicant = false;
		}
		$this->year_last_applied = ! empty( $_entry['19'] ) ? rgar( $_entry, '19' ) : null;

		if ( ! empty( $_entry['38'] ) ) {
			$class_data = unserialize( rgar( $_entry, '38' ) );

			$this->pceI_clinic_hospital_name    = ! empty( $class_data[0]['Clinic/Hospital'] ) ? $class_data[0]['Clinic/Hospital'] : null;
			$this->pceI_type_of_work_performed  = ! empty( $class_data[0]['Type of work performed'] ) ? $class_data[0]['Type of work performed'] : null;
			$this->pceI_no_of_hours             = ! empty( $class_data[0]['No. of hours'] ) ? $class_data[0]['No. of hours'] : null;
			$this->pceI_start_and_end_date      = ! empty( $class_data[0]['Start and End dates'] ) ? $class_data[0]['Start and End dates'] : null;
			$this->pceII_clinic_hospital_name   = ! empty( $class_data[1]['Clinic/Hospital'] ) ? $class_data[1]['Clinic/Hospital'] : null;
			$this->pceII_type_of_work_performed = ! empty( $class_data[1]['Type of work performed'] ) ? $class_data[1]['Type of work performed'] : null;
			$this->pceII_no_of_hours            = ! empty( $class_data[1]['No. of hours'] ) ? $class_data[1]['No. of hours'] : null;
			$this->pceII_start_and_end_date     = ! empty( $class_data[1]['Start and End dates'] ) ? $class_data[1]['Start and End dates'] : null;
		} else {
			$this->pceI_clinic_hospital_name    = null;
			$this->pceI_type_of_work_performed  = null;
			$this->pceI_no_of_hours             = null;
			$this->pceI_start_and_end_date      = null;
			$this->pceII_clinic_hospital_name   = null;
			$this->pceII_type_of_work_performed = null;
			$this->pceII_no_of_hours            = null;
			$this->pceII_start_and_end_date     = null;
		}

		$this->personal_stmt              = ! empty( $_entry['23'] ) ? rgar( $_entry, '23' ) : null;
		$this->reapplicant_stmt           = ! empty( $_entry['47'] ) ? rgar( $_entry, '47' ) : null;
		$this->unofficial_transcript_1    = ! empty( $_entry['25'] ) ? rgar( $_entry, '25' ) : null;
		$this->unofficial_transcript_2    = ! empty( $_entry['26'] ) ? rgar( $_entry, '26' ) : null;
		$this->unofficial_transcript_3    = ! empty( $_entry['27'] ) ? rgar( $_entry, '27' ) : null;
		$this->unofficial_transcript_4    = ! empty( $_entry['28'] ) ? rgar( $_entry, '28' ) : null;
		$this->patient_care_radiology_exp = ! empty( $_entry['31'] ) ? rgar( $_entry, '31' ) : null;
		$this->prerequisite               = ! empty( $_entry['45'] ) ? rgar( $_entry, '45' ) : null;

		$this->signature = ! empty( $_entry['36'] ) ? rgar( $_entry, '36' ) : null;
		$this->form_id   = rgar( $_entry, 'form_id' );

		//build transaction object
		$this->transaction = new Transaction(
			rgar( $_entry, 'transaction_id' ),
			$this->form_id,
			$this->sid,
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
			rgar( $_entry, '42.3' ),
			rgar( $_entry, '42.4' ),
			rgar( $_entry, '42.5' ),
			rgar( $_entry, '42.6' )
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
