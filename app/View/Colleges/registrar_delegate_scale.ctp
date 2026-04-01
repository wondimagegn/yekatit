<?php ?>
<div class="box">
    <div class="box-body">
        <div class="row">
            <div
                class="large-12 columns">

                <div
                    class="colleges form">
                    <?php echo $this->Form->create('College');
					if (empty($this->request->data)) {
					?>
                    <table
                        cellpadding="0"
                        cellspacing="0">
                        <?php
							echo '<tr><td class="smallheading">Delegate grade  </td></tr>';

							echo '<tr><td class="font">' . $this->Form->input('Search.college_id', array('label' => 'College', 'type' => 'select', 'options' => $colleges)) . '</td></tr>';
							echo '<tr><td>' . $this->Form->Submit('Continue', array('name' => 'continue', 'class' => 'tiny radius button bg-blue', 'div' => false)) . '</td></tr>';
							?>
                    </table>
                    <?php
					}
					?>

                    <?php
					if (!empty($this->request->data)) {
					?>
                    <div style='padding-top:10px'
                        class="smallheading">
                        <?php echo __('Delegate scale setting for all field of study.');

							?>
                    </div>
                    <div
                        style='padding-top:10px;padding-bottom:10px;font-size:15px'>
                        <strong>Campus:<?php echo $this->request->data['Campus']['name'] ?></strong><br />
                        <strong>College:<?php echo $this->request->data['College']['name'] ?></strong><br />
                        <strong>
                            <?php
								echo __('Delegatation of scale setting will apply for the field of study listed below.');
								?>
                        </strong>
                    </div>

                    <table>
                        <tr>
                            <td>
                                <table>

                                    <?php
										echo $this->Form->hidden('id', array('value' => $this->request->data['College']['id']));
										if (!empty($this->request->data)) {
											foreach ($this->request->data['Department'] as $department_id => $department_name) {
												echo "<tr><td>" . $department_name['name'] . "</td></tr>";
											}
										}
										?>

                                </table>
                            </td>
                            <td
                                style='vertical-align:top;'>
                                <?php
									echo '<table>';
									echo "<tr><td>" . $this->Form->input('deligate_scale', array('after' => 'Delegate undergraduate grade scale.', 'class' => 'fs16', 'label' => false)) . "</td></tr>";

									echo "<tr><td>" . $this->Form->input('deligate_for_graduate_study', array('after' => 'Delegate post graduate grade scale.', 'class' => 'fs16', 'label' => false)) . "</td></tr>";

									echo "<tr><td>" . $this->Form->Submit('Update', array('name' => 'update', 'class' => 'tiny radius button bg-blue', 'div' => false)) . "</td></tr>";
									echo '</table>';

									?>
                            </td>
                        </tr>
                    </table>
                    <?php
					}
					?>
                </div>
            </div>
            <!-- end of columns 12 -->
        </div> <!-- end of row --->
    </div> <!-- end of box-body -->
</div><!-- end of box -->