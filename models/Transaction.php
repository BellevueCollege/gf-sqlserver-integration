<?php
//namespace models;
require_once('BaseModel.php');
//use BaseModel;

class Transaction extends BaseModel
{
    	protected $id;  //transaction id
        protected $form_id; //ID of form transaction belongs to
        protected $first_name;  //first name
        protected $last_name;   //last name


		public function __construct($_id, $_form_id, $_first_name, $_last_name) {
            parent::construct();

            $this->id = $_id;
            $this->form_id = $_form_id;
            $this->first_name = $_first_name;
            $this->last_name = $_last_name;
        }	

        public function save() {
            /*$tsql = 'EXEC [usp_InsertTransaction]'
                    . '@TranStatus = :TransactionStatus,'
                    . '@SettleTime = :SettlementTime,'
                    . '@TransID = :TransactionID,'
                    . '@OInvoiceNum = :InvoiceNumber,'
                    . '@Odesc = :OrderDescription,'
                    . '@CardNum = :CardNumber,'
                    . '@CardType = :CardType,'
                    . '@FName = :FirstName,'
                    . '@LName = :LastName,'
                    . '@Address = :Address,'
                    . '@City = :City,'
                    . '@State = :State,'
                    . '@Zip = :Zip,'
                    . '@country = :Country ;';
            $query = $this->db->prepare( $tsql );
            $input_data = array( 'TransactionStatus' => $transaction_status ,
                                 'SettlementTime' => $settlement_time ,
                                 'TransactionID' => $transaction_id, 
                                 'InvoiceNumber' => $invoice_number,
                                 'OrderDescription' => $order_description,
                                 'CardNumber' => $card_number,
                                 'CardType' => $card_type,
                                 'FirstName' => $firstname,
                                 'LastName' => $lastname ,
                                 'Address' => $address,
                                 'City' => $city,
                                 'State' => $state,
                                 'Zip' => $zip,
                                 'Country' => $country
                               );
            
             $result = $query->execute($input_data);        
             return $result;*/
        }		
		
}