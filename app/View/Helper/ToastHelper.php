<?php
App::uses('AppHelper', 'View/Helper');

class ToastHelper extends AppHelper {
    public $helpers = ['Html', 'Session'];

    public function renderToastScript($defaultDelay = 5000) {
        $flash = $this->Session->read('Message.flash');
        if (empty($flash['message'])) {
            return '';
        }

        $message = h($flash['message']);
        $type = isset($flash['params']['class']) ? h($flash['params']['class']) : 'info';
        $delay = isset($flash['params']['delay']) ? (int)$flash['params']['delay'] : (int)$defaultDelay;

        return $this->Html->scriptBlock("
            document.addEventListener('DOMContentLoaded', function () {
                if (typeof showToast === 'function') {
                    showToast(" . json_encode($message) . ", " . json_encode($type) . ", $delay);
                }
            });
        ");
    }
}