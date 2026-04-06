<?php

// See
// http://cakephp.19694.n2.nabble.com/Using-Components-or-whole-Controllers-in-a-cake-shell-td3864438.html

App::import('Core', array('Router', 'Controller'));
include CONFIGS . 'routes.php';
App::import('Controller', 'Backups'); 
App::import('Folder'); 
App::import('Core', 'ConnectionManager');

class BackupShell extends Shell { 
  

    function main() { 
        $backup_filename=String::uuid().''.date("Y-m-d");
        
        //$folder = new Folder(APP . 'dumps', true); 
        $c = ConnectionManager::getInstance()->config->default; 
       
        $this->filename = APP . 'backup'.DS.'sql_shell_backup_'.$backup_filename.'_.sql.gz'; 
        $this->out("Writing backup dump file to $this->filename"); 
        if (file_exists($this->filename)) { 
            if ($this->in('File exists, overwrite? [y/n]') !== 'y') { 
                return; 
            } 
        } 
        
        $command = exec($c = "mysqldump -u {$c['login']} --password={$c['password']} -h {$c['host']} {$c['database']} | gzip > $this->filename"); 
        /* $command = exec($c = "mysql -u {$c['login']} --password={$c['password']} -h {$c['host']} {$c['database']} | gzip > $this->filename"); 
        */
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
