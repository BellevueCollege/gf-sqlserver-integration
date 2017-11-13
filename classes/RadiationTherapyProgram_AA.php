<?php
require_once('DB.php');
require_once('Transaction.php');

class RadiationTherapyProgram_AA
{
    protected $first_name;
    protected $last_name;
    protected $sid;
    protected $email;
    protected $phone;
    protected $other_email;
    protected $did_attend_info_session;
    protected $date_attended;
    
    protected $is_reapplicant;
    protected $year_last_applied;
    
    protected $did_compl_hospital_obs;
    protected $date_completed;
    
    protected $clinical_site_name;

    protected $personal_stmt;
    protected $reapplicant_stmt;
    protected $unofficial_transcript_1;
    protected $unofficial_transcript_2;
    protected $unofficial_transcript_3;
    protected $unofficial_transcript_4;
    
    protected $hospital_observation_form;
    
    protected $prerequisite;
    protected $signature;
    protected $transaction;
    protected $form_id;
    
    //public constructor
    public function __construct() {

    }

    //save data model
    public function save() {
        $db = new DB();
        $conn = $db->getDB();

        if ( $conn ) {
            try {
                $result = $this->transaction->save();   //save transaction first because of db constraint on trans id
                $tsql = 'EXEC [usp_InsertIntoAARadiationTherapyForm]'
                            . '@SID = :SID,'
                            . '@Fname = :FirstName,'
                            . '@Lname = :LastName,'
                            . '@Phone = :Phone,'
                            . '@Email = :Email,'  
                            . '@OtherEmail = :OtherEmail,'                              
                            . '@DidAttendInfoSession = :DidAttendInfoSession,'
                            . '@DateAttended = :DateAttended,'
                        
                            . '@IsReapplicant = :IsReapplicant,'
                            . '@YearLastApplied = :YearLastApplied,'
                        
                            . '@DidComplHospitalObs = :DidComplHospitalObs,'
                            . '@DateCompleted = :DateCompleted,'
                        
                            . '@ClinicalSiteName = :ClinicalSiteName,'
                            . '@PersonalStatement = :PersonalStatement,'
                            . '@ReApplicantStatement = :ReApplicantStatement,'
                            . '@UnofficialTranscript1 = :UnofficialTranscript1,'
                            . '@UnofficialTranscript2 = :UnofficialTranscript2,'
                            . '@UnofficialTranscript3 = :UnofficialTranscript3,'
                            . '@UnofficialTranscript4 = :UnofficialTranscript4,'
                        
                            . '@HospitalObservationForm = :HospitalObservationForm,'
                            . '@Prerequisite = :Prerequisite,'
                            . '@TransID = :TransID,'
                            . '@FormID = :FormID,'
                            . '@ElectronicSignature = :ElectronicSignature;';
                
                    $query = $conn->prepare( $tsql );                   
                    $input_data = array( 
                                        'SID' => $this->sid,
                                        'FirstName' => $this->first_name,
                                        'LastName' => $this->last_name, 
                                        'Phone' => $this->phone,
                                        'Email' => $this->email, 
                                        'OtherEmail' => $this->other_email,
                                        'DidAttendInfoSession' => $this->did_attend_info_session,
                                        'DateAttended' => $this->date_attended,
                        
                                        'IsReapplicant' => $this->is_reapplicant,
                                        'YearLastApplied' => $this->year_last_applied,
                        
                                        'DidComplHospitalObs' => $this->did_compl_hospital_obs,
                                        'DateCompleted' => $this->date_completed,
                        
                                        'ClinicalSiteName' => $this->clinical_site_name,
                                        'PersonalStatement' => $this->personal_stmt,
                                        'ReApplicantStatement' => $this->reapplicant_stmt,
                                        'UnofficialTranscript1' => $this->unofficial_transcript_1,
                                        'UnofficialTranscript2' => $this->unofficial_transcript_2,
                                        'UnofficialTranscript3' => $this->unofficial_transcript_3,
                                        'UnofficialTranscript4' => $this->unofficial_transcript_4,
                        
                                        'HospitalObservationForm' => $this->hospital_observation_form,
                                        'Prerequisite' => $this->prerequisite,
                                        'TransID' => $this->transaction->get_id(), 
                                        'FormID' => $this->form_id,
                                        'ElectronicSignature' => $this->signature
                                    );
                                    
                    $result = $query->execute($input_data);                   
                    //var_dump($result);
                    //var_dump($conn->errorCode());
                    //var_dump($conn->errorInfo());
                    return $result;
            } catch (PDOException $e) {
                error_log( print_r("PDOException in RadiationTherapyProgram_AA::save - " . $e->getMessage(), true) );
            } catch (Exception $e) {
                error_log( print_r("General exception in RadiationTherapyProgram_AA::save - " . $e->getMessage(), true) );
            }
        }       
        return false;
    }

    //fill in data model fields using form information
    public function build($_entry) {
        //set model info using entry values
        $this->first_name = !empty($_entry['2.3']) ? rgar($_entry, '2.3') : null;
        $this->last_name = !empty($_entry['2.6']) ? rgar($_entry, '2.6') : null;
        $this->sid = !empty($_entry['3']) ? rgar($_entry, '3') : null;
        $this->email = !empty($_entry['4']) ? rgar($_entry, '4') : null;
        $this->phone = !empty($_entry['5']) ? rgar($_entry, '5') : null;  
        $this->other_email = !empty($_entry['44']) ? rgar($_entry, '44') : null;
        if ( empty($_entry['16']) ) {
            $this->did_attend_info_session = null;
        } else if ( !empty($_entry['16']) && strtolower(rgar($_entry, '16')) == "yes" ) {
            $this->did_attend_info_session = true;
        } else {
            $this->did_attend_info_session = false;
        }  
        
        
        $this->date_attended = !empty($_entry['17']) ? rgar($_entry, '17') : null;
        
        if ( empty($_entry['18']) ) {
            $this->is_reapplicant = null;
        } else if ( !empty($_entry['18']) && strtolower(rgar($_entry, '18')) == "yes" ) {
            $this->is_reapplicant = true;
        } else {
            $this->is_reapplicant = false;
        }  
        $this->year_last_applied = !empty($_entry['19']) ? rgar($_entry, '19') : null;
        
        if ( empty($_entry['20']) ) {
            $this->did_compl_hospital_obs = null;
        } else if ( !empty($_entry['20']) && strtolower(rgar($_entry, '20')) == "yes" ) {
            $this->did_compl_hospital_obs = true;
        } else {
            $this->did_compl_hospital_obs = false;
        }  
        
        $this->date_completed = !empty($_entry['21']) ? rgar($_entry, '21') : null;
        $this->clinical_site_name = !empty($_entry['22']) ? rgar($_entry, '22') : null;
        $this->personal_stmt = !empty($_entry['23']) ? rgar($_entry, '23') : null;
        $this->reapplicant_stmt = !empty($_entry['43']) ? rgar($_entry, '43') : null;
        $this->unofficial_transcript_1 = !empty($_entry['25']) ? rgar($_entry, '25') : null;
        $this->unofficial_transcript_2 = !empty($_entry['26']) ? rgar($_entry, '26') : null;
        $this->unofficial_transcript_3 = !empty($_entry['27']) ? rgar($_entry, '27') : null;
        $this->unofficial_transcript_4 = !empty($_entry['28']) ? rgar($_entry, '28') : null;
        $this->hospital_observation_form = !empty($_entry['31']) ? rgar($_entry, '31') : null;
        $this->prerequisite = !empty($_entry['42']) ? rgar($_entry, '42') : null;
        
        $this->signature = !empty($_entry['36']) ? rgar($_entry, '36') : null;
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
            rgar($_entry, '38.1'),
            rgar($_entry, '38.2'),
            rgar($_entry, '38.3'),
            rgar($_entry, '38.4'),
            rgar($_entry, '38.5')
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