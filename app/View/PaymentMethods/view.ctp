<div class="box">
    <div class="box-body">
        <div class="row">
            <div
                class="large-12 columns">

                <div
                    class="paymentMethods view">
                    <h2><?php echo __('Payment Method'); ?>
                    </h2>
                    <dl>

                        <dt><?php echo __('Name'); ?>
                        </dt>
                        <dd>
                            <?php echo h($paymentMethod['PaymentMethod']['name']); ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('URL'); ?>
                        </dt>
                        <dd>
                            <?php echo h($paymentMethod['PaymentMethod']['url']); ?>
                            &nbsp;
                        </dd>

                        <dt><?php echo __('Instruction'); ?>
                        </dt>
                        <dd>
                            <?php echo h($paymentMethod['PaymentMethod']['instruction']); ?>
                            &nbsp;
                        </dd>
                        <dt><?php echo __('Logo'); ?>
                        </dt>
                        <dd>

                            <?php

							if (!empty($paymentMethod['Attachment'])) {

								foreach ($paymentMethod['Attachment'] as $ak => $av) {
									if (!empty($av['dirname']) && !empty($av['basename']) && strcasecmp($av['dirname'], 'img') == 0) {

										// echo $this->Media->embed($this->Media->file($av['dirname'].DS.$av['basename']));
										echo '' . $this->Media->embedAsObject($av['dirname'] . DS . $av['basename'], array('width' => 144, 'class' => 'profile-picture'));
									}
								}
							} else {
								echo '<img src="/img/noimage.jpg" width="144" class="profile-picture">';
							}
							?>
                        </dd>

                    </dl>
                </div>


            </div>
        </div>
    </div>
</div>