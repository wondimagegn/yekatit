<?php
App::uses('ModelBehavior', 'Model');

class CodeGeneratorBehavior extends ModelBehavior {
    public function setup(Model $model, $config = array()) {
        $this->settings[$model->alias] = array_merge(array(
            'field' => 'code',  // Field to store the code
            'prefix' => 'CODE', // e.g., INV or TXN
            'date_format' => 'Y', // Y for year, Ymd for date
            'sequence_length' => 6, // Padded digits
            'reset_sequence' => 'yearly' // yearly, daily, or never
        ), $config);
    }

    public function beforeSave(Model $model, $options = array()) {
        $settings = $this->settings[$model->alias];

        // Only generate on create, not update
        if (empty($model->data[$model->alias]['id']) && empty($model->data[$model->alias][$settings['field']])) {
            $code = $this->generateCode($model, $settings);
            $model->data[$model->alias][$settings['field']] = $code;
        }
        return true;
    }

    protected function generateCode(Model $model, $settings) {
        $prefix = $settings['prefix'];
        $datePart = date($settings['date_format']);
        $length = $settings['sequence_length'];

        // Determine sequence scope (e.g., yearly or daily)
        $conditions = array($model->alias . '.' . $settings['field'] . ' LIKE' => $prefix . '-' . $datePart . '-%');
        if ($settings['reset_sequence'] === 'never') {
            $conditions = array($model->alias . '.' . $settings['field'] . ' LIKE' => $prefix . '-%');
        }

        // Find the highest sequence number
        $lastRecord = $model->find('first', array(
            'fields' => array($settings['field']),
            'conditions' => $conditions,
            'order' => array($settings['field'] => 'DESC')
        ));

        $sequence = 1;
        if ($lastRecord) {
            $lastCode = $lastRecord[$model->alias][$settings['field']];
            $parts = explode('-', $lastCode);
            $sequence = (int) end($parts) + 1;
        }

        // Generate and check uniqueness
        do {
            if(empty($prefix)){
                $code = sprintf("%s-%0{$length}d", $datePart, $sequence);
            } else {
                $code = sprintf("%s-%s-%0{$length}d", $prefix, $datePart, $sequence);
            }

            $exists = $model->find('count', array(
                'conditions' => array($model->alias . '.' . $settings['field'] => $code)
            ));
            $sequence++;
        } while ($exists);

        return $code;
    }
}