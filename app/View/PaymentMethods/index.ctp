<div class="box">
    <div class="box-body">
        <div class="row">
            <div
                class="large-12 columns">


                <div
                    class="paymentMethods index">
                    <h2>
                        <?php echo __('Payment Methods'); ?>
                    </h2>
                    <table
                        cellpadding="0"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th>
                                    <?php echo $this->Paginator->sort('id', 'S.No'); ?>
                                </th>
                                <th>
                                    <?php echo $this->Paginator->sort('name', 'Name'); ?>
                                </th>
                                <th>
                                    <?php echo $this->Paginator->sort('url', 'Link'); ?>
                                </th>
                                <th>
                                    <?php echo $this->Paginator->sort('instruction', 'Instruction'); ?>
                                </th>

                                <th
                                    class="actions">
                                    <?php echo __('Actions'); ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($paymentMethods as $paymentMethod): ?>
                                <tr>
                                    <td>
                                        <?php echo h($paymentMethod['PaymentMethod']['id']); ?>&nbsp;
                                    </td>
                                    <td>
                                        <?php echo h($paymentMethod['PaymentMethod']['name']); ?>&nbsp;
                                    </td>
                                    <td>
                                        <?php echo h($paymentMethod['PaymentMethod']['url']); ?>&nbsp;
                                    </td>
                                    <td>
                                        <?php echo h($paymentMethod['PaymentMethod']['instruction']); ?>&nbsp;
                                    </td>

                                    <td
                                        class="actions">
                                        <?php echo $this->Html->link(__('View'), array('action' => 'view', $paymentMethod['PaymentMethod']['id'])); ?>
                                        <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $paymentMethod['PaymentMethod']['id'])); ?>
                                        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $paymentMethod['PaymentMethod']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $paymentMethod['PaymentMethod']['id']))); ?>
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
                        ?>
                    </p>
                    <div class="paging">
                        <?php
                        echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
                        echo $this->Paginator->numbers(array('separator' => ''));
                        echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>