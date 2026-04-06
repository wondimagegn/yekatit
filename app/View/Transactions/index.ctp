<div class="transactions index">
	<h2><?php echo __('Transactions'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('transaction_code'); ?></th>
			<th><?php echo $this->Paginator->sort('invoice_id'); ?></th>
			<th><?php echo $this->Paginator->sort('student_id'); ?></th>
			<th><?php echo $this->Paginator->sort('payer_name'); ?></th>
			<th><?php echo $this->Paginator->sort('payer_email'); ?></th>
			<th><?php echo $this->Paginator->sort('paid_amount'); ?></th>
			<th><?php echo $this->Paginator->sort('currency_id'); ?></th>
			<th><?php echo $this->Paginator->sort('converted_amount'); ?></th>
			<th><?php echo $this->Paginator->sort('exchange_rate'); ?></th>
			<th><?php echo $this->Paginator->sort('method_id'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('transaction_ref'); ?></th>
			<th><?php echo $this->Paginator->sort('paid_at'); ?></th>
			<th><?php echo $this->Paginator->sort('notes'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($transactions as $transaction): ?>
	<tr>
		<td><?php echo h($transaction['Transaction']['id']); ?>&nbsp;</td>
		<td><?php echo h($transaction['Transaction']['transaction_code']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($transaction['Invoice']['id'], array('controller' => 'invoices', 'action' => 'view', $transaction['Invoice']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($transaction['Student']['id'], array('controller' => 'students', 'action' => 'view', $transaction['Student']['id'])); ?>
		</td>
		<td><?php echo h($transaction['Transaction']['payer_name']); ?>&nbsp;</td>
		<td><?php echo h($transaction['Transaction']['payer_email']); ?>&nbsp;</td>
		<td><?php echo h($transaction['Transaction']['paid_amount']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($transaction['PaymentCurrency']['name'], array('controller' => 'payment_currencies', 'action' => 'view', $transaction['PaymentCurrency']['id'])); ?>
		</td>
		<td><?php echo h($transaction['Transaction']['converted_amount']); ?>&nbsp;</td>
		<td><?php echo h($transaction['Transaction']['exchange_rate']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($transaction['PaymentMethod']['name'], array('controller' => 'payment_methods', 'action' => 'view', $transaction['PaymentMethod']['id'])); ?>
		</td>
		<td><?php echo h($transaction['Transaction']['status']); ?>&nbsp;</td>
		<td><?php echo h($transaction['Transaction']['transaction_ref']); ?>&nbsp;</td>
		<td><?php echo h($transaction['Transaction']['paid_at']); ?>&nbsp;</td>
		<td><?php echo h($transaction['Transaction']['notes']); ?>&nbsp;</td>
		<td><?php echo h($transaction['Transaction']['created']); ?>&nbsp;</td>
		<td><?php echo h($transaction['Transaction']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $transaction['Transaction']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $transaction['Transaction']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $transaction['Transaction']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $transaction['Transaction']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Transaction'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Invoices'), array('controller' => 'invoices', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoice'), array('controller' => 'invoices', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Students'), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student'), array('controller' => 'students', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Payment Currencies'), array('controller' => 'payment_currencies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Payment Currency'), array('controller' => 'payment_currencies', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Payment Methods'), array('controller' => 'payment_methods', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Payment Method'), array('controller' => 'payment_methods', 'action' => 'add')); ?> </li>
	</ul>
</div>
