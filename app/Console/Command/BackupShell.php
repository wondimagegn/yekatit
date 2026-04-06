<?php

App::uses('AppShell', 'Console/Command');
App::uses('Controller', 'Controller');
App::uses('Folder', 'Utility');
App::uses('Controller', 'Backups'); 
App::uses('ConnectionManager', 'Model');

class BackupShell extends AppShell { 
  

    function main() { 
        $backup_filename=uniqid().''.date("Y-m-d");
       
        $c = ConnectionManager::getDataSource('default');
       
        $this->filename = APP . 'backup'.DS.'sql_shell_backup_'.$backup_filename.'_.sql.gz'; 
        $this->out("Writing backup dump file to $this->filename"); 
        if (file_exists($this->filename)) { 
            if ($this->in('File exists, overwrite? [y/n]') !== 'y') { 
                return; 
            } 
        } 
        
        $command = exec($c = "mysqldump -u {$c->config['login']} --password={$c->config['password']} -h {$c->config['host']} {$c->config['database']} | gzip > $this->filename"); 
      
        if (!file_exists($this->filename)) { 
            $this->out("Couldn't create backup, aborting."); 
            $this->_stop(); 
        }
      
    } 
    /**
    *Delete one month old backups 
    */
    function delete () {
        $this->Backups = new BackupsController();
        $this->Backups->constructClasses();
        $file_paths = $this->Backups->delete_one_month_old_backup(true);
        $delete_path=null;
        
        foreach ($file_paths as $index=>$value) {
           $delete_path .=$value.' ';
        }
        if (!empty($delete_path)) {
           $command = exec($c = "rm -rf {$delete_path} "); 
           $this->out($command);  
        }  
    }

  
} 
?>
