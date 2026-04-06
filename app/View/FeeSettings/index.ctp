<?php
$this->set('title_for_layout', 'Fee Settings');

echo $this->Html->css('fees');
echo $this->Html->script('fees');
?>

<div class="box">
    <div class="box-header bg-transparent">
        <div class="box-title" style="margin-top: 10px;">
            <i class="fontello-th-list" style="font-size: larger; font-weight: bold;"></i>
            <span style="font-size: medium; font-weight: bold; margin-top: 20px;">Fee Settings</span>
        </div>
    </div>
    <div class="box-body">
        <div class="tabs">
            <ul class="tab-links">
                <li><a href="<?php echo $this->Html->url(array('controller' => 'feeSettings', 'action' => 'index', 'categories')); ?>"
                       class="<?php echo $activeTab == 'categories' ? 'active' : ''; ?>">Fee Categories</a></li>
                <li><a href="<?php echo $this->Html->url(array('controller' => 'feeSettings', 'action' => 'index', 'fee_types')); ?>" 
                       class="<?php echo $activeTab == 'fee_types' ? 'active' : ''; ?>">Fee Types</a></li>
                <li><a href="<?php echo $this->Html->url(array('controller' => 'feeSettings', 'action' => 'index', 'currencies')); ?>"
                       class="<?php echo $activeTab == 'currencies' ? 'active' : ''; ?>">Payment Currencies</a></li>
                <li><a href="<?php echo $this->Html->url(array('controller' => 'feeSettings', 'action' => 'index', 'methods')); ?>" 
                       class="<?php echo $activeTab == 'methods' ? 'active' : ''; ?>">Payment Methods</a></li>
                <li><a href="<?php echo $this->Html->url(array('controller' => 'feeSettings', 'action' => 'index', 'exchange_rates')); ?>" 
                       class="<?php echo $activeTab == 'exchange_rates' ? 'active' : ''; ?>">Exchange Rates</a></li>
            </ul>

            <div class="tab-content">
                <?php if ($activeTab == 'categories'): ?>
                    <span style="float:right;"><?php echo $this->Html->link('Add Category', array('action' => 'add_category'),
                            array('class' => 'tiny radius button bg-blue')); ?></span>
                    <table>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                        <?php foreach ($feeCategories as $category): ?>
                            <tr>
                                <td><?php echo h($category['FeeCategory']['name']); ?></td>
                                <td><?php echo h($category['FeeCategory']['description']); ?></td>
                                <td>
                                    <?php echo $this->Html->link('Edit', array('action' => 'edit_category', $category['FeeCategory']['id'])); ?> |
                                    <?php echo $this->Form->postLink('Delete', array('action' => 'delete_category', 
                                        $category['FeeCategory']['id']), array('confirm' => 'Are you sure?')); ?> |
                                    <?php echo $this->Html->link('Manage Fee Types', array('action' => 'edit_category_fee_types', $category['FeeCategory']['id'])); ?> |
                                    <?php echo $this->Html->link('Add Fee Types', array('action' => 'add_fee_types', $category['FeeCategory']['id'])); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                <?php elseif ($activeTab == 'fee_types'): ?>
                
                    <span style="float:right;"><?php echo $this->Html->link('Add Fee Type',
                            array('action' => 'add_fee_types'), array('class' => 'tiny radius button bg-blue')); ?></span>
                    <table>
                        <tr>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Currency</th>
                            <th>Category</th>
                            <th>Recurrence</th>
                            <th>Tax Rate (%)</th>
                            <th>Discountable</th>
                            <th>Applicable To</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                        <?php foreach ($feeTypes as $feeType): ?>
                            <tr>
                                <td><?php echo h($feeType['FeeType']['name']); ?></td>
                                <td><?php echo h($feeType['FeeType']['amount']); ?></td>
                                <td><?php echo h($feeType['PaymentCurrency']['name']); ?></td>
                                <td><?php echo h($feeType['FeeCategory']['name']); ?></td>
                                <td><?php echo h($feeType['FeeType']['recurrence']); ?></td>
                                <td><?php echo h($feeType['FeeType']['tax_rate']); ?>%</td>
                                <td><?php echo $feeType['FeeType']['discountable'] ? 'Yes' : 'No'; ?></td>
                                <td><?php echo h($feeType['FeeType']['applicable_to']); ?></td>
                                <td><?php echo $feeType['FeeType']['active'] ? 'Yes' : 'No'; ?></td>
                                <td>
                                    <?php echo $this->Html->link('Edit', array('action' => 'edit_fee_type', $feeType['FeeType']['id'])); ?> |
                                    <?php echo $this->Form->postLink('Delete', array('action' => 'delete_fee_type', $feeType['FeeType']['id']), array('confirm' => 'Are you sure?')); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                <?php elseif ($activeTab == 'currencies'): ?>
                
                    <span style="float:right;"><?php echo $this->Html->link('Add Currency', array('action' => 'add_currency'),
                            
                            array('class' => 'tiny radius button bg-blue')); ?></span>
                    <table>
                        <tr>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Territory</th>
                            <th>Actions</th>
                        </tr>
                        <?php foreach ($paymentCurrencies as $currency): ?>
                            <tr>
                                <td><?php echo h($currency['PaymentCurrency']['name']); ?></td>
                                <td><?php echo h($currency['PaymentCurrency']['currency_code']); ?></td>
                                <td><?php echo h($currency['PaymentCurrency']['currency_territory']); ?></td>
                                <td>
                                    <?php echo $this->Html->link('Edit', array('action' => 'edit_currency', $currency['PaymentCurrency']['id'])); ?> |
                                    <?php echo $this->Form->postLink('Delete', array('action' => 'delete_currency', $currency['PaymentCurrency']['id']), array('confirm' => 'Are you sure?')); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                <?php elseif ($activeTab == 'methods'): ?>
                
                    <span style="float:right;"><?php echo $this->Html->link('Add Payment Method', array('action' => 'add_method'), 
                            array('class' => 'tiny radius button bg-blue')); ?></span>
                    <table>
                        <tr>
                            <th>Name</th>
                            <th>URL</th>
                            <th>Active</th>
                            <th>Gateway</th>
                            <th>Actions</th>
                        </tr>
                        <?php foreach ($paymentMethods as $method): ?>
                            <tr>
                                <td><?php echo h($method['PaymentMethod']['name']); ?></td>
                                <td><?php echo h($method['PaymentMethod']['url']); ?></td>
                                <td><?php echo $method['PaymentMethod']['active'] ? 'Yes' : 'No'; ?></td>
                                <td><?php echo h($method['PaymentMethod']['gateway']); ?></td>
                                <td>
                                    <?php echo $this->Html->link('Edit', array('action' => 'edit_method', $method['PaymentMethod']['id'])); ?> |
                                    <?php echo $this->Form->postLink('Delete', array('action' => 'delete_method', $method['PaymentMethod']['id']), array('confirm' => 'Are you sure?')); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                <?php elseif ($activeTab == 'exchange_rates'): ?>
                
                    <span style="float:right;"><?php echo $this->Html->link('Add Exchange Rates', 
                            array('action' => 'add_exchange_rates'), array('class' => 'tiny radius button bg-blue')); ?></span>
                    <table>
                        <tr>
                            <th>From Currency</th>
                            <th>To Currency</th>
                            <th>Rate</th>
                            <th>Effective Date</th>
                            <th>Actions</th>
                        </tr>
                        <?php foreach ($exchangeRates as $rate): ?>
                            <tr>
                                <td><?php echo h($rate['FromCurrency']['name']); ?></td>
                                <td><?php echo h($rate['ToCurrency']['name']); ?></td>
                                <td><?php echo h($rate['ExchangeRate']['rate']); ?></td>
                                <td><?php echo h($rate['ExchangeRate']['effective_date']); ?></td>
                                <td>
                                    <?php echo $this->Html->link('Edit', array('action' => 'edit_exchange_rate', $rate['ExchangeRate']['id'])); ?> |
                                    <?php echo $this->Form->postLink('Delete', array('action' => 'delete_exchange_rate', $rate['ExchangeRate']['id']), array('confirm' => 'Are you sure?')); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>