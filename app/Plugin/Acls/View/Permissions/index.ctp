<?php
/**
 * ACL Management Plugin
 *
 * @copyright     Copyright 2010, Joseph B Crawford II
 * @link          http://www.jbcrawford.net
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
echo $this->Html->css('/acls/css/tables');
//echo $this->Html->script(array('/acls/js/jquery-1.4.2.min', '/acls/js/jquery-acl'));
?>
<div class="box">
     <div class="box-header bg-transparent">
  	 <h2 class="box-title">
	<?php echo __('Permission Management');?>
	
	</h2>
     </div>
     <div class="box-body">
       <div class="row">
	<div class="large-12 columns">
<?php 
echo '<div id="breadcrumbs">';
if (!empty($path)) {
    $last = array_pop($path);
    foreach($path as $id => $alias) {
        $this->Html->addCrumb($alias, array('controller' => 'acos', 'action' => 'index', $id));
    }
}
//echo $this->Html->getCrumbs(' &#8250; ') . ' &#8250; ' . $last;
echo $this->Html->link('Tasks', array('controller' => 'acos', 'action' => 'index', $id)).' &#8250; ' . (!empty($aco['Aco']['privilage']) ? $aco['Aco']['privilage'] : $last);
echo '</div>';
echo $this->Form->create('Permission', array('action' => 'delete', 'id' => 'permission-form'));
echo '<table width="100%">';
echo '  <thead>';
echo '      <tr>';
echo '          <th style="width:5%">' . $this->Form->checkbox(null, array('id' => 'select-all')) . '</th>';
echo '          <th style="width:5%">' . $this->Html->link($this->Html->image('/acls/img/add.png', array('alt' => 'Add Permission')), array('action' => 'add', $aco_id), array('escape' => false, 'title' => 'Add Permission')) . '</th>';
echo '          <th style="width:30%">User/Role</th>';
echo '          <th style="width:60%; text-align:left" class="permission-column">Privilege</th>';
//echo '          <th class="permission-column">Create</th>';
//echo '          <th class="permission-column">Read</th>';
//echo '          <th class="permission-column">Update</th>';
//echo '          <th class="permission-column">Delete</th>';
echo '      </tr>';
echo '  </thead>';
if (!empty($permissions)) {
    echo '<tbody>';
    foreach($permissions as $i) {
        if (empty($count)) $count = 1; else $count++;
        echo '<tr class="' . (($count % 2 == 0) ? 'even' : 'odd') . '">';
        echo '  <td>' . $this->Form->checkbox('Permission.delete.' . $i['Permission']['id'],
array('class'=>'checkbox1')) . '</td>';
        echo '  <td>' . $this->Html->link($this->Html->image('/acls/img/edit.png', array('alt' => 'Edit Permission')), array('action' => 'edit', $aco_id, $i['Permission']['id']), array('escape' => false, 'title' => 'Edit Permission')) . '</td>';
        echo '  <td>' . (($i['Aro']['model'] == 'Role') ? 'Role: ' . $roles[$i['Aro']['foreign_key']] : 'Users: ' . $users[$i['Aro']['foreign_key']]) . '<br /><small>' . (!empty($i['Aco']['privilage']) ? $i['Aco']['privilage'] : $i['Permission']['path']) . '</small></td>';
        echo '  <td style="text-align:left" class="permission-column ' . $perms[$i['Permission']['_create']] . '">' . $perms[$i['Permission']['_create']] . '</td>';
    
        echo '</tr>';
    }
    echo '</tbody>';
}
echo '</table>';
echo $this->Form->hidden('aco_id', array('value' => $aco_id));
echo $this->Form->submit('Delete Selected',
array('class'=>'tiny radius button bg-blue'));
echo $this->Form->end();
?>
</div>
</div>
</div>
</div>
