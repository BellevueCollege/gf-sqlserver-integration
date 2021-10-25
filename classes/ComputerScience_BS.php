<?php
require_once( 'DB.php' );
require_once( 'Transaction.php' );

class ComputerScience_BS {

	protected $first_name;
	protected $last_name;
	protected $sid;
	protected $emplid;
	protected $email;
	protected $phone;
	protected $highest_ed;
	protected $pathway;
	protected $proficiency;
	protected $proficiency_proof;

	protected $first_math151;
	protected $first_engl101;
	protected $first_sat;
	protected $first_act;

	protected $transfer_math151_name;
	protected $transfer_math151_quarter;
	protected $transfer_math151_grade;
	protected $transfer_math151_school;

	protected $transfer_math152_name;
	protected $transfer_math152_quarter;
	protected $transfer_math152_grade;
	protected $transfer_math152_school;

	protected $transfer_engl_name;
	protected $transfer_engl_quarter;
	protected $transfer_engl_grade;
	protected $transfer_engl_school;

	protected $transfer_cs210_name;
	protected $transfer_cs210_quarter;
	protected $transfer_cs210_grade;
	protected $transfer_cs210_school;

	protected $transfer_cs211_name;
	protected $transfer_cs211_quarter;
	protected $transfer_cs211_grade;
	protected $transfer_cs211_school;

	protected $transfer_phys_name;
	protected $transfer_phys_quarter;
	protected $transfer_phys_grade;
	protected $transfer_phys_school;

	protected $transcript_1;
	protected $transcript_2;
	protected $transcript_3;
	protected $transcript_4;

	protected $personal_stmt;
	protected $diversity_stmt;
	protected $resume;
	protected $signature;
	protected $transaction;
	protected $form_id;

	//public constructor
	public function __construct() {

	}

