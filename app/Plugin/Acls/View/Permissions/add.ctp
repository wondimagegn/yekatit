<?php ?>
<script type="text/javascript">
function getUsersBasedOnRole(obj) {
	$("#RoleID").attr('disabled', true);
	$("#AroID").attr('disabled', true);
	$("#PrivilegeID").attr('disabled', true);
	$("#SubmitID").attr('disabled', true);
	window.location.replace("/acls/permissions/add/<?php echo $aco['Aco']['id']; ?>/"+obj.value);
}
</script>
<?php
/**
 * ACL Management Plugin
 *
 * @copyright     Copyright 2010, Joseph B Crawford II
 * @link          http://www.jbcrawford.net
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<div class="box">
     
     <div class="box-body">
       <div class="row">
	<div class="large-12 columns">
            <h2 class="box-title">
	Add Permission to <u><?php  echo (!empty($aco['Aco']['privilage']) ? $aco['Aco']['privilage'] : implode('/', $path)); ?></u>
	</h2>

<?php
echo $this->Form->create('Permission');
echo $this->Form->hidden('aco_id');
echo '<table class="fs12"><tbody>';
//echo '<tr><td><h2>Add Permission to ' . implode('/', $path) . '</h2></td></tr>';
echo '<tr><td style="width:10%">Role:</td>
			 <td style="width:90%">'.$this->Form->input('role_id', array('label' => false, 'style' => 'width:400px', 'onchange' => 'getUsersBasedOnRole(this)', 'id' => 'RoleID', 'type' => 'select', 'default' => $role_id, 'options' => $roles)).'</td>
		</tr>';
echo '<tr><td style="width:10%">User:</td>
			 <td style="width:90%">'.$this->Form->input('aro_id', array('label' => false, 'style' => 'width:400px', 'id' => 'AroID', 'options' => $users)).'</td>
		</tr>';
echo '<tr>
			<td>Privilege:</td>
			<td>'.$this->Form->input('privilege', array('label' => false, 'id' => 'PrivilegeID', 'style' => 'width:200px', 'options' => $perms)).'</td>
		</tr>';
echo '<tr><td></td><td><table style="margin-top:0px;border:0px!important;"><tr><td style="width:20%; border-bottom:0px">'.$this->Form->submit('Submit', array('id' => 'SubmitID','class'=>'tiny radius button bg-blue')).
'</td><td style="border-bottom:0px;border:0px!important">'.$this->Html->link('Cancel', array('action' => 'index', $this->request->data['Permission']['aco_id']),array('class'=>'tiny radius button bg-blue')).'</td></tr></table></td></tr>';
echo '</tbody></table>';
echo $this->Form->end();
?>
</div>
</div>
</div>
</div>
