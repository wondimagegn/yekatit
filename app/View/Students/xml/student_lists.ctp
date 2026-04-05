<root>
	<students>
		<?= $xml->serialize($students) ?>
	</students>
	<colleges>
		<?= $xml->serialize($colleges) ?>
	</colleges>
	<departments>
		<?= $xml->serialize($departments) ?>
	</departments>
	<sections>
		<?= $xml->serialize($sections);?>
	</sections>
</root>
