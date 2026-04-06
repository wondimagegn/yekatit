<?php
/**
 * ACL Management Plugin
 *
 * @copyright     Copyright 2010, Joseph B Crawford II
 * @link          http://www.jbcrawford.net
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
//echo $this->Html->css('/acls/css/tables');
//echo $this->Html->script(array('/acls/js/jquery-1.4.2.min', '/acls/js/jquery-acl'));
//echo $this->Html->script(array('/acls/js/jquery-acl'));
?>
<div class="box"> 
     <div class="box-body">
       <div class="row">
	    <div class="large-12 columns">
              <h5 class="box-title">
              <?php echo __('Permission Management'); ?>
	      </h5>

<p class="fs14"><strong>Important Note:</strong> Please do not forget to construct user menu after the assignment of new privilage/s to the user and/or provoked privilage/s from the user by going to "User Account List" page. </p>
<?php
echo '<div id="breadcrumbs">';
if (!empty($path)) {
    foreach($path as $id => $alias) {
        $this->Html->addCrumb($alias, array('action' => 'index', $id));
    }
}
//echo $this->Html->getCrumbs(' &#8250; ');
echo $this->Html->link('Tasks', array('controller' => 'acos', 'action' => 'index', 1)).' ' . (isset($path) && !empty($path) && count($path) > 1 ? ' &#8250; '.(!empty($aco['Aco']['privilage']) ? $aco['Aco']['privilage'] : $aco['Aco']['alias']) : '');
echo '</div>';
echo $this->Form->create('Aco', array('action' => 'delete', 'id' => 'aco-form'));
echo '<table width="100%">';
echo '  <thead>';
echo '      <tr>';
echo '          <th style="width:20px">N<u>o</u></th>';
if(Configure::read("Developer")){
	echo '          <th style="width:5%">'.$this->Form->checkbox(null, array('id' => 'select-all')).'</th>';
	echo '          <th style="width:5%"></th>';
	
}
echo '          <th style="width:200px">Privilege</th>';
echo '          <th style="width:120px">Actions It Contain</th>';
echo '          <th style="width:100px">Permission</th>';

echo '          <th>Note</th>';
echo '      </tr>';
echo '  </thead>';

if (!empty($acos)) {
	echo '<tbody>';
    foreach($acos as $i) {
        if (empty($count)) $count = 1; else $count++;
             echo '<tr class="' . (($count % 2 == 0) ? 'even' : 'odd') . '">';
             echo '  <td>' . $count . '</td>';
                if(Configure::read("Developer")){
		             echo '  <td>' . $this->Form->checkbox('Aco.delete.' . $i['Aco']['id'],
array('class'=>'checkbox1')) . '</td>';
		             echo '  <td>' . $this->Html->link($this->Html->image('/acls/img/edit.png',
 array('alt' => 'Edit ACO')), array('action' => 'edit', $i['Aco']['id']), array('escape' => false, 'title' => 'Edit ACO')) . '</td>';
		}
                echo '  <td>' . (empty($i['Aco']['privilage']) ? $i['Aco']['alias'] : $i['Aco']['privilage']) . '</td>';
                echo '  <td>' . (($i['Aco']['num_children'] > 0) ? $this->Html->link('Children', array('action' => 'index', $i['Aco']['id'])) : 'Children') . ' <small>(' . $i['Aco']['num_children'] . ')</small></td>';
		          echo '  <td>';
		          if(!isset($i['Aco']['remove_permission']) || !$i['Aco']['remove_permission']) {
		          	echo $this->Html->link($this->Html->image('/acls/img/permissions.png', array('alt' => 'View Permissions')), array('controller' => 'permissions', 'action' => 'index', $i['Aco']['id']), array('escape' => false, 'title' => 'View Permissions')) . ' <small>(' . $i['Aco']['num_permitted_actions_controlloer'] . ')</small>';//num_permissions
		          }
		          echo '</td>';
                echo '  <td>' . $i['Aco']['note'] . '</td>';
                echo '</tr>';
    	}
	echo '</tbody>';
}
echo '</table>';
echo $this->Form->hidden('parent_id', array('value' => $parent_id));
if(Configure::read("Developer")){
	echo $this->Form->submit('Delete Selected', array('after' => ' <input type="submit" value="Rebuild ACOs" id="rebuildButton" class="tiny radius button bg-blue" />',
'class'=>'tiny radius button bg-blue'));
}
echo $this->Form->end();
?>
<script type="text/javascript">

    $(document).ready(function() {
        $('#rebuildButton').click(function() {
            $('#aco-form').attr('action', '/acls/acos/rebuild').submit();
        });
    });

</script>

</div>

</div>
</div>
</div>
