<div class="transactions view">
<h2><?php echo __('Transaction'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($transaction['Transaction']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Transaction Code'); ?></dt>
		<dd>
			<?php echo h($transaction['Transaction']['transaction_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Invoice'); ?></dt>
		<dd>
			<?php echo $this->Html->link($transaction['Invoice']['id'], array('controller' => 'invoices', 'action' => 'view', $transaction['Invoice']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Student'); ?></dt>
		<dd>
			<?php echo $this->Html->link($transaction['Student']['id'], array('controller' => 'students', 'action' => 'view', $transaction['Student']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Payer Name'); ?></dt>
		<dd>
			<?php echo h($transaction['Transaction']['payer_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Payer Email'); ?></dt>
		<dd>
			<?php echo h($transaction['Transaction']['payer_email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Paid Amount'); ?></dt>
		<dd>
			<?php echo h($transaction['Transaction']['paid_amount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Payment Currency'); ?></dt>
		<dd>
			<?php echo $this->Html->link($transaction['PaymentCurrency']['name'], array('controller' => 'payment_currencies', 'action' => 'view', $transaction['PaymentCurrency']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Converted Amount'); ?></dt>
		<dd>
			<?php echo h($transaction['Transaction']['converted_amount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Exchange Rate'); ?></dt>
		<dd>
			<?php echo h($transaction['Transaction']['exchange_rate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Payment Method'); ?></dt>
		<dd>
			<?php echo $this->Html->link($transaction['PaymentMethod']['name'], array('controller' => 'payment_methods', 'action' => 'view', $transaction['PaymentMethod']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($transaction['Transaction']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Transaction Ref'); ?></dt>
		<dd>
			<?php echo h($transaction['Transaction']['transaction_ref']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Paid At'); ?></dt>
		<dd>
			<?php echo h($transaction['Transaction']['paid_at']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Notes'); ?></dt>
		<dd>
			<?php echo h($transaction['Transaction']['notes']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($transaction['Transaction']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($transaction['Transaction']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Transaction'), array('action' => 'edit', $transaction['Transaction']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Transaction'), array('action' => 'delete', $transaction['Transaction']['id']), array(), __('Are you sure you want to delete # %s?', $transaction['Transaction']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Transactions'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Transaction'), array('action' => 'add')); ?> </li>
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
