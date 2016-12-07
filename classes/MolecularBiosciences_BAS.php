<?php
require_once('DB.php');
require_once('Transaction.php');

class MolecularBiosciences_BAS
{
    protected $first_name;
    protected $last_name;
    protected $sid;
    protected $email;
    protected $phone;
    protected $is_reapplicant;
    protected $intended_program_start;
    protected $enroll_status;

    protected $req1_degree;
    protected $req1_school;

    protected $req2_course;
    protected $req2_quarter;
    protected $req2_grade;
    protected $req2_school;

    protected $req3_1_course;
    protected $req3_1_quarter;
    protected $req3_1_grade;
    protected $req3_1_school;

    protected $req3_2_course;
    protected $req3_2_quarter;
    protected $req3_2_grade;
    protected $req3_2_school;

    protected $req4_course;
    protected $req4_quarter;
    protected $req4_grade;
    protected $req4_school;

    protected $req5_course;
    protected $req5_quarter;
    protected $req5_grade;
    protected $req5_school;

    protected $req6_course;
    protected $req6_quarter;
    protected $req6_grade;
    protected $req6_school;

    protected $req7_course;
    protected $req7_quarter;
    protected $req7_grade;
    protected $req7_school;

    protected $req8_1_course;
    protected $req8_1_quarter;
    protected $req8_1_grade;
    protected $req8_1_school;

    protected $req8_2_course;
    protected $req8_2_quarter;
    protected $req8_2_grade;
    protected $req8_2_school;

    protected $req8_3_course;
    protected $req8_3_quarter;
    protected $req8_3_grade;
    protected $req8_3_school;

    protected $req9_course;
    protected $req9_quarter;
    protected $req9_grade;
    protected $req9_school;

    protected $req10_course;
    protected $req10_quarter;
    protected $req10_grade;
    protected $req10_school;

    protected $req11_course;
    protected $req11_quarter;
    protected $req11_grade;
    protected $req11_school;

    protected $req12_course;
    protected $req12_quarter;
    protected $req12_grade;
    protected $req12_school;

    protected $req13_1_course;
    protected $req13_1_quarter;
    protected $req13_1_grade;
    protected $req13_1_school;

    protected $req13_2_course;
    protected $req13_2_quarter;
    protected $req13_2_grade;
    protected $req13_2_school;

    protected $req14_course;
    protected $req14_quarter;
    protected $req14_grade;
    protected $req14_school;

    protected $personal_stmt;
    protected $diversity_stmt;

    protected $recommendation_1_name;
    protected $recommendation_1_title;
    protected $recommendation_1_relationship;

    protected $recommendation_2_name;
    protected $recommendation_2_title;
    protected $recommendation_2_relationship;

    protected $transcript;

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

        if ( $conn ) {
            try {
                $result = $this->transaction->save();   //save transaction first because of fk constraint in db
                $tsql = 'EXEC [usp_InsertIntoMolecularBiosciencesForm]'
                            . '@SID = :SID,'
                            . '@Fname = :FirstName,'
                            . '@Lname = :LastName,'
                            . '@Phone = :Phone,'
                            . '@BCEmail = :Email,'
                            . '@IsReapplicant = :IsReapplicant,'
                            . '@IntendedPS = :IntendedPS,'
                            . '@EnrollmentStatus = :EnrollmentStatus,'
                            . '@Req1DegreeCompleted = :Req1Degree,'
                            . '@Req1SchoolAttended = :Req1School,'
                            . '@Req2CourseNameNumber = :Req2Course,'
                            . '@Req2QuarterSemester = :Req2Quarter,' 
                            . '@Req2GradeEarned = :Req2Grade,'
                            . '@Req2SchoolAttended = :Req2School,'
                            . '@Req3aCourseNameNumber = :Req3aCourse,'
                            . '@Req3aQuarterSemester = :Req3aQuarter,' 
                            . '@Req3aGradeEarned = :Req3aGrade,'
                            . '@Req3aSchoolAttended = :Req3aSchool,'
                            . '@Req3bCourseNameNumber = :Req3bCourse,'
                            . '@Req3bQuarterSemester = :Req3bQuarter,'
                            . '@Req3bGradeEarned = :Req3bGrade,'
                            . '@Req3bSchoolAttended = :Req3bSchool,'
                            . '@Req4CourseNameNumber = :Req4Course,'
                            . '@Req4QuarterSemester = :Req4Quarter,'
                            . '@Req4GradeEarned = :Req4Grade,'
                            . '@Req4SchoolAttended = :Req4School,'
                            . '@Req5CourseNameNumber = :Req5Course,'
                            . '@Req5QuarterSemester = :Req5Quarter,'
                            . '@Req5GradeEarned = :Req5Grade,'
                            . '@Req5SchoolAttended = :Req5School,'
                            . '@Req6CourseNameNumber = :Req6Course,'
                            . '@Req6QuarterSemester = :Req6Quarter,'
                            . '@Req6GradeEarned = :Req6Grade,'
                            . '@Req6SchoolAttended = :Req6School,'
                            . '@Req7CourseNameNumber = :Req7Course,'
                            . '@Req7QuarterSemester = :Req7Quarter,'
                            . '@Req7GradeEarned = :Req7Grade,'
                            . '@Req7SchoolAttended = :Req7School,'
                            . '@Req8aCourseNameNumber = :Req8aCourse,'
                            . '@Req8aQuarterSemester = :Req8aQuarter,'
                            . '@Req8aGradeEarned = :Req8aGrade,'
                            . '@Req8aSchoolAttended = :Req8aSchool,'
                            . '@Req8bCourseNameNumber = :Req8bCourse,'
                            . '@Req8bQuarterSemester = :Req8bQuarter,'
                            . '@Req8bGradeEarned = :Req8bGrade,'
                            . '@Req8bSchoolAttended = :Req8bSchool,'
                            . '@Req8cCourseNameNumber = :Req8cCourse,'
                            . '@Req8cQuarterSemester = :Req8cQuarter,'
                            . '@Req8cGradeEarned = :Req8cGrade,'
                            . '@Req8cSchoolAttended = :Req8cSchool,'
                            . '@Req9CourseNameNumber = :Req9Course,'
                            . '@Req9QuarterSemester = :Req9Quarter,'
                            . '@Req9GradeEarned = :Req9Grade,'
                            . '@Req9SchoolAttended = :Req9School,'
                            . '@Req10CourseNameNumber = :Req10Course,'
                            . '@Req10QuarterSemester = :Req10Quarter,'
                            . '@Req10GradeEarned = :Req10Grade,'
                            . '@Req10SchoolAttended = :Req10School,'
                            . '@Req11CourseNameNumber = :Req11Course,'
                            . '@Req11QuarterSemester = :Req11Quarter,'
                            . '@Req11GradeEarned = :Req11Grade,'
                            . '@Req11SchoolAttended = :Req11School,'
                            . '@Req12CourseNameNumber = :Req12Course,'
                            . '@Req12QuarterSemester = :Req12Quarter,'
                            . '@Req12GradeEarned = :Req12Grade,'
                            . '@Req12SchoolAttended = :Req12School,'
                            . '@Req13aCourseNameNumber = :Req13aCourse,'
                            . '@Req13aQuarterSemester = :Req13aQuarter,'
                            . '@Req13aGradeEarned = :Req13aGrade,'
                            . '@Req13aSchoolAttended = :Req13aSchool,'
                            . '@Req13bCourseNameNumber = :Req13bCourse,'
                            . '@Req13bQuarterSemester = :Req13bQuarter,'
                            . '@Req13bGradeEarned = :Req13bGrade,'
                            . '@Req13bSchoolAttended = :Req13bSchool,'
                            . '@Req14CourseNameNumber = :Req14Course,'
                            . '@Req14QuarterSemester = :Req14Quarter,'
                            . '@Req14GradeEarned = :Req14Grade,'
                            . '@Req14SchoolAttended = :Req14School,'

                            . '@PersonalStatement = :PersonalStatement,'
                            . '@DiversityStatement = :DiversityStatement,'

                            . '@LOR1Name = :LOR1Name,'
                            . '@LOR1Title = :LOR1Title,'
                            . '@LOR1Relationship = :LOR1Relationship,'
                            . '@LOR2Name = :LOR2Name,'
                            . '@LOR2Title = :LOR2Title,'
                            . '@LOR2Relationship = :LOR2Relationship,'

                            . '@UnofficialTranscript = :UnofficialTranscript,'
                            . '@TransID = :TransID,'
                            . '@FormID = :FormID,'
                            . '@ElectronicSignature = :ElectronicSignature;';
                    $query = $conn->prepare( $tsql );
                    $input_data = array( 
                                        'FirstName' => $this->first_name,
                                        'LastName' => $this->last_name, 
                                        'SID' => $this->sid,
                                        'Email' => $this->email,
                                        'Phone' => $this->phone,
                                        'IsReapplicant' => $this->is_reapplicant,
                                        'IntendedPS' => $this->intended_program_start,
                                        'EnrollmentStatus' => $this->enroll_status,
                                        'Req1Degree' => $this->req1_degree,
                                        'Req1School' => $this->req1_school,

                                        'Req2Course' => $this->req2_course,
                                        'Req2Quarter' => $this->req2_quarter,
                                        'Req2Grade' => $this->req2_grade,
                                        'Req2School' => $this->req2_school,

                                        'Req3aCourse' => $this->req3_1_course,
                                        'Req3aQuarter' => $this->req3_1_quarter,
                                        'Req3aGrade' => $this->req3_1_grade,
                                        'Req3aSchool' => $this->req3_1_school,
                                        'Req3bCourse' => $this->req3_2_course,
                                        'Req3bQuarter' => $this->req3_2_quarter,
                                        'Req3bGrade' => $this->req3_2_grade,
                                        'Req3bSchool' => $this->req3_2_school,

                                        'Req4Course' => $this->req4_course,
                                        'Req4Quarter' => $this->req4_quarter,
                                        'Req4Grade' => $this->req4_grade,
                                        'Req4School' => $this->req4_school,

                                        'Req5Course' => $this->req5_course,
                                        'Req5Quarter' => $this->req5_quarter,
                                        'Req5Grade' => $this->req5_grade,
                                        'Req5School' => $this->req5_school,

                                        'Req6Course' => $this->req6_course,
                                        'Req6Quarter' => $this->req6_quarter,
                                        'Req6Grade' => $this->req6_grade,
                                        'Req6School' => $this->req6_school,

                                        'Req7Course' => $this->req7_course,
                                        'Req7Quarter' => $this->req7_quarter,
                                        'Req7Grade' => $this->req7_grade,
                                        'Req7School' => $this->req7_school,

                                        'Req8aCourse' => $this->req8_1_course,
                                        'Req8aQuarter' => $this->req8_1_quarter,
                                        'Req8aGrade' => $this->req8_1_grade,
                                        'Req8aSchool' => $this->req8_1_school,
                                        'Req8bCourse' => $this->req8_2_course,
                                        'Req8bQuarter' => $this->req8_2_quarter,
                                        'Req8bGrade' => $this->req8_2_grade,
                                        'Req8bSchool' => $this->req8_2_school,
                                        'Req8cCourse' => $this->req8_3_course,
                                        'Req8cQuarter' => $this->req8_3_quarter,
                                        'Req8cGrade' => $this->req8_3_grade,
                                        'Req8cSchool' => $this->req8_3_school,

                                        'Req9Course' => $this->req9_course,
                                        'Req9Quarter' => $this->req9_quarter,
                                        'Req9Grade' => $this->req9_grade,
                                        'Req9School' => $this->req9_school,

                                        'Req10Course' => $this->req10_course,
                                        'Req10Quarter' => $this->req10_quarter,
                                        'Req10Grade' => $this->req10_grade,
                                        'Req10School' => $this->req10_school,

                                        'Req11Course' => $this->req11_course,
                                        'Req11Quarter' => $this->req11_quarter,
                                        'Req11Grade' => $this->req11_grade,
                                        'Req11School' => $this->req11_school,

                                        'Req12Course' => $this->req12_course,
                                        'Req12Quarter' => $this->req12_quarter,
                                        'Req12Grade' => $this->req12_grade,
                                        'Req12School' => $this->req12_school,

                                        'Req13aCourse' => $this->req13_1_course,
                                        'Req13aQuarter' => $this->req13_1_quarter,
                                        'Req13aGrade' => $this->req13_1_grade,
                                        'Req13aSchool' => $this->req13_1_school,
                                        'Req13bCourse' => $this->req13_2_course,
                                        'Req13bQuarter' => $this->req13_2_quarter,
                                        'Req13bGrade' => $this->req13_2_grade,
                                        'Req13bSchool' => $this->req13_2_school,

                                        'Req14Course' => $this->req14_course,
                                        'Req14Quarter' => $this->req14_quarter,
                                        'Req14Grade' => $this->req14_grade,
                                        'Req14School' => $this->req14_school,

                                        'PersonalStatement' => $this->personal_stmt,
                                        'DiversityStatement' => $this->diversity_stmt,
                                        'LOR1Name' => $this->recommendation_1_name,
                                        'LOR1Title' => $this->recommendation_1_title,
                                        'LOR1Relationship' => $this->recommendation_1_relationship,
                                        'LOR2Name' => $this->recommendation_2_name,
                                        'LOR2Title' => $this->recommendation_2_title,
                                        'LOR2Relationship' => $this->recommendation_2_relationship,
                                        'UnofficialTranscript' => $this->transcript,
                                        'TransID' => $this->transaction->get_id(), 
                                        'FormID' => $this->form_id,
                                        'ElectronicSignature' => $this->signature
                                    );

                    $result = $query->execute($input_data);
//                    var_dump($input_data);
//                    var_dump($result);
//                    var_dump($conn->errorCode());
//                    var_dump($conn->errorInfo());
                    return $result;
            } catch (PDOException $e) {
                error_log( print_r("PDOException in MolecularBiosciences_BAS::save - " . $e->getMessage(), true) );
            } catch (Exception $e) {
                error_log( print_r("General exception in MolecularBiosciences_BAS::save - " . $e->getMessage(), true) );
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

        if ( empty($_entry['24']) ) {
            $this->is_reapplicant = null;
        } else if ( !empty($_entry['24']) && strtolower(rgar($_entry, '24')) == "yes" ) {
            $this->is_reapplicant = true;
        } else {
            $this->is_reapplicant = false;
        }  

        $this->intended_program_start = !empty($_entry['8']) ? rgar($_entry, '8') : null;      
        $this->enroll_status = !empty($_entry['9']) ? rgar($_entry, '9') : null;

        $this->req1_degree = !empty($_entry['27']) ? rgar($_entry, '27') : null;
        $this->req1_school = !empty($_entry['28']) ? rgar($_entry, '28') : null;

        $this->req2_course = !empty($_entry['30']) ? rgar($_entry, '30') : null;
        $this->req2_quarter = !empty($_entry['33']) ? rgar($_entry, '33') : null;
        $this->req2_grade = !empty($_entry['31']) ? rgar($_entry, '31') : null;
        $this->req2_school = !empty($_entry['32']) ? rgar($_entry, '32') : null;

        $this->req3_1_course = !empty($_entry['35']) ? rgar($_entry, '35') : null;
        $this->req3_1_quarter = !empty($_entry['36']) ? rgar($_entry, '36') : null;
        $this->req3_1_grade = !empty($_entry['37']) ? rgar($_entry, '37') : null;
        $this->req3_1_school = !empty($_entry['38']) ? rgar($_entry, '38') : null;

        $this->req3_2_course = !empty($_entry['40']) ? rgar($_entry, '40') : null;
        $this->req3_2_quarter = !empty($_entry['41']) ? rgar($_entry, '41') : null;
        $this->req3_2_grade = !empty($_entry['42']) ? rgar($_entry, '42') : null;
        $this->req3_2_school = !empty($_entry['43']) ? rgar($_entry, '43') : null;

        $this->req4_course = !empty($_entry['44']) ? rgar($_entry, '44') : null;
        $this->req4_quarter = !empty($_entry['47']) ? rgar($_entry, '47') : null;
        $this->req4_grade = !empty($_entry['46']) ? rgar($_entry, '46') : null;
        $this->req4_school = !empty($_entry['45']) ? rgar($_entry, '45') : null;

        $this->req5_course = !empty($_entry['49']) ? rgar($_entry, '49') : null;
        $this->req5_quarter = !empty($_entry['50']) ? rgar($_entry, '50') : null;
        $this->req5_grade = !empty($_entry['51']) ? rgar($_entry, '51') : null;
        $this->req5_school = !empty($_entry['52']) ? rgar($_entry, '52') : null;

        $this->req6_course = !empty($_entry['54']) ? rgar($_entry, '54') : null;
        $this->req6_quarter = !empty($_entry['55']) ? rgar($_entry, '55') : null;
        $this->req6_grade = !empty($_entry['56']) ? rgar($_entry, '56') : null;
        $this->req6_school = !empty($_entry['57']) ? rgar($_entry, '57') : null;

        $this->req7_course = !empty($_entry['59']) ? rgar($_entry, '59') : null;
        $this->req7_quarter = !empty($_entry['60']) ? rgar($_entry, '60') : null;
        $this->req7_grade = !empty($_entry['61']) ? rgar($_entry, '61') : null;
        $this->req7_school = !empty($_entry['62']) ? rgar($_entry, '62') : null;

        $this->req8_1_course = !empty($_entry['64']) ? rgar($_entry, '64') : null;
        $this->req8_1_quarter = !empty($_entry['65']) ? rgar($_entry, '65') : null;
        $this->req8_1_grade = !empty($_entry['66']) ? rgar($_entry, '66') : null;
        $this->req8_1_school = !empty($_entry['67']) ? rgar($_entry, '67') : null;

        $this->req8_2_course = !empty($_entry['68']) ? rgar($_entry, '68') : null;
        $this->req8_2_quarter = !empty($_entry['69']) ? rgar($_entry, '69') : null;
        $this->req8_2_grade = !empty($_entry['70']) ? rgar($_entry, '70') : null;
        $this->req8_2_school = !empty($_entry['71']) ? rgar($_entry, '71') : null;

        $this->req8_3_course = !empty($_entry['72']) ? rgar($_entry, '72') : null;
        $this->req8_3_quarter = !empty($_entry['73']) ? rgar($_entry, '73') : null;
        $this->req8_3_grade = !empty($_entry['74']) ? rgar($_entry, '74') : null;
        $this->req8_3_school = !empty($_entry['75']) ? rgar($_entry, '75') : null;

        $this->req9_course = !empty($_entry['77']) ? rgar($_entry, '77') : null;
        $this->req9_quarter = !empty($_entry['78']) ? rgar($_entry, '78') : null;
        $this->req9_grade = !empty($_entry['79']) ? rgar($_entry, '79') : null;
        $this->req9_school = !empty($_entry['80']) ? rgar($_entry, '80') : null;

        $this->req10_course = !empty($_entry['82']) ? rgar($_entry, '82') : null;
        $this->req10_quarter = !empty($_entry['83']) ? rgar($_entry, '83') : null;
        $this->req10_grade = !empty($_entry['84']) ? rgar($_entry, '84') : null;
        $this->req10_school = !empty($_entry['85']) ? rgar($_entry, '85') : null;

        $this->req11_course = !empty($_entry['87']) ? rgar($_entry, '87') : null;
        $this->req11_quarter = !empty($_entry['88']) ? rgar($_entry, '88') : null;
        $this->req11_grade = !empty($_entry['89']) ? rgar($_entry, '89') : null;
        $this->req11_school = !empty($_entry['90']) ? rgar($_entry, '90') : null;

        $this->req12_course = !empty($_entry['92']) ? rgar($_entry, '92') : null;
        $this->req12_quarter = !empty($_entry['93']) ? rgar($_entry, '93') : null;
        $this->req12_grade = !empty($_entry['94']) ? rgar($_entry, '94') : null;
        $this->req12_school = !empty($_entry['95']) ? rgar($_entry, '95') : null;

        $this->req13_1_course = !empty($_entry['97']) ? rgar($_entry, '97') : null;
        $this->req13_1_quarter = !empty($_entry['98']) ? rgar($_entry, '98') : null;
        $this->req13_1_grade = !empty($_entry['99']) ? rgar($_entry, '99') : null;
        $this->req13_1_school = !empty($_entry['100']) ? rgar($_entry, '100') : null;

        $this->req13_2_course = !empty($_entry['101']) ? rgar($_entry, '101') : null;
        $this->req13_2_quarter = !empty($_entry['102']) ? rgar($_entry, '102') : null;
        $this->req13_2_grade = !empty($_entry['103']) ? rgar($_entry, '103') : null;
        $this->req13_2_school = !empty($_entry['104']) ? rgar($_entry, '104') : null;

        $this->req14_course = !empty($_entry['106']) ? rgar($_entry, '106') : null;
        $this->req14_quarter = !empty($_entry['107']) ? rgar($_entry, '107') : null;
        $this->req14_grade = !empty($_entry['108']) ? rgar($_entry, '108') : null;
        $this->req14_school = !empty($_entry['109']) ? rgar($_entry, '109') : null;

        $this->personal_stmt = !empty($_entry['118']) ? rgar($_entry, '118') : null;
        $this->diversity_stmt = !empty($_entry['119']) ? rgar($_entry, '119') : null;

        //set recommendation data
        if ( !empty($_entry['112']) ){
            $reco_data = unserialize(rgar( $_entry, '112' ));

            $this->recommendation_1_name = !empty($reco_data[0]["Name"]) ? $reco_data[0]["Name"] : null;
            $this->recommendation_1_title = !empty($reco_data[0]["Title"]) ? $reco_data[0]["Title"] : null;
            $this->recommendation_1_relationship = !empty($reco_data[0]["Relationship"]) ? $reco_data[0]["Relationship"] : null;

            $this->recommendation_2_name = !empty($reco_data[1]["Name"]) ? $reco_data[1]["Name"] : null;
            $this->recommendation_2_title = !empty($reco_data[1]["Title"]) ? $reco_data[1]["Title"] : null;
            $this->recommendation_2_relationship = !empty($reco_data[1]["Relationship"]) ? $reco_data[1]["Relationship"] : null;
        } else {
            $this->recommendation_1_name = null;
            $this->recommendation_1_title = null;
            $this->recommendation_1_relationship = null;

            $this->recommendation_2_name = null;
            $this->recommendation_2_title = null;
            $this->recommendation_2_relationship = null;
        }

        $this->transcript = !empty($_entry['14']) ? rgar($_entry, '14') : null;
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
            null,
            rgar($_entry, 'payment_date'),
            null,
            null,
            null,
            rgar($_entry, '117.1'),
            rgar($_entry, '117.2'),
            rgar($_entry, '117.3'),
            rgar($_entry, '117.4'),
            rgar($_entry, '117.5')
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