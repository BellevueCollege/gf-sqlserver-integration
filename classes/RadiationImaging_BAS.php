<?php
require_once('DB.php');
require_once('Transaction.php');

class RadiationImaging_BAS
{
    protected $first_name;
    protected $last_name;
    protected $sid;
    protected $email;
    protected $personal_email;
    protected $phone;
    protected $enroll_status;
    protected $concentration;
    protected $have_certification;
    protected $certification_file;
    protected $anticipated_certificate; // Removed in form, but required in Stored Procedure.
    protected $anticipated_certificate_date;
    protected $transcript_1;
    protected $transcript_2;
    protected $transcript_3;
    protected $attended_college_1;
    protected $attended_college_2;
    protected $attended_college_3;

    protected $personal_stmt;
    protected $signature;
    protected $transaction;
    protected $form_id;
    protected $applying_program;
    protected $desired_qtr_start;
    protected $interested_in_clinical_practium;
    protected $clinical_applying_for;
    protected $desired_clinical_practium_for;
    protected $desired_clinical_region;
   // protected $certification_requirement;
    protected $certifying_organization;

    //public constructor
    public function __construct() {

    }

    //save data model to external db
    public function save() {
        $db = new DB();
        $conn = $db->getDB();

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
                            . '@PersonalEmail = :PersonalEmail,'
                            . '@Phone = :Phone,'
                            . '@Concentration = :Concentration,'
                            . '@HaveNationalCertification = :HaveCertification,'
                            . '@CurrentCertificationFile = :CertificationFile,'
                            . '@AnticipatedCertificate = :AnticipatedCertificate,' // Removed in form, but required in Stored Procedure.
                            . '@AnticipatedCertCompletionDate = :AnticipatedCertCompletionDate,'
                            . '@UnofficialTrans1 = :UnofficialTranscript1,' // Removed in form, but required in Stored Procedure.
                            . '@UnofficialTrans2 = :UnofficialTranscript2,' // Removed in form, but required in Stored Procedure.
                            . '@UnofficialTrans3 = :UnofficialTranscript3,' // Removed in form, but required in Stored Procedure.
                            . '@CollegeAttended1 = :CollegeAttended1,'
                            . '@CollegeAttended2 = :CollegeAttended2,'
                            . '@CollegeAttended3 = :CollegeAttended3,'

                            . '@PersonalStatementupload = :PersonalStatement,' // Personal stmt field changed from text to file upload
                            . '@EnrollmentStatus = :EnrollmentStatus,'
                            . '@ElectronicSignature = :ElectronicSignature,'
                            . '@ApplyingProgram = :ApplyingProgram,'
                            . '@desiredQtrStart = :DesiredQtrStart,'
                            . '@interestedInClinicalPracticum = :ClinicalPracticum,'
                            . '@clinicalApplyingFor = :ClinicalApplyingFor,'
                            . '@desiredClinicalPracQtr = :DesiredClinicalPracQtr,'
                            . '@desiredClinicalRegion = :DesiredClinicalRegion,'
                            //. '@certificationRequirement = :CertificationRequirement'
                            . '@certifyingOrganization = :CertifyingOrganization'
                            . ';';
                    $query = $conn->prepare( $tsql );
                    $input_data = array(
                                    'TransID' => $this->transaction->get_id(),
                                    'FirstName' => $this->first_name,
                                    'LastName' => $this->last_name,
                                    'FormID' => $this->form_id,
                                    'SID' => $this->sid,
                                    'Email' => $this->email,
                                    'PersonalEmail' => $this->personal_email,
                                    'Phone' => $this->phone,
                                    'Concentration' => $this->concentration,
                                    'HaveCertification' => $this->have_certification,
                                    'CertificationFile' => $this->certification_file,
                                    'AnticipatedCertificate' => $this->anticipated_certificate, // Removed in form, but required in Stored Procedure.
                                    'AnticipatedCertCompletionDate' => $this->anticipated_certificate_date,
                                    'UnofficialTranscript1' => $this->transcript_1, // Removed in form, but required in Stored Procedure.
                                    'UnofficialTranscript2' => $this->transcript_2, // Removed in form, but required in Stored Procedure.
                                    'UnofficialTranscript3' => $this->transcript_3, // Removed in form, but required in Stored Procedure.
                                    'CollegeAttended1' => $this->attended_college_1,
                                    'CollegeAttended2' => $this->attended_college_2,
                                    'CollegeAttended3' => $this->attended_college_3,
                                    'PersonalStatement' => $this->personal_stmt,
                                    'EnrollmentStatus' => $this->enroll_status,
                                    'ElectronicSignature' => $this->signature,
                                    'ApplyingProgram' => $this->applying_program,
                                    'DesiredQtrStart' => $this->desired_qtr_start,
                                    'ClinicalPracticum' => $this->interested_in_clinical_practium,
                                    'ClinicalApplyingFor' => $this->clinical_applying_for,
                                    'DesiredClinicalPracQtr' => $this->desired_clinical_practium_for,
                                    'DesiredClinicalRegion' => $this->desired_clinical_region,
                                 //   'CertificationRequirement' => $this->certification_requirement,
                                    'CertifyingOrganization' => $this->certifying_organization
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

    //fill in data model fields using submitted form info
    public function build($_entry) {
        //set model info using entry values
        $this->first_name = !empty($_entry['1.3']) ? rgar($_entry, '1.3') : null;
        $this->last_name = !empty($_entry['1.6']) ? rgar($_entry, '1.6') : null;
        $this->sid = !empty($_entry['3']) ? rgar($_entry, '3') : null;
        $this->email = !empty($_entry['4']) ? rgar($_entry, '4') : null;
        $this->personal_email = !empty($_entry['57']) ? rgar($_entry, '57') : null;
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
        $this->anticipated_certificate = !empty($_entry['35']) ? rgar($_entry, '35') : null; // Removed in form, but required in Stored Procedure.
        $this->anticipated_certificate_date = !empty($_entry['36']) ? rgar($_entry, '36') : null;

        $this->transcript_1 = !empty($_entry['14']) ? rgar($_entry, '14') : null; // Removed in form, but required in Stored Procedure.
        $this->transcript_2 = !empty($_entry['42']) ? rgar($_entry, '42') : null; // Removed in form, but required in Stored Procedure.
        $this->transcript_3 = !empty($_entry['43']) ? rgar($_entry, '43') : null; // Removed in form, but required in Stored Procedure.
        $this->attended_college_1 = !empty($_entry['59']) ? rgar($_entry, '59') : null;
        $this->attended_college_2 = !empty($_entry['60']) ? rgar($_entry, '60') : null;
        $this->attended_college_3 = !empty($_entry['61']) ? rgar($_entry, '61') : null;

        $this->personal_stmt = !empty($_entry['55']) ? rgar($_entry, '55') : null;
        $this->signature = !empty($_entry['23']) ? rgar($_entry, '23') : null;
        $this->applying_program = !empty($_entry['47']) ? rgar($_entry, '47') : null;
        $this->desired_qtr_start = !empty($_entry['48']) ? rgar($_entry, '48') : null;
        $this->interested_in_clinical_practium = !empty($_entry['50']) ? rgar($_entry, '50') : null;
        $this->clinical_applying_for = !empty($_entry['51']) ? rgar($_entry, '51') : null;
        $this->desired_clinical_practium_for = !empty($_entry['52']) ? rgar($_entry, '52') : null;
        $this->desired_clinical_region = !empty($_entry['53']) ? rgar($_entry, '53') : null;

        $this->certifying_organization = !empty($_entry['54']) ? rgar($_entry, '54') : null;
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
            null,
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