	//save data to SQL Server
	public function save() {
		$db   = new DB();
		$conn = $db->getDB();

		if ( $conn ) {
			try {
				$result    = $this->transaction->save();   //save transaction first because of db constraint on trans id
				$tsql      = 'EXEC [usp_InsertIntoComputerScienceForm]'
							. '@TransID = :TransID,'
							. '@Fname = :FirstName,'
							. '@Lname = :LastName,'
							. '@FormID = :FormID,'
							. '@SID = :SID,'
							. '@EMPLID = :EMPLID,'
							. '@Email = :Email,'
							. '@Phone = :Phone,'
							. '@EducationLevel = :EducationLevel,'
							. '@StudentPathwayFirstOrTransfer = :Pathway,'
							. '@EnglishProficency = :EnglishProficiency,'
							. '@ProofLanguageProficiency = :ProficiencyProof,'
							. '@FYReqMath151 = :FYMath151,'
							. '@FYReqEngl101 = :FYEngl101,'
							. '@TSReqMath151Course = :TSMath151Course,'
							. '@TSReqMath151Quarter = :TSMath151Quarter,'
							. '@TSReqMath151Grade = :TSMath151Grade,'
							. '@TSReqMath151School = :TSMath151School,'
							. '@TSReqMath152Course = :TSMath152Course,'
							. '@TSReqMath152Quarter = :TSMath152Quarter,'
							. '@TSReqMath152Grade = :TSMath152Grade,'
							. '@TSReqMath152School = :TSMath152School,'
							. '@TSReqEnglishCompositionCourse = :TSEnglishCourse,'
							. '@TSReqEnglishCompositionQuarter = :TSEnglishQuarter,'
							. '@TSReqEnglishCompositionGrade = :TSEnglishGrade,'
							. '@TSReqEnglishCompositionSchool = :TSEnglishSchool,'
							. '@TSReqFundamentalofCS1Course = :TSCS1Course,'
							. '@TSReqFundamentalofCS1Quarter = :TSCS1Quarter,'
							. '@TSReqFundamentalofCS1Grade = :TSCS1Grade,'
							. '@TSReqFundamentalofCS1School = :TSCS1School,'
							. '@TSReqFundamentalofCS2Course = :TSCS2Course,'
							. '@TSReqFundamentalofCS2Quarter = :TSCS2Quarter,'
							. '@TSReqFundamentalofCS2Grade = :TSCS2Grade,'
							. '@TSReqFundamentalofCS2School = :TSCS2School,'
							. '@TSReqPhysicalScienceCourse = :TSPhysCourse,'
							. '@TSReqPhysicalScienceQuarter = :TSPhysQuarter,'
							. '@TSReqPhysicalScienceGrade = :TSPhysGrade,'
							. '@TSReqPhysicalScienceSchool = :TSPhysSchool,'
							. '@SATScore = :SATScore,'
							. '@ACTScore = :ACTScore,'
							. '@UnofficialTranscript1 = :UnofficialTranscript1,'
							. '@UnofficialTranscript2 = :UnofficialTranscript2,'
							. '@UnofficialTranscript3 = :UnofficialTranscript3,'
							. '@UnofficialTranscript4 = :UnofficialTranscript4,'
							. '@PersonalStatement = :PersonalStatement,'
							. '@DiversityStatement = :DiversityStatement,'
							. '@Resume = :Resume,'
							. '@ElectronicSignature = :ElectronicSignature;';
					$query = $conn->prepare( $tsql );

					$input_data = array(
						'TransID'               => $this->transaction->get_id(),
						'FirstName'             => $this->first_name,
						'LastName'              => $this->last_name,
						'FormID'                => $this->form_id,
						'SID'                   => $this->sid,
						'EMPLID'                => $this->emplid,
						'Email'                 => $this->email,
						'Phone'                 => $this->phone,
						'EducationLevel'        => $this->highest_ed,
						'Pathway'               => $this->pathway,
						'EnglishProficiency'    => $this->proficiency,
						'ProficiencyProof'      => $this->proficiency_proof,
						'FYMath151'             => $this->first_math151,
						'FYEngl101'             => $this->first_engl101,
						'TSMath151Course'       => $this->transfer_math151_name,
						'TSMath151Quarter'      => $this->transfer_math151_quarter,
						'TSMath151Grade'        => $this->transfer_math151_grade,
						'TSMath151School'       => $this->transfer_math151_school,
						'TSMath152Course'       => $this->transfer_math152_name,
						'TSMath152Quarter'      => $this->transfer_math152_quarter,
						'TSMath152Grade'        => $this->transfer_math152_grade,
						'TSMath152School'       => $this->transfer_math152_school,
						'TSEnglishCourse'       => $this->transfer_engl_name,
						'TSEnglishQuarter'      => $this->transfer_engl_quarter,
						'TSEnglishGrade'        => $this->transfer_engl_grade,
						'TSEnglishSchool'       => $this->transfer_engl_school,
						'TSCS1Course'           => $this->transfer_cs210_name,
						'TSCS1Quarter'          => $this->transfer_cs210_quarter,
						'TSCS1Grade'            => $this->transfer_cs210_grade,
						'TSCS1School'           => $this->transfer_cs210_school,
						'TSCS2Course'           => $this->transfer_cs211_name,
						'TSCS2Quarter'          => $this->transfer_cs211_quarter,
						'TSCS2Grade'            => $this->transfer_cs211_grade,
						'TSCS2School'           => $this->transfer_cs211_school,
						'TSPhysCourse'          => $this->transfer_phys_name,
						'TSPhysQuarter'         => $this->transfer_phys_quarter,
						'TSPhysGrade'           => $this->transfer_phys_grade,
						'TSPhysSchool'          => $this->transfer_phys_school,
						'SATScore'              => $this->first_sat,
						'ACTScore'              => $this->first_act,
						'UnofficialTranscript1' => $this->transcript_1,
						'UnofficialTranscript2' => $this->transcript_2,
						'UnofficialTranscript3' => $this->transcript_3,
						'UnofficialTranscript4' => $this->transcript_4,
						'PersonalStatement'     => $this->personal_stmt,
						'DiversityStatement'    => $this->diversity_stmt,
						'Resume'                => $this->resume,
						'ElectronicSignature'   => $this->signature,
					);

					$result = $query->execute( $input_data );
					//var_dump($result);
					//var_dump($conn->errorCode());
					//var_dump($conn->errorInfo());
					return $result;
			} catch ( PDOException $e ) {
				error_log( print_r( 'PDOException in DataAnalytics_BAS::save - ' . $e->getMessage(), true ) );
			} catch ( Exception $e ) {
				error_log( print_r( 'General exception in DataAnalytics_BAS::save - ' . $e->getMessage(), true ) );
			}
		}
		return false;
	}

	//fill in model fields from form entry info
	public function build( $_entry ) {
		//set model info
		$this->first_name = ! empty( $_entry['1.3'] ) ? rgar( $_entry, '1.3' ) : null;
		$this->last_name  = ! empty( $_entry['1.6'] ) ? rgar( $_entry, '1.6' ) : null;
		$this->sid        = ! empty( $_entry['3'] ) ? rgar( $_entry, '3' ) : null;
		$this->emplid     = ! empty( $_entry['62'] ) ? rgar( $_entry, '62' ) : null;
		$this->email      = ! empty( $_entry['4'] ) ? rgar( $_entry, '4' ) : null;
		$this->phone      = ! empty( $_entry['5'] ) ? rgar( $_entry, '5' ) : null;
		$this->highest_ed = ! empty( $_entry['6'] ) ? rgar( $_entry, '6' ) : null;

		$this->pathway           = ! empty( $_entry['40'] ) ? rgar( $_entry, '40' ) : null;
		$this->proficiency       = ! empty( $_entry['35'] ) ? rgar( $_entry, '35' ) : null;
		$this->proficiency_proof = ! empty( $_entry['36'] ) ? rgar( $_entry, '36' ) : null;

		$this->first_math151 = ! empty( $_entry['58'] ) ? rgar( $_entry, '58' ) : null;
		$this->first_engl101 = ! empty( $_entry['59'] ) ? rgar( $_entry, '59' ) : null;
		$this->first_sat     = ! empty( $_entry['29'] ) ? rgar( $_entry, '29' ) : null;
		$this->first_act     = ! empty( $_entry['30'] ) ? rgar( $_entry, '30' ) : null;

		//process transfer math151 info
		if ( ! empty( $_entry['48'] ) ) {
			$class_data = unserialize( rgar( $_entry, '48' ) );

			$this->transfer_math151_name    = ! empty( $class_data[0]['Course name and number'] ) ? $class_data[0]['Course name and number'] : null;
			$this->transfer_math151_quarter = ! empty( $class_data[0]['Quarter or semester completed'] ) ? $class_data[0]['Quarter or semester completed'] : null;
			$this->transfer_math151_grade   = ! empty( $class_data[0]['Grade earned'] ) ? $class_data[0]['Grade earned'] : null;
			$this->transfer_math151_school  = ! empty( $class_data[0]['School attended'] ) ? $class_data[0]['School attended'] : null;
		} else {
			$this->transfer_math151_name    = null;
			$this->transfer_math151_quarter = null;
			$this->transfer_math151_grade   = null;
			$this->transfer_math151_school  = null;
		}

		//process transfer math152 info
		if ( ! empty( $_entry['52'] ) ) {
			$class_data = unserialize( rgar( $_entry, '52' ) );

			$this->transfer_math152_name    = ! empty( $class_data[0]['Course name and number'] ) ? $class_data[0]['Course name and number'] : null;
			$this->transfer_math152_quarter = ! empty( $class_data[0]['Quarter or semester completed'] ) ? $class_data[0]['Quarter or semester completed'] : null;
			$this->transfer_math152_grade   = ! empty( $class_data[0]['Grade earned'] ) ? $class_data[0]['Grade earned'] : null;
			$this->transfer_math152_school  = ! empty( $class_data[0]['School attended'] ) ? $class_data[0]['School attended'] : null;
		} else {
			$this->transfer_math152_name    = null;
			$this->transfer_math152_quarter = null;
			$this->transfer_math152_grade   = null;
			$this->transfer_math152_school  = null;
		}

		//process transfer english info
		if ( ! empty( $_entry['51'] ) ) {
			$class_data = unserialize( rgar( $_entry, '51' ) );

			$this->transfer_engl_name    = ! empty( $class_data[0]['Course name and number'] ) ? $class_data[0]['Course name and number'] : null;
			$this->transfer_engl_quarter = ! empty( $class_data[0]['Quarter or semester completed'] ) ? $class_data[0]['Quarter or semester completed'] : null;
			$this->transfer_engl_grade   = ! empty( $class_data[0]['Grade earned'] ) ? $class_data[0]['Grade earned'] : null;
			$this->transfer_engl_school  = ! empty( $class_data[0]['School attended'] ) ? $class_data[0]['School attended'] : null;
		} else {
			$this->transfer_engl_name    = null;
			$this->transfer_engl_quarter = null;
			$this->transfer_engl_grade   = null;
			$this->transfer_engl_school  = null;
		}

		//process transfer CS210 info
		if ( ! empty( $_entry['50'] ) ) {
			$class_data = unserialize( rgar( $_entry, '50' ) );

			$this->transfer_cs210_name    = ! empty( $class_data[0]['Course name and number'] ) ? $class_data[0]['Course name and number'] : null;
			$this->transfer_cs210_quarter = ! empty( $class_data[0]['Quarter or semester completed'] ) ? $class_data[0]['Quarter or semester completed'] : null;
			$this->transfer_cs210_grade   = ! empty( $class_data[0]['Grade earned'] ) ? $class_data[0]['Grade earned'] : null;
			$this->transfer_cs210_school  = ! empty( $class_data[0]['School attended'] ) ? $class_data[0]['School attended'] : null;
		} else {
			$this->transfer_cs210_name    = null;
			$this->transfer_cs210_quarter = null;
			$this->transfer_cs210_grade   = null;
			$this->transfer_cs210_school  = null;
		}

		//process transfer CS211 info
		if ( ! empty( $_entry['49'] ) ) {
			$class_data = unserialize( rgar( $_entry, '49' ) );

			$this->transfer_cs211_name    = ! empty( $class_data[0]['Course name and number'] ) ? $class_data[0]['Course name and number'] : null;
			$this->transfer_cs211_quarter = ! empty( $class_data[0]['Quarter or semester completed'] ) ? $class_data[0]['Quarter or semester completed'] : null;
			$this->transfer_cs211_grade   = ! empty( $class_data[0]['Grade earned'] ) ? $class_data[0]['Grade earned'] : null;
			$this->transfer_cs211_school  = ! empty( $class_data[0]['School attended'] ) ? $class_data[0]['School attended'] : null;
		} else {
			$this->transfer_cs211_name    = null;
			$this->transfer_cs211_quarter = null;
			$this->transfer_cs211_grade   = null;
			$this->transfer_cs211_school  = null;
		}

		//process transfer physical science info
		if ( ! empty( $_entry['53'] ) ) {
			$class_data = unserialize( rgar( $_entry, '53' ) );

			$this->transfer_phys_name    = ! empty( $class_data[0]['Course name and number'] ) ? $class_data[0]['Course name and number'] : null;
			$this->transfer_phys_quarter = ! empty( $class_data[0]['Quarter or semester completed'] ) ? $class_data[0]['Quarter or semester completed'] : null;
			$this->transfer_phys_grade   = ! empty( $class_data[0]['Grade earned'] ) ? $class_data[0]['Grade earned'] : null;
			$this->transfer_phys_school  = ! empty( $class_data[0]['School attended'] ) ? $class_data[0]['School attended'] : null;
		} else {
			$this->transfer_phys_name    = null;
			$this->transfer_phys_quarter = null;
			$this->transfer_phys_grade   = null;
			$this->transfer_phys_school  = null;
		}

		$this->transcript_1   = ! empty( $_entry['14'] ) ? rgar( $_entry, '14' ) : null;
		$this->transcript_2   = ! empty( $_entry['25'] ) ? rgar( $_entry, '25' ) : null;
		$this->transcript_3   = ! empty( $_entry['26'] ) ? rgar( $_entry, '26' ) : null;
		$this->transcript_4   = ! empty( $_entry['27'] ) ? rgar( $_entry, '27' ) : null;
		$this->personal_stmt  = ! empty( $_entry['54'] ) ? rgar( $_entry, '54' ) : null;
		$this->diversity_stmt = ! empty( $_entry['55'] ) ? rgar( $_entry, '55' ) : null;
		$this->resume         = ! empty( $_entry['39'] ) ? rgar( $_entry, '39' ) : null;

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
			rgar( $_entry, '61.1' ),
			rgar( $_entry, '61.2' ),
			rgar( $_entry, '61.3' ),
			rgar( $_entry, '61.4' ),
			rgar( $_entry, '61.5' )
		);
	}

	//return transaction object
	public function get_transaction() {
		return $this->transaction;
	}

	//return form id
	public function get_form_id() {
		return $this->form_id;
	}

}
