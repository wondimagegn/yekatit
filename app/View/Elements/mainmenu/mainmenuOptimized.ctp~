<?php
	
	$rename_menu_title = Configure::read('Menu.title_rename');

	$this->Format->renameControllerTitle($menuoptimized, $rename_menu_title);
	$links = array();
	$controller=str_replace('_','',$this->request->params['controller']);
	$action=!empty($this->request->params['action'])?$this->request->params['action']:'index';

echo "<ul id='menu-showhide' class='topnav slicknav'>";
?>
<?php 
	$parent = 0;
	$parent_exists = false;
	foreach($menuoptimized as $key =>$value){
	    if($this->Format->isActiveMenu($value,$controller,$action)){
		$parent_exists = true;
		break;
	    }
	}
	
	foreach($menuoptimized as $key =>$value) {
		$parent=$key;
				
		if (($parent_exists == false && $key == 0) || 
$this->Format->isActiveMenu($value,$controller,$action)) {
		 echo '<li>';
			$parent=$key;
		} else {
		        echo '<li>';
		}
		
		$ctrlCamel = Inflector::variable($value['url']['controller']);
		if(!array_key_exists($value['id'], $rename_menu_title)){
			$ctrlHuman = Inflector::humanize(Inflector::underscore($ctrlCamel));
		} 
		else
		{
			$ctrlHuman = $rename_menu_title[$value['id']];
		}
		
		echo '<a href="#" class="tooltip-tip" title='.$ctrlHuman.'>  
<span>'.$ctrlHuman.'</span></a>';
		
								
	   if(count($menuoptimized[$parent]['children'] )) {
		if (($parent_exists == false && $key == 0) || 
$this->Format->isActiveMenu($value,$controller,$action)) {
		 echo '<ul style="display:block;">';
			
		} else {
		        echo '<ul>';
		}

         // this is for index of the inactive menu, replicaiton
		if(isset($value['parent']) && !empty($value['parent'])){
			echo '<li>'.$this->Html->link($ctrlHuman.'', '/'.$value['url']['controller'].'/'.$value['url']['action'],array('class'=>"tooltip-tip")).'</li>';
		}
       
		
		foreach($menuoptimized[$parent]['children'] as $m =>$f)
		{
		
		if(sizeof($f['children'])==0) {
		
		echo '<li>'.$this->Html->link(__($f['title'].'', true), array('controller'=>$f['url']['controller'],'action' =>$f['url']['action'],
			'plugin'=>false
			));
		
		} else{

           echo '<li><a href="#" style="color:white;" title='.$f['title'].'><span>'.$f['title'].'</span></a>';

	   if(sizeof($f['children'])!=0){
		   $children=$f['children'];
		   $string = null;
		   $string.='<ul>';
	       foreach($children as $ch=>$vch) {
					$string.="<li>";	
					if(sizeof($vch['children'])==0) {
						$string .=$this->Html->link($vch['title'].'', '/'.$vch['url']['controller'].'/'.$vch['url']['action']);

					} else {
						$string .='<a href="#" style="color:white;" title='.
			$vch['title'].'> <span>'.$vch['title'].'</span></a>';
						if(sizeof($vch['children'])!=0) {
						  $string .='<ul>';
						  $string .='<li>'.$this->Html->link($vch['title'], '/'.$vch['url']['controller'].'/'.$vch['url']['action']).'</li>';
						  foreach($vch['children'] as $c => $v) 
						  {
						   $string .='<li>';
						   $string.=$this->Html->link($v['title'], '/'.$v['url']['controller'].'/'.$v['url']['action']);
						   $string .='</li>';				
						  }
						  $string .='</ul>';
					  }
			   }
              $string.= "</li>";
	       }
	       $string.="</ul>";
	      echo $string;
	     } // end of if 
       }	
      echo "</li>";
	}  // end of for children
	echo '</ul>';
	}
	echo "</li>";		
    }
echo "</ul>";
?>
