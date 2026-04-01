<?php
/**
 * ACL Management Plugin
 *
 * @copyright     Copyright 2010, Joseph B Crawford II
 * @link          http://www.jbcrawford.net
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
echo '<div class="smallheading">Edit Task</div>';
echo $this->Form->create('Aco');
echo $this->Form->hidden('id'); 
echo $this->Form->input('parent_id', array('type' => 'hidden'));
echo "<table><tbody>";
//echo "<tr><td>".$this->Form->input('parent_id', array('empty' => 'None'))."</td></tr>";
echo "<tr><td>Parent Privilage: ".$aco['parent_aco']['privilage']."</td></tr>";
echo "<tr><td>Parent Alias: ".$aco['parent_aco']['alias']."</td></tr>";
//echo "<tr><td>".$this->Form->input('alias')."</td></tr>";
echo "<tr><td>Alias: ".$aco['Aco']['alias']."</td></tr>";  
//echo "<tr><td>".$this->Form->input('model')."</td></tr>"; 
//echo "<tr><td>".$this->Form->input('foreign_key')."</td></tr>";
echo "<tr><td>".$this->Form->input('privilage', array('label' => 'Privilage Title', 'style' => 'width:300px'))."</td></tr>"; 
echo "<tr><td>".$this->Form->input('order', array('label' => 'Order', 'after' => ' When it is displayed on the menu structure and on the permission management', 'style' => 'width:100px'))."</td></tr>";
if($aco['Aco']['parent_id'] != 1) {
	echo "<tr><td>".$this->Form->input('admin',array('label' => 'Administrator/s', 
'type'=>'select', 'multiple'=>'checkbox', 'options' => $roles))."</td></tr>";
}
echo "<tr><td>".$this->Form->input('note', array('label' => 'Privilage Note', 'style' => 'width:300px'))."</td></tr>";
echo "<tr><td>".$this->Form->submit('Submit', array('after' => ' or ' . $this->Html->link('Cancel',
 array('action' => 'index', $this->request->data['Aco']['parent_id']))))."</td></tr>";
echo "<tr><td>".$this->Form->end()."</td></tr>";
echo "</tbody></table>";
?>
