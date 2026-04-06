<?php
class CampusPlacement extends AppModel
{
	var $name = 'CampusPlacement';

    public $virtualFields = array(
		'full_name' => "CONCAT(CampusPlacement.first_name, ' ',CampusPlacement.middle_name,' ',CampusPlacement.last_name)",
    );

    function checkCampusPlacement($data = array()) 
    {
        if (empty($data)) {
            return array ();
        } else if (isset($data['Page']['first_name']) && !empty($data['Page']['first_name']) && isset($data['Page']['search_key']) && !empty($data['Page']['search_key'])) {
            $result = $this->find('first', array(
                'conditions' => array(
                    'CampusPlacement.first_name LIKE ' => (trim($data['Page']['first_name'])) . '%',
                    'CampusPlacement.moeadmissionnumber LIKE ' => (trim($data['Page']['search_key'])) . '%',
                ),
                'contain' => array(),
                'order' => array('CampusPlacement.id' => 'DESC')
            ));

            return $result;
        }
        
        return array();
    }
}