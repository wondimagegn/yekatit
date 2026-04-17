<?php
App::uses('AppModel', 'Model');
/**
 * OnlineApplicant Model
 *
 * @property College $College
 * @property Department $Department
 * @property Program $Program
 * @property ProgramType $ProgramType
 */
class OnlineApplicant extends AppModel
{
    public $actsAs = array(

        'CodeGenerator' => array(
            'field' => 'applicationnumber',
            'prefix' => 'Y12hmc',
            'date_format' => 'Y', // e.g., INV-2025-000123
            'sequence_length' => 6,
            'reset_sequence' => 'yearly'
        ),
        'Media.Transfer' => array(
            'trustClient' => false,
            'transferDirectory' => MEDIA_TRANSFER,
            'createDirectory' => true,
            'alternativeFile' => 100
        ),
    );

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(

        'college_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => 'Please select the college you want to join',
            ),
        ),
        'department_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => 'Please select the department you want to join',
            ),
        ),
        'program_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => 'Please select the study level',
            ),
        ),
        'program_type_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => 'Please select the admission type',
            ),
        ),
        'academic_year' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please select the academic year you want to start.',
            ),
        ),
        'semester' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please select the semester you want to start.',
            ),
        ),
        'country_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please select your country.',
            ),
        ),


        'financial_support' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Provide financial support type.',
            ),
        ),
        'name_of_sponsor' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Provide name of sponsor.',
            ),
        ),
        'amharic_fullname' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Provide amharic fullname.',
            ),
        ),

        'area_type' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Provide area type.',
            ),
        ),

        'come_from' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Provide where you come from.',
            ),
        ),
        'mother_fullname' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Provide mother fullname.',
            ),
        ),

        'first_name' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Provide first name.',
            ),
        ),
        'father_name' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Provide father name.',
            ),
        ),
        'grand_father_name' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Provide grand father name.',
            ),
        ),
        'date_of_birth' => array(
            'date' => array(
                'rule' => array('date'),
                'message' => 'Please provide birth date.',
            ),
        ),
        'gender' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please select  gender.',
            ),
        ),
        'mobile_phone' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please provide the mobile number.',
            ),
        ),

        'place_of_birth' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please provide the place of birth.',
            ),
        ),

        'nationality' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please provide the nationality.',
            ),
        ),

        'applicationnumber' => array('rule' => 'isUnique', 'message' => 'Application  number taken. try again.'),


        'marital_status' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please provide the marital_status.',
            ),
        ),

        'email' => array(
            'email' => array(
                'rule' => array('email'),
                'message' => 'Please provide the email address.',
            ),
        ),

        /*
        'file' => array(
            'resource'   => array('rule' => 'checkResource'),
            'access'     => array('rule' => 'checkAccess'),
            'location'   => array('rule' => array('checkLocation', array(
                MEDIA_TRANSFER, '/tmp/'
            ))),
            'permission' => array('rule' => array('checkPermission', '*')),
            'size'       => array(
                'rule' => array('checkSize', '10M'),
                'message' => 'File size is more than 10M.'
            ),
            'pixels'     => array('rule' => array('checkPixels', '1600x1600')),
            'extension'  => array('rule' => array('checkExtension', false, array(
                'pdf', 'tmp','jpg','png','jpeg'
            ))),
            'mimeType'   => array('rule' => array('checkMimeType', false, array(
                'image/jpeg', 'image/png', 'image/tiff', 'image/gif', 'application/pdf'
            )))
        ),
        */
        /*
        'file' => array(
            'resource' => array('rule' => 'checkResource'),
            'location' => array('rule' => array('checkLocation', array( MEDIA_TRANSFER, '/tmp/' ))),
            'permission' => array('rule' => array('checkPermission', '*')),
            'size' => array('rule' => array('checkSize', '10M'), 'message' => 'File size is more than 10M.'),
            'pixels' => array('rule' => array('checkPixels', '1600x1600')),
            'extension' => array('rule' => array('checkExtension', false, array('pdf','jpg','png','jpeg'))),
            'mimeType' => array('rule' => array('checkMimeType', false, array('image/jpeg','image/png','application/pdf')))
        ),
        */


        'Attachment.0.file' => array(
            'rule' => array('extension', array('pdf')),
            'message' => 'Only PDF files allowed for documents.',
            'allowEmpty' => false
        ),
        'Attachment.1.file' => array(
            'rule' => array('extension', array('jpg', 'jpeg', 'png')),
            'message' => 'Only JPG/PNG images allowed for photo.',
            'allowEmpty' => false
        )

    );





    // The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'College' => array(
            'className' => 'College',
            'foreignKey' => 'college_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Department' => array(
            'className' => 'Department',
            'foreignKey' => 'department_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Program' => array(
            'className' => 'Program',
            'foreignKey' => 'program_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'ProgramType' => array(
            'className' => 'ProgramType',
            'foreignKey' => 'program_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

        'Country' => array(
            'className' => 'Country',
            'foreignKey' => 'country_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),

        'Region' => array(
            'className' => 'Region',
            'foreignKey' => 'region_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Zone' => array(
            'className' => 'Zone',
            'foreignKey' => 'zone_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Woreda' => array(
            'className' => 'Woreda',
            'foreignKey' => 'woreda_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

    public $virtualFields = array(
        'full_name' => "CONCAT(OnlineApplicant.first_name, ' ',OnlineApplicant.father_name,' ',OnlineApplicant.grand_father_name)",
    );
    public $hasMany = array(
        'OnlineApplicantStatus' => array(
            'className' => 'OnlineApplicantStatus',
            'foreignKey' => 'online_applicant_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'AcceptedStudent' => array(
            'className' => 'AcceptedStudent',
            'foreignKey' => 'online_applicant_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),

        'Invoice' => array(
            'className'   => 'Invoice',
            'foreignKey'  => 'payer_id',           // ← important
            'conditions'  => array(
                'Invoice.payer_type' => 'OnlineApplicant'
            ),
            'order'       => 'Invoice.created DESC'
        ),
        'Attachment' => array(
            'className' => 'Media.Attachment',
            'foreignKey' => 'foreign_key',
            'conditions'    => array('model' => 'OnlineApplicant'),
            'dependent' => true,
        ),
        'HigherEducationBackground' => array(
            'className' => 'HigherEducationBackground',
            'foreignKey' => 'online_applicant_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''

        ),
        'HighSchoolEducationBackground' => array(
            'className' => 'HighSchoolEducationBackground',
            'foreignKey' => 'online_applicant_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''

        ),

    );

    public function nextTrackingNumber()
    {
        $unique=false;
        $applicationNumber='0000000001';
        while(!$unique){
            $nextapplicationnumber = $this->find('first',array('order' => array('OnlineApplicant.applicationnumber DESC'),'recursive'=>-1));
            $applicationNumber=$nextapplicationnumber['OnlineApplicant']['applicationnumber'] + 1;
            //check if it is already exists in the database
            $existingCount= $this->find('count',array('conditions' => array('OnlineApplicant.applicationnumber'=>$applicationNumber)));
            // If no record exists, consider it unique
            if($existingCount==0){
                $unique=true;
            }
        }
        return $applicationNumber;
    }
    public function isAppliedFordmittion($data)
    {
        $applied = $this->find(
            'first',
            array(
                'conditions' => array(
                    'OnlineApplicant.department_id' => $data['OnlineApplicant']['department_id'],
                    'OnlineApplicant.college_id' => $data['OnlineApplicant']['college_id'],
                    'OnlineApplicant.program_id' => $data['OnlineApplicant']['program_id'],
                    'OnlineApplicant.program_type_id' => $data['OnlineApplicant']['program_type_id'],
                    'OnlineApplicant.academic_year' => $data['OnlineApplicant']['academic_year'],
                    'OnlineApplicant.semester' => $data['OnlineApplicant']['semester'],
                    'OnlineApplicant.email' => $data['OnlineApplicant']['email'],
                    'OnlineApplicant.first_name' => $data['OnlineApplicant']['first_name'],
                    'OnlineApplicant.father_name' => $data['OnlineApplicant']['father_name'],
                    'OnlineApplicant.grand_father_name' => $data['OnlineApplicant']['grand_father_name']

                ),
                'order' => array('OnlineApplicant.created DESC'),
                'recursive' => -1
            )
        );
        debug($data);
        debug($applied);
        if (isset($applied) && !empty($applied)) {
            return $applied['OnlineApplicant']['applicationnumber'];
        }
        return 0;
    }


    function checkUnique($data, $fieldName)
    {
        $valid = false;
        if (isset($fieldName) && $this->hasField($fieldName)) {
            $valid = $this->isUnique(array($fieldName => $data));
        }
        return $valid;
    }
    function preparedAttachment($data = null)
    {

        foreach ($data['Attachment'] as $in =>  &$dv) {

            if (
                empty($dv['file']['name']) && empty($dv['file']['type'])
                && empty($dv['tmp_name'])
            ) {
                unset($data['Attachment'][$in]);
            } else if ($in == 0) {
                $dv['model'] = 'OnlineApplicant';
                $dv['group'] = 'OnlineApplicantFiles';
            } else if ($in == 1) {
                $dv['model'] = 'OnlineApplicant';
                $dv['group'] = 'OnlineApplicantProfile';
            } else if ($in == 2) {
                $dv['model'] = 'OnlineApplicant';
                $dv['group'] = 'OnlineApplicantPaymentSlips';
            }
        }
        if (empty($data['HigherEducationBackground'][0]['name'])) {
            unset($data['HigherEducationBackground']);
        }
        if (empty($data['HighSchoolEducationBackground'][0]['name'])) {
            unset($data['HighSchoolEducationBackground']);
        }



        return $data;
    }

    function gradeTenandTwelveResult($studentId){

        $result =  ClassRegistry::init('EheeceResult')->find('first', array(
            'fields' => array(
                'SUM(EheeceResult.mark) AS total_mark'
            ),
            'conditions' => array(
                'EheeceResult.student_id' => $studentId
            ),
            'recursive' => -1
        ));

        $totalMark = (float)$result[0]['total_mark'];
        return $totalMark;
    }

    public function updateAcceptedAdmitted($id){

        $basicData = $this->find('first',array('conditions' => array('OnlineApplicant.id' => $id),'contain' => array('College','AcceptedStudent'=>array('Student'), 'Department','HigherEducationBackground','HighSchoolEducationBackground','CocBackground','EquivalentDiploma')));

        debug($basicData);


        if(isset($basicData['AcceptedStudent'][0]['id']) && !empty($basicData['AcceptedStudent'][0]['id']))
        {

            $admittedStudents['AcceptedStudent']['id'] = $basicData['AcceptedStudent'][0]['id'];
            $admittedStudents['AcceptedStudent']['first_name'] = ucwords(strtolower($basicData['OnlineApplicant']['first_name']));
            $admittedStudents['AcceptedStudent']['middle_name'] = ucwords(strtolower($basicData['OnlineApplicant']['father_name']));
            $admittedStudents['AcceptedStudent']['last_name'] = ucwords(strtolower($basicData['OnlineApplicant']['grand_father_name']));
            $admittedStudents['AcceptedStudent']['sex'] = ucwords(strtolower($basicData['OnlineApplicant']['gender']));
            $amharicNameExplode = mb_split(" ", $basicData['OnlineApplicant']['amharic_fullname']);
            if (isset($amharicNameExplode[0]) && !empty($amharicNameExplode[0])) {
                $admittedStudents['AcceptedStudent']['amharic_first_name'] = $amharicNameExplode[0];
            }
            if (isset($amharicNameExplode[1]) && !empty($amharicNameExplode[1])) {
                $admittedStudents['AcceptedStudent']['amharic_middle_name'] = $amharicNameExplode[1];
            }
            if (isset($amharicNameExplode[2]) && !empty($amharicNameExplode[2])) {
                $admittedStudents['AcceptedStudent']['amharic_last_name'] = $amharicNameExplode[2];
            }


            $admittedStudents['AcceptedStudent']['online_applicant_id'] = $basicData['OnlineApplicant']['id'];
            $admittedStudents['AcceptedStudent']['academicyear'] = $basicData['OnlineApplicant']['academic_year'];
            $admittedStudents['AcceptedStudent']['nationality'] = $basicData['OnlineApplicant']['nationality'];
            $admittedStudents['AcceptedStudent']['area_type'] = $basicData['OnlineApplicant']['area_type'];
            $admittedStudents['AcceptedStudent']['zone'] = $basicData['OnlineApplicant']['zone'];
            $admittedStudents['AcceptedStudent']['student_payment_type_id'] = $basicData['OnlineApplicant']['financial_support'];
            $admittedStudents['AcceptedStudent']['woreda'] = $basicData['OnlineApplicant']['woreda'];
            $admittedStudents['AcceptedStudent']['region_id'] = $basicData['OnlineApplicant']['region_id'];
            $admittedStudents['AcceptedStudent']['come_from'] = $basicData['OnlineApplicant']['come_from'];
            $admittedStudents['AcceptedStudent']['place_of_birth'] = $basicData['OnlineApplicant']['place_of_birth'];
            $admittedStudents['AcceptedStudent']['place_of_birth_in_amharic'] = $basicData['OnlineApplicant']['place_of_birth_in_amharic'];

            if(isset($basicData['AcceptedStudent'][0]['Student']['id']) && !empty($basicData['AcceptedStudent'][0]['Student']['id'])){

                $admittedStudents['Student']['id'] =$basicData['AcceptedStudent'][0]['Student']['id'];

                $admittedStudents['Student']['first_name'] = $admittedStudents['AcceptedStudent']['first_name'];
                $admittedStudents['Student']['curriculum_id'] = $admittedStudents['AcceptedStudent']['curriculum_id'];
                $admittedStudents['Student']['middle_name'] = $admittedStudents['AcceptedStudent']['middle_name'];
                $admittedStudents['Student']['last_name'] = $admittedStudents['AcceptedStudent']['last_name'];
                $admittedStudents['Student']['amharic_first_name'] = $admittedStudents['AcceptedStudent']['amharic_first_name'];
                $admittedStudents['Student']['amharic_middle_name'] = $admittedStudents['AcceptedStudent']['amharic_middle_name'];
                $admittedStudents['Student']['amharic_last_name'] = $admittedStudents['AcceptedStudent']['amharic_last_name'];

                $admittedStudents['Student']['woreda'] = $admittedStudents['AcceptedStudent']['woreda'];
                $admittedStudents['Student']['kebele'] = $admittedStudents['AcceptedStudent']['kebele'];
                $admittedStudents['Student']['house_number'] = $admittedStudents['AcceptedStudent']['house_number'];
                $admittedStudents['Student']['zone'] = $admittedStudents['AcceptedStudent']['zone'];
                $admittedStudents['Student']['place_of_birth'] = $admittedStudents['AcceptedStudent']['place_of_birth'];
                $admittedStudents['Student']['round'] = $admittedStudents['AcceptedStudent']['round'];
                $admittedStudents['Student']['user_id'] = $admittedStudents['AcceptedStudent']['user_id'];
                $admittedStudents['Student']['accepted_student_id'] = $admittedStudents['AcceptedStudent']['id'];
                $admittedStudents['Student']['gender'] = $admittedStudents['AcceptedStudent']['sex'];

                $admittedStudents['Student']['region_id'] = $admittedStudents['AcceptedStudent']['region_id'];
                if (isset($admittedStudents['AcceptedStudent']['curriculum_id']) && !empty($admittedStudents['AcceptedStudent']['curriculum_id'])) {
                    $admittedStudents['Student']['curriculum_id'] = $admittedStudents['AcceptedStudent']['curriculum_id'];
                }
                $admittedStudents['Student']['academicyear'] = $admittedStudents['AcceptedStudent']['academicyear'];
                $admittedStudents['Student']['pobox'] = $admittedStudents['AcceptedStudent']['pobox'];
                $admittedStudents['Student']['country_id'] = $admittedStudents['AcceptedStudent']['country_id'];
                $admittedStudents['Student']['region_id'] = $admittedStudents['AcceptedStudent']['region_id'];
                $admittedStudents['Student']['birthdate'] = $basicData['OnlineApplicant']['date_of_birth'];
                $admittedStudents['Student']['place_of_birth'] = $basicData['OnlineApplicant']['place_of_birth'];
                $admittedStudents['Student']['nationality'] = $basicData['OnlineApplicant']['nationality'];
                $admittedStudents['Student']['marital_status'] = $basicData['OnlineApplicant']['marital_status'];
                $admittedStudents['Student']['phone_mobile'] = $basicData['OnlineApplicant']['mobile_phone'];
                $admittedStudents['Student']['email'] = $basicData['OnlineApplicant']['email'];
                $admittedStudents['AcceptedStudent']['EHEECE_total_results'] = $this->gradeTenandTwelveResult($basicData['AcceptedStudent'][0]['Student']['id']);
            }

            if (isset($basicData['HigherEducationBackground']) && !empty($basicData['HigherEducationBackground'])) {
                $admittedStudents['HigherEducationBackground'] = $basicData['HigherEducationBackground'];
            }
            if (isset($basicData['HighSchoolEducationBackground']) && !empty($basicData['HighSchoolEducationBackground'])) {
                $admittedStudents['HighSchoolEducationBackground'] = $basicData['HighSchoolEducationBackground'];
            }
            if (isset($basicData['CocBackground']) && !empty($basicData['CocBackground'])) {
                $admittedStudents['CocBackground'] = $basicData['CocBackground'];
            }
        }
        if(isset($admittedStudents) && !empty($admittedStudents)){

            if ($this->AcceptedStudent->saveAll($admittedStudents, array('validate' => 'first'))) {

            } else {
                $error = $this->invalidFields();
            }
        }
    }

}