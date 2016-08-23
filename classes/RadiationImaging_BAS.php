<?php
require_once('DB.php');
require_once('Transaction.php');

class RadiationImaging_BAS
{
    protected $first_name;
    protected $last_name;
    protected $sid;
    protected $email;
    protected $phone;
    protected $enroll_status;
    protected $concentration;
    protected $have_certification;
    protected $certification_file;
    protected $anticipated_certificate;
    protected $anticipated_certificate_date;
    protected $transcript_1;
    protected $transcript_2;
    protected $transcript_3;
    protected $personal_stmt;
    protected $signature;
    protected $transaction;
    protected $form_id;
    
    public function __construct() {

    }

    public function save() {
        $db = new DB();
        $conn = $db->getDB();
        //var_dump($conn);
        //echo "<pre>Input encoding: " . mb_detect_encoding($this->first_name) . "</pre>";
        //echo "<pre>Textarea encoding: " . mb_detect_encoding($this->personal_stmt) . "</pre>";
        if ( $conn ) {
            try {
                $result = $this->transaction->save();   //save transaction first because of db constraint on trans id

                $tsql = 'EXEC [usp_InsertIntoRadiationandImagingScienceForm]'
                            . '@TransID = :TransID,'
                            . '@Fname = :FirstName,'
                            . '@Lname = :LastName,'
                            . '@FormID = :FormID,'
                            . '@SID = :SID,'
                            . '@BCEmail = :Email,'
                            . '@Phone = :Phone,'
                            . '@Concentration = :Concentration,'
                            . '@HaveNationalCertification = :HaveCertification,'
                            . '@CurrentCertificationFile = :CertificationFile,'
                            . '@AnticipatedCertificate = :AnticipatedCertificate,'
                            . '@AnticipatedCertCompletionDate = :AnticipatedCertCompletionDate,'
                            . '@UnofficialTrans1 = :UnofficialTranscript1,'
                            . '@UnofficialTrans2 = :UnofficialTranscript2,'
                            . '@UnofficialTrans3 = :UnofficialTranscript3,'
                            . '@PersonalStatement = :PersonalStatement,'
                            . '@EnrollmentStatus = :EnrollmentStatus,'
                            . '@ElectronicSignature = :ElectronicSignature;';
                    $query = $conn->prepare( $tsql );
                    $input_data = array( 
                                    'TransID' => $this->transaction->get_id(), 
                                    'FirstName' => $this->first_name,
                                    'LastName' => $this->last_name, 
                                    'FormID' => $this->form_id,
                                    'SID' => $this->sid,
                                    'Email' => $this->email,
                                    'Phone' => $this->phone,
                                    'Concentration' => $this->concentration,
                                    'HaveCertification' => $this->have_certification,
                                    'CertificationFile' => $this->certification_file,
                                    'AnticipatedCertificate' => $this->anticipated_certificate,
                                    'AnticipatedCertCompletionDate' => $this->anticipated_certificate_date,
                                    'UnofficialTranscript1' => $this->transcript_1,
                                    'UnofficialTranscript2' => $this->transcript_2,
                                    'UnofficialTranscript3' => $this->transcript_3,
                                    'PersonalStatement' => $this->personal_stmt,
                                    'EnrollmentStatus' => $this->enroll_status,
                                    'ElectronicSignature' => $this->signature
                                );

                    $result = $query->execute($input_data);
                    //var_dump($result);
                    //var_dump($conn->errorCode());
                    //var_dump($conn->errorInfo());

                    return $result;
            } catch (PDOException $e) {
                error_log( print_r("PDOException in RadiationImaging_BAS::save - " . $e->getMessage(), true) );
            } catch (Exception $e) {
                error_log( print_r("General exception in RadiationImaging_BAS::save - " . $e->getMessage(), true) );
            }
        }       
        return false;
    }

    public function build($_entry) {
        //set model info using entry values
        $this->first_name = !empty($_entry['1.3']) ? rgar($_entry, '1.3') : null;
        $this->last_name = !empty($_entry['1.6']) ? rgar($_entry, '1.6') : null;
        $this->sid = !empty($_entry['3']) ? rgar($_entry, '3') : null;
        $this->email = !empty($_entry['4']) ? rgar($_entry, '4') : null;
        $this->phone = !empty($_entry['5']) ? rgar($_entry, '5') : null;
        $this->enroll_status = !empty($_entry['9']) ? rgar($_entry, '9') : null;
        $this->concentration = !empty($_entry['25']) ? rgar($_entry, '25') : null;

        if ( empty($_entry['34']) ) {
            $this->have_certification = null;
        } else if ( !empty($_entry['34']) && strtolower(rgar($_entry, '34')) == "yes" ) {
            $this->have_certification = true;
        } else {
            $this->have_certification = false;
        }

        $this->certification_file = !empty($_entry['37']) ? rgar($_entry, '37') : null;
        $this->anticipated_certificate = !empty($_entry['35']) ? rgar($_entry, '35') : null;
        $this->anticipated_certificate_date = !empty($_entry['36']) ? rgar($_entry, '36') : null;

        $this->transcript_1 = !empty($_entry['14']) ? rgar($_entry, '14') : null;
        $this->transcript_2 = !empty($_entry['42']) ? rgar($_entry, '42') : null;
        $this->transcript_3 = !empty($_entry['43']) ? rgar($_entry, '43') : null;
        $this->personal_stmt = !empty($_entry['12']) ? rgar($_entry, '12') : null;
        $this->signature = !empty($_entry['23']) ? rgar($_entry, '23') : null;
        $this->form_id = rgar($_entry, 'form_id');

        //build transaction object
        $this->transaction = new Transaction(
            rgar($_entry, 'transaction_id'),
            $this->form_id,
            $this->sid,
            $this->first_name,
            $this->last_name,
            $this->email,
            rgar($_entry, 'payment_amount'),
            rgar($_entry, 'payment_status'),
            rgar($_entry, 'payment_date'),
            null,
            null,
            null,
            rgar($_entry, '46.1'),
            rgar($_entry, '46.2'),
            rgar($_entry, '46.3'),
            rgar($_entry, '46.4'),
            rgar($_entry, '46.5')
        );
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