<?php
/**
 * ACL Management Plugin
 *
 */
?>
<div class="smallheading">Edit Permission to <u><?php  echo (!empty($aco['Aco']['privilage']) ? $aco['Aco']['privilage'] : implode('/', $path)); ?></u> </div>
<?php
echo $this->Form->create('Permission');
echo $this->Form->hidden('id');
echo $this->Form->hidden('aco_id');
echo $this->Form->hidden('aro_id');
//echo '<div class="smallheading">Edit Permission to ' . implode('/', $path) . '</div>';
echo "<table class='fs12'><tbody>";
echo '<tr><td style="width:10%">'.$aro_type.':</td>
			 <td style="width:90%">'.$aro_name.'</td>
		</tr>';
echo '<tr>
			<td>Privilege:</td>
			<td>'.$this->Form->input('privilege', array('label' => false, 'style' => 'width:200px', 'options' => $perms)).'</td>
		</tr>';
//echo '<tr><td>'.$this->Form->input('_create', array('options' => $perms)).'</td></tr>';
//echo '<tr><td>'.$this->Form->input('_read', array('options' => $perms)).'</td></tr>';
//echo '<tr><td>'.$this->Form->input('_update', array('options' => $perms)).'</td></tr>';
//echo '<tr><td>'.$this->Form->input('_delete', array('options' => $perms)).'</td></tr>';
echo '<tr><td></td><td><table style="margin-top:0px"><tr><td style="width:20%; border-bottom:0px">'.$this->Form->submit('Submit').'</td><td style="border-bottom:0px"><br />'.$this->Html->link('Cancel', array('action' => 'index', $this->request->data['Permission']['aco_id'])).'</td></tr></table></td></tr>';
echo '</tbody></table>';
echo $this->Form->end();
?>
