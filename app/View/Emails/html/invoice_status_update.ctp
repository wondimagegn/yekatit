<h2>Invoice Update: #<?php echo h($invoice['Invoice']['receipt_code']); ?></h2>

<p>Dear <?php echo h($invoice['Invoice']['payer_name']); ?>,</p>

<p>Your invoice status has changed to <strong><?php echo h($newStatus); ?></strong>.</p>

<table style="border-collapse: collapse; width: 100%;">
    <tr><th style="border: 1px solid #ddd; padding: 8px;">Total Amount</th><td style="border: 1px solid #ddd; padding: 8px;">
            <?php echo number_format($invoice['Invoice']['total_amount'], 2); ?> ETB</td></tr>
    <tr><th style="border: 1px solid #ddd; padding: 8px;">Remaining</th><td style="border: 1px solid #ddd; padding: 8px;">
            <?php echo number_format($invoice['Invoice']['remaining'], 2); ?> ETB</td></tr>
    <tr><th style="border: 1px solid #ddd; padding: 8px;">Status</th><td style="border: 1px solid #ddd; padding: 8px;">
            <?php echo h($newStatus); ?></td></tr>
</table>

<?php if ($newStatus === 'Overpaid'): ?>
    <p>Note: There is an overpayment of <?php echo number_format(abs($invoice['Invoice']['remaining']), 2); ?> ETB.
        Please contact support for a refund or credit.</p>
<?php endif; ?>

<p>Thank you,<br><?php echo Configure::read('ApplicationShortName'); ?> </p>

