<?php
class RemedialResult extends AppModel
{
	var $name = 'RemedialResult';

    public $virtualFields = array(
		'full_name' => "CONCAT(RemedialResult.first_name, ' ',RemedialResult.middle_name,' ',RemedialResult.last_name)",
    );

    function findRemedialResult($data = array()) 
    {
        if (empty($data)) {
            return array ();
        } else if (isset($data['Page']['first_name']) && !empty($data['Page']['first_name']) && isset($data['Page']['search_key']) && !empty($data['Page']['search_key'])) {
            $result = $this->find('first', array(
                'conditions' => array(
                    'RemedialResult.first_name LIKE ' => (trim($data['Page']['first_name'])) . '%',
                    'OR' => array(
                       'RemedialResult.studentnumber LIKE ' => (trim($data['Page']['search_key'])) . '%',
                       'RemedialResult.moeadmissionnumber LIKE ' => (trim($data['Page']['search_key'])) . '%',
                    )
                ),
                'contain' => array(),
                'order' => array('RemedialResult.id' => 'DESC')
            ));

            return $result;
        }
        
        return array();
    }
}