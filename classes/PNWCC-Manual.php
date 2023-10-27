<?php

require_once('DB.php');
require_once('Transaction.php');

class PNWCC-Manual {
	//form data fields
	protected $first_name;
	protected $last_name;

	protected $email;
	protected $phone;
	protected $dob;
	protected $pnwcc_manual_id;
	protected $transaction;
	protected $form_id;
	protected $school_district;
	protected $school;

	//public constructor
	public function __construct() { }

	//save data to SQL Server
	public function save() {
		$db = new DB();
		$conn = $db->getDB();

		if ( $conn ) {
			try {
				$result = $this->transaction->save();   //save transaction first because of db constraint on trans id
				$tsql = 'EXEC [usp_InsertIntoPNWCC-ManualForm]'
							. '@TransID = :TransID,'
							. '@Fname = :FirstName,'
							. '@Lname = :LastName,'
							. '@FormID = :FormID,'
							. '@DOB = :Dob,'
							. '@Email = :Email,'
							. '@Phone = :Phone,'
							. '@PNWCCManualID = :PNWCCManualID,'
							. '@SchoolDistrict = :SchoolDistrict,'
							. '@School = :School;';
				$query = $conn->prepare( $tsql );

				$input_data = array(
					'TransID'        => $this->transaction->get_id(),
					'FirstName'      => $this->first_name,
					'LastName'       => $this->last_name,
					'FormID'         => $this->form_id,
					'Email'          => $this->email,
					'Phone'          => $this->phone,
					'Dob'            => $this->dob,
					'PNWCCManualID'     => $this->pnwcc_manual_id,
					'SchoolDistrict' => $this->school_district,
					'School'         => $this->school,
				);

				$result = $query->execute($input_data);
				return $result;
			} catch (PDOException $e) {
				error_log( print_r( "PDOException in PNWCC-Manual::save - " . $e->getMessage(), true ) );
			} catch (Exception $e) {
				error_log( print_r( "General exception in PNWCC-Manual::save - " . $e->getMessage(), true ) );
			}
		}
		return false;
	}

	//fill in model information from form entry information
	public function build( $_entry ) {

		/**
		 * Fields on the form that may contain the school name
		 */
		$school_fields = [
			'17',
			'51',
			'19',
			'18',
			'20',
			'21',
			'22',
			'23',
			'24',
			'25',
			'26',
			'27',
			'28',
			'29',
			'30',
			'31',
			'32',
			'33',
			'34',
			'35',
			'36',
			'37',
			'38',
			'39',
			'40',
			'41',
			'42',
			'43',
			'44',
			'46',
			'47',
			'48',
			'49',
			'50',
			'52', // Kent High Schools
			'53', // Other for Kent High schools
			'55',// Renton Hgh schools
			'54', // Other for renton high schools
			'56', // seattle high schools
			'57', // other for seatle high schools
		];

		/**
		 * Check to see if each field is empty
		 */
		$school_name;
		foreach( $school_fields as $id ) {
			if ( ! empty( $_entry[$id] ) && 'Not Listed' !== $_entry[$id] ) {
				$school_name = rgar( $_entry, $id );
			}
		}

		//set model info using entry values
		$this->first_name      = !empty($_entry['1.3']) ? rgar($_entry, '1.3') : null;
		$this->last_name       = !empty($_entry['1.6']) ? rgar($_entry, '1.6') : null;
		$this->email           = !empty($_entry['2']) ? rgar($_entry, '2') : null;
		$this->phone           = !empty($_entry['3']) ? rgar($_entry, '3') : null;
		$this->dob             = !empty($_entry['4']) ? rgar($_entry, '4') : null;
		$this->pnwcc_manual_id    = !empty($_entry['5']) ? rgar($_entry, '5') : null;
		$this->school_district = !empty($_entry['16']) ? rgar($_entry, '16') : null;
		$this->school          = $school_name;
		$this->form_id         = rgar($_entry, 'form_id');

		//build transaction object
		$this->transaction = new Transaction(
			rgar($_entry, 'transaction_id'),
			$this->form_id,
			null,
			null,
			$this->first_name,
			$this->last_name,
			$this->email,
			rgar($_entry, 'payment_amount'),
			null,
			rgar($_entry, 'payment_date'),
			null,
			null,
			null,
			rgar($_entry, '12.1'),
			rgar($_entry, '12.2'),
			rgar($_entry, '12.3'),
			rgar($_entry, '12.4'),
			rgar($_entry, '12.5')
		);
		GFCommon::log_debug( 'GF SQLServer Integration::PNWCC-Manual::build - Transaction object created' );
		GFCommon::log_debug( 'GF SQLServer Integration::PNWCC-Manual::build - Transaction object: ' . print_r( $this->transaction, true ) );
	}

	//return transaction
	public function get_transaction(){
		return $this->transaction;
	}

	//return form ID
	public function get_form_id(){
		return $this->form_id;
	}

}
