<?php
require_once('DB.php');
require_once('Transaction.php');

class Nursing_RN_BSN
{
    protected $first_name;
    protected $last_name;
    protected $sid;
    protected $email;
    protected $phone;
    protected $enroll_status;
    protected $currently_enrolled_adn;
    protected $adn_institution;
    protected $adn_graduation_date;
    protected $rn_license_number;
    protected $rn_license_expiration;
    protected $personal_essay;
    protected $transcript_1;
    protected $transcript_2;
    protected $transcript_3;
    protected $resume;
    protected $signature;
    protected $transaction;
    protected $form_id;
    
    //public constructor
    public function __construct() {

    }

    //save data model to external db
    public function save() {
        $db = new DB();
        $conn = $db->getDB();
        //echo "<pre>Input encoding: " . mb_detect_encoding($this->first_name) . "</pre>";
        //echo "<pre>Textarea encoding: " . mb_detect_encoding($this->personal_stmt) . "</pre>";
        if ( $conn ) {
            try {
                $result = $this->transaction->save();   //save transaction first, FK constraint in db
                $tsql = 'EXEC [usp_InsertIntoNursingForm]'
                            . '@TransID = :TransID,'
                            . '@Fname = :FirstName,'
                            . '@Lname = :LastName,'
                            . '@FormID = :FormID,'
                            . '@SID = :SID,'
                            . '@Email = :Email,'
                            . '@Phone = :Phone,'
                            . '@IsEnrolledInADN = :IsEnrolledInADN,'
                            . '@ADNInstitution = :ADNInstitution,'
                            . '@ProjectedGraduationDate = :ADNGraduationDate,'
                            . '@RNLicenseNo = :RNLicenseNumber,'
                            . '@LicenseExpirationDate = :RNLicenseExpiration,'
                            . '@PersonalEssay = :PersonalEssay,'
                            . '@UnofficialTrans1 = :UnofficialTranscript1,'
                            . '@UnofficialTrans2 = :UnofficialTranscript2,'
                            . '@UnofficialTrans3 = :UnofficialTranscript3,'
                            . '@Resume = :Resume,'
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
                                        'IsEnrolledInADN' => $this->currently_enrolled_adn,
                                        'ADNInstitution' => $this->adn_institution,
                                        'ADNGraduationDate' => $this->adn_graduation_date,
                                        'RNLicenseNumber' => $this->rn_license_number,
                                        'RNLicenseExpiration' => $this->rn_license_expiration,
                                        'PersonalEssay' => $this->personal_essay,
                                        'UnofficialTranscript1' => $this->transcript_1,
                                        'UnofficialTranscript2' => $this->transcript_2,
                                        'UnofficialTranscript3' => $this->transcript_3,
                                        'Resume' => $this->resume,
                                        'EnrollmentStatus' => $this->enroll_status,
                                        'ElectronicSignature' => $this->signature
                                    );
                    $result = $query->execute($input_data);
                    //var_dump($result);
                    //var_dump($conn->errorCode());
                    //var_dump($conn->errorInfo());
                    return $result;
            } catch (PDOException $e) {
                error_log( print_r("PDOException in Nursing_RN_BSN::save - " . $e->getMessage(), true) );
            } catch (Exception $e) {
                error_log( print_r("General exception in Nursing_RN_BSN::save - " . $e->getMessage(), true) );
            }
        }       
        return false;
    }

    //fill in data model fields using submitted form info
    public function build($_entry) {
        //set model info using entry values
        $this->first_name = !empty($_entry['1.3']) ? rgar($_entry, '1.3') : null;
        $this->last_name = !empty($_entry['1.6']) ? rgar($_entry, '1.6') : null;
        $this->sid = !empty($_entry['3']) ? rgar($_entry, '3') : null;
        $this->email = !empty($_entry['4']) ? rgar($_entry, '4') : null;
        $this->phone = !empty($_entry['5']) ? rgar($_entry, '5') : null;
        $this->enroll_status = !empty($_entry['9']) ? rgar($_entry, '9') : null;

        if ( empty($_entry['24']) ) {
            $this->currently_enrolled_adn = null;
        } else if ( !empty($_entry['24']) && strtolower(rgar($_entry, '24')) == "yes" ) {
            $this->currently_enrolled_adn = true;
        } else {
            $this->currently_enrolled_adn = false;
        }
        $this->adn_institution = !empty($_entry['25']) ? rgar($_entry, '25') : null;
        $this->adn_graduation_date = !empty($_entry['26']) ? rgar($_entry, '26') : null;
        $this->rn_license_number = !empty($_entry['27']) ? rgar($_entry, '27') : null;
        $this->rn_license_expiration = !empty($_entry['29']) ? rgar($_entry, '29') : null;

        $this->personal_essay = !empty($_entry['30']) ? rgar($_entry, '30') : null;
        $this->transcript_1 = !empty($_entry['14']) ? rgar($_entry, '14') : null;
        $this->transcript_2 = !empty($_entry['32']) ? rgar($_entry, '32') : null;
        $this->transcript_3 = !empty($_entry['33']) ? rgar($_entry, '33') : null;
        $this->resume = !empty($_entry['31']) ? rgar($_entry, '31') : null;
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
            rgar($_entry, '34.1'),
            rgar($_entry, '34.2'),
            rgar($_entry, '34.3'),
            rgar($_entry, '34.4'),
            rgar($_entry, '34.5')
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