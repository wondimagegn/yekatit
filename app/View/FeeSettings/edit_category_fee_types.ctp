<?php
$this->set('title_for_layout', 'Edit Fee Types for Category');

echo $this->Html->css('fees');
echo $this->Html->script('fees');
echo $this->Form->create('FeeSettings', array('url' => array('action' => 'edit_category_fee_types', $category_id)));
?>
<div class="box">
    <div class="box-header bg-transparent">
        <div class="box-title" style="margin-top: 10px;"><i class="fontello-th-list" style="font-size: larger; font-weight: bold;"></i>
            <span style="font-size: medium; font-weight: bold; margin-top: 20px;">Edit Fee Types for Category ID: <?= $category_id.' '.$categoryDetails['FeeCategory']['name']; ?></span>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="large-12 columns">
                <div class="row">
                    <div class="large-12 columns">
                        <table class="bulk-edit-table">
                            <tr>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Currency</th>
                                <th>Recurrence</th>
                                <th>Tax Rate (%)</th>
                                <th>Discountable</th>
                                <th>Applicable To</th>
                                <th>Active</th>
                                <th>Description</th>
                                <th>Computation Rule (JSON)</th>
                            </tr>
                            <?php foreach ($feeTypes as $index => $feeType): ?>
                                <tr>
                                    <td><input type="text" name="data[FeeType][<?php echo $index; ?>][name]" value="<?php echo h($feeType['FeeType']['name']); ?>" required></td>
                                    <td><input type="number" step="0.01" name="data[FeeType][<?php echo $index; ?>][amount]" value="<?php echo h($feeType['FeeType']['amount']); ?>" required></td>
                                    <td>
                                        <select name="data[FeeType][<?php echo $index; ?>][currency_id]" required>
                                            <?php foreach ($currencies as $id => $name): ?>
                                                <option value="<?php echo $id; ?>" <?php if ($id == $feeType['FeeType']['currency_id']) echo 'selected'; ?>><?php echo $name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="data[FeeType][<?php echo $index; ?>][recurrence]">
                                            <option value="one-time" <?php if ($feeType['FeeType']['recurrence'] == 'one-time') echo 'selected'; ?>>One-Time</option>
                                            <option value="semesterly" <?php if ($feeType['FeeType']['recurrence'] == 'semesterly') echo 'selected'; ?>>Semesterly</option>
                                            <option value="yearly" <?php if ($feeType['FeeType']['recurrence'] == 'yearly') echo 'selected'; ?>>Yearly</option>
                                        </select>
                                    </td>
                                    <td><input type="number" step="0.01" name="data[FeeType][<?php echo $index; ?>][tax_rate]" value="<?php echo h($feeType['FeeType']['tax_rate']); ?>"></td>
                                    <td><input type="checkbox" name="data[FeeType][<?php echo $index; ?>][discountable]" <?php if ($feeType['FeeType']['discountable']) echo 'checked'; ?>></td>
                                    <td>
                                        <select name="data[FeeType][<?php echo $index; ?>][applicable_to]">
                                            <option value="all" <?php if ($feeType['FeeType']['applicable_to'] == 'all') echo 'selected'; ?>>All</option>
                                            <option value="students" <?php if ($feeType['FeeType']['applicable_to'] == 'students') echo 'selected'; ?>>Students</option>
                                            <option value="alumni" <?php if ($feeType['FeeType']['applicable_to'] == 'alumni') echo 'selected'; ?>>Alumni</option>
                                            <option value="guests" <?php if ($feeType['FeeType']['applicable_to'] == 'guests') echo 'selected'; ?>>Guests</option>
                                        </select>
                                    </td>
                                    <td><input type="checkbox" name="data[FeeType][<?php echo $index; ?>][active]" <?php if ($feeType['FeeType']['active']) echo 'checked'; ?>></td>
                                    <td><textarea name="data[FeeType][<?php echo $index; ?>][description]"><?php echo h($feeType['FeeType']['description']); ?></textarea></td>
                                    <td><textarea name="data[FeeType][<?php echo $index; ?>][computation_rule]"><?php echo h($feeType['FeeType']['computation_rule']); ?></textarea></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>

                    </div>
                    <div class="large-6 columns">

                        <?php 
                        echo $this->Form->submit('Save All ', array('class' => 'tiny radius button bg-blue'));
                        echo $this->Form->end();
                        
                        ?>
                        
                    </div>
                    <div class="large-6 columns">

                        <p><?php echo $this->Html->link('Back to Settings', array('action' => 'index', 'categories')); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>