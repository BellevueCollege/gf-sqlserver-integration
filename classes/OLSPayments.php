<?php
require_once( 'DB.php' );
require_once( 'Transaction.php' );

class OLSPayments {

	protected $first_name;
	protected $last_name;
	protected $dob;
	protected $student_email;
	protected $parent_email;
	protected $items;
	protected $total;
	protected $referring_form;
	protected $referring_entry;
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
				$trans_id = null;
				if ( is_object( $this->transaction ) && ( count( array( $this->transaction ) ) > 0 ) ) {
					$result   = $this->transaction->save();   //save transaction first because of db constraint on trans id
					$trans_id = $this->transaction->get_id();
				}

				$tsql = 'EXEC [usp_InsertIntoOLSPayments]'
						. '@FirstName = :FirstName,'
						. '@LastName = :LastName,'
						. '@DOB = :DOB,'
						. '@StudentEmail = :StudentEmail,'
						. '@ParentEmail = :ParentEmail,'
						. '@Items = :Items,'
						. '@ReferringForm = :ReferringForm,'
						. '@ReferringEntry = :ReferringEntry,'
						. '@FormID = :FormID,'
						. '@TransactionID = :TransactionID;';
					$query = $conn->prepare( $tsql );

					$input_data = array(
										'FirstName' => $this->first_name,
										'LastName' => $this->last_name,
										'DOB' => $this->dob,
										'StudentEmail' => $this->student_email,
										'ParentEmail' => $this->parent_email,
										'Items' => $this->items,
										'ReferringForm' => $this->referring_form,
										'ReferringEntry' => $this->referring_entry,
										'FormID' => $this->form_id,
										'TransactionID'          => $trans_id,

					);
					$result     = $query->execute( $input_data );

					//var_dump($result);
					// var_dump($conn->errorCode());
					//var_dump($conn->errorInfo());
					return $result;
			} catch ( PDOException $e ) {
				error_log( print_r( 'PDOException in OLSPayment::save - ' . $e->getMessage(), true ) );
			} catch ( Exception $e ) {
				error_log( print_r( 'General exception in OLSPayment::save - ' . $e->getMessage(), true ) );
			}
		}
		return false;
	}

	public function build( $_entry ) {
		//set model info
		$this->first_name    = rgar( $_entry, '1.3' );
		$this->last_name     = rgar( $_entry, '1.6' );
		$this->dob           = rgar( $_entry, '2' ); //verify this is a single field- may be 3
		$this->student_email = rgar( $_entry, '3' );
		$this->parent_email  = rgar( $_entry, '4' );

		$orientation_fee     = rgar( $_entry, '6.1' );
		$payment_options     = rgar( $_entry, '7' );
		$program             = rgar( $_entry, '11' );
		$camps_deposit_1     = rgar( $_entry, '8.1' );
		$camps_deposit_2     = rgar( $_entry, '8.2' );
		$camps_balance_1     = rgar( $_entry, '9.1' );
		$camps_balance_2     = rgar( $_entry, '9.2' );
		$camps_in_full_1     = rgar( $_entry, '10.1' );
		$camps_in_full_2     = rgar( $_entry, '10.2' );


		$this->items      = "";

		/**
		 * Orientation Fee
		 */
		if ( null != $orientation_fee ) {
			$this->items .= "$orientation_fee; ";
		}

		/**
		 * Payment Options
		 */
		if ( null != $payment_options ) {
			$payment_option = $payment_options;
			$payment_option = explode( '|', $payment_option )[0];

			if ( null != $program ) {
				$program = explode( '|', $program )[0];
				$this->items .= "$payment_option: $program; ";
			}

			/**
			 * Camp Deposit Options
			 */
			if ( null != $camps_deposit_1 ) {
				$camps_deposit_1 = explode( '|', $camps_deposit_1 )[0];
				$this->items .= "$camps_deposit_1; ";
			}
			if ( null != $camps_deposit_2 ) {
				$camps_deposit_2 = explode( '|', $camps_deposit_2 )[0];
				$this->items .= "$camps_deposit_2; ";
			}

			/**
			 * Camp Balance Options
			 */
			if ( null != $camps_balance_1 ) {
				$camps_balance_1 = explode( '|', $camps_balance_1 )[0];
				$this->items .= "$camps_balance_1; ";
			}
			if ( null != $camps_balance_2 ) {
				$camps_balance_2 = explode( '|', $camps_balance_2 )[0];
				$this->items .= "$camps_balance_2; ";
			}

			/**
			 * Camp In Full Options
			 */
			if ( null != $camps_in_full_1 ) {
				$camps_in_full_1 = explode( '|', $camps_in_full_1 )[0];
				$this->items .= "$camps_in_full_1; ";
			}
			if ( null != $camps_in_full_2 ) {
				$camps_in_full_2 = explode( '|', $camps_in_full_2 )[0];
				$this->items .= "$camps_in_full_2; ";
			}
		}
		// remove trailing semicolon
		$this->items           = rtrim( $this->items, '; ' );
		$this->total           = rgar( $_entry, '12' );
		$this->referring_form  = rgar( $_entry, '17' );
		$this->referring_entry = rgar( $_entry, '18' );
		$this->form_id         = rgar( $_entry, 'form_id' );


		 //build transaction object
		if ( ! empty( $_entry['transaction_id'] ) ) {
			$this->transaction = new Transaction(
				rgar( $_entry, 'transaction_id' ),
				$this->form_id,
				null,
				null,
				$this->first_name,
				$this->last_name,
				$this->student_email,
				rgar( $_entry, 'payment_amount' ),
				null,
				rgar( $_entry, 'payment_date' ),
				null,
				null,
				null,
				rgar( $_entry, '14.1' ),
				rgar( $_entry, '14.2' ),
				rgar( $_entry, '14.3' ),
				rgar( $_entry, '14.4' ),
				rgar( $_entry, '14.5' )
			);

		}

	}
	//return transaction
	public function get_transaction() {
		return $this->transaction;
	}

	//return form id
	public function get_form_id() {
		return $this->form_id;
	}


}

