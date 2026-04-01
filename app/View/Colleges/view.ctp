<?php ?>
<?php ?>
<div class="box">
    <div class="box-body">
        <div class="row">
            <div
                class="large-12 columns">

                <div
                    class="colleges view">
                    <table>
                        <tbody>
                            <tr>
                                <td
                                    class="smallheading">
                                    <?php echo __('Department'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo $college['College']['name']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php $i = 0;
									$class = ' class="altrow"'; ?>
                                </td>
                            </tr>
                            <tr>
                                <td> Located.<?php echo $this->Html->link($college['Campus']['name'], array('controller' => 'campuses', 'action' => 'view', $college['Campus']['id'])); ?>
                                </td>
                            </tr>


                            <tr>
                                <td><?php echo __('Description'); ?>
                                    <?php echo $college['College']['description']; ?>
                                </td>
                            </tr>


                        </tbody>
                    </table>
                </div>

                <div class="related">
                    <h3><?php echo __('Related Field of study'); ?>
                    </h3>
                    <?php if (!empty($college['Department'])) : ?>
                    <table
                        cellpadding="0"
                        cellspacing="0">
                        <tr>
                            <th><?php echo __('Id'); ?>
                            </th>
                            <th><?php echo __('Name'); ?>
                            </th>
                            <th><?php echo __('Description'); ?>
                            </th>
                            <th
                                class="actions">
                                <?php echo __('Actions'); ?>
                            </th>
                        </tr>
                        <?php
							$i = 0;
							foreach ($college['Department'] as $department) :
								$class = null;
								if ($i++ % 2 == 0) {
									$class = ' class="altrow"';
								}
							?>
                        <tr<?php echo $class; ?>>
                            <td><?php echo $department['id']; ?>
                            </td>
                            <td><?php echo $department['name']; ?>
                            </td>
                            <td><?php echo $department['description']; ?>
                            </td>
                            <td
                                class="actions">
                                <?php echo $this->Html->link(__('View'), array('controller' => 'departments', 'action' => 'view', $department['id'])); ?>
                                <?php echo $this->Html->link(__('Edit'), array('controller' => 'departments', 'action' => 'edit', $department['id'])); ?>
                                <?php echo $this->Html->link(__('Delete'), array('controller' => 'departments', 'action' => 'delete', $department['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $department['id'])); ?>
                            </td>
                            </tr>
                            <?php endforeach; ?>
                    </table>
                    <?php endif; ?>

                </div>

                <div class="related">
                    <h3><?php echo __('Related Staffs'); ?>
                    </h3>
                    <?php if (!empty($college['Staff'])) : ?>
                    <table
                        cellpadding="0"
                        cellspacing="0">
                        <tr>
                            <th><?php echo __('Department Id'); ?>
                            </th>
                            <th><?php echo __('Position Id'); ?>
                            </th>
                            <th><?php echo __('Field of specialization'); ?>
                            </th>
                            <th><?php echo __('Title Id'); ?>
                            </th>
                            <th><?php echo __('First Name'); ?>
                            </th>
                            <th><?php echo __('Middle Name'); ?>
                            </th>
                            <th><?php echo __('Ethnicity'); ?>
                            </th>
                            <th><?php echo __('Birthdate'); ?>
                            </th>
                            <th
                                class="actions">
                                <?php echo __('Actions'); ?>
                            </th>
                        </tr>
                        <?php
							$i = 0;
							foreach ($college['Staff'] as $staff) :
								$class = null;
								if ($i++ % 2 == 0) {
									$class = ' class="altrow"';
								}
							?>
                        <tr<?php echo $class; ?>>

                            <td><?php echo $staff['college_id']; ?>
                            </td>
                            <td><?php echo $staff['position_id']; ?>
                            </td>
                            <td><?php echo $staff['department_id']; ?>
                            </td>
                            <td><?php echo $staff['title_id']; ?>
                            </td>
                            <td><?php echo $staff['first_name']; ?>
                            </td>
                            <td><?php echo $staff['middle_name']; ?>
                            </td>
                            <td><?php echo $staff['ethnicity']; ?>
                            </td>
                            <td><?php echo $staff['birthdate']; ?>
                            </td>
                            <td
                                class="actions">
                                <?php echo $this->Html->link(__('View'), array('controller' => 'staffs', 'action' => 'view', $staff['id'])); ?>
                                <?php echo $this->Html->link(__('Edit'), array('controller' => 'staffs', 'action' => 'edit', $staff['id'])); ?>
                                <?php echo $this->Html->link(__('Delete'), array('controller' => 'staffs', 'action' => 'delete', $staff['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $staff['id'])); ?>
                            </td>
                            </tr>
                            <?php endforeach; ?>
                    </table>
                    <?php endif; ?>

                </div>
                <div class="related">
                    <h3><?php echo __('Related Students'); ?>
                    </h3>
                    <?php if (!empty($college['Student'])) : ?>
                    <table
                        cellpadding="0"
                        cellspacing="0">
                        <tr>

                            <th><?php echo __('First Name'); ?>
                            </th>
                            <th><?php echo __('Middle Name'); ?>
                            </th>
                            <th><?php echo __('Last Name'); ?>
                            </th>
                            <th><?php echo __('Gender'); ?>
                            </th>
                            <th><?php echo __('Ethnicity'); ?>
                            </th>
                            <th><?php echo __('Birthdate'); ?>
                            </th>
                            <th><?php echo __('Language'); ?>
                            </th>
                            <th><?php echo __('Is Disable'); ?>
                            </th>
                            <th><?php echo __('Studentnumber'); ?>
                            </th>
                            <th><?php echo __('Admissionyear'); ?>
                            </th>
                            <th
                                class="actions">
                                <?php echo __('Actions'); ?>
                            </th>
                        </tr>
                        <?php
							$i = 0;
							foreach ($college['Student'] as $student) :
								$class = null;
								if ($i++ % 2 == 0) {
									$class = ' class="altrow"';
								}
							?>
                        <tr<?php echo $class; ?>>

                            <td><?php echo $student['first_name']; ?>
                            </td>
                            <td><?php echo $student['middle_name']; ?>
                            </td>
                            <td><?php echo $student['last_name']; ?>
                            </td>
                            <td><?php echo $student['gender']; ?>
                            </td>
                            <td><?php echo $student['ethnicity']; ?>
                            </td>
                            <td><?php echo $student['birthdate']; ?>
                            </td>
                            <td><?php echo $student['language']; ?>
                            </td>
                            <td><?php echo $student['is_disable']; ?>
                            </td>
                            <td><?php echo $student['studentnumber']; ?>
                            </td>
                            <td><?php echo $student['admissionyear']; ?>
                            </td>
                            <td
                                class="actions">
                                <?php echo $this->Html->link(__('View'), array('controller' => 'students', 'action' => 'view', $student['id'])); ?>
                                <?php echo $this->Html->link(__('Edit'), array('controller' => 'students', 'action' => 'edit', $student['id'])); ?>
                                <?php echo $this->Html->link(__('Delete'), array('controller' => 'students', 'action' => 'delete', $student['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $student['id'])); ?>
                            </td>
                            </tr>
                            <?php endforeach; ?>
                    </table>
                    <?php endif; ?>

                </div>
            </div>
            <!-- end of columns 12 -->
        </div> <!-- end of row --->
    </div> <!-- end of box-body -->
</div><!-- end of box -->