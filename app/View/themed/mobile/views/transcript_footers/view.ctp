<div class="transcriptFooters view">
<div class="smallheading"><?php  __('Transcript Footer View');?></div>
<table>
	<tr>
		<td style="width:15%">Footer Line 1</td>
		<td style="width:85%"><?php echo $transcriptFooter['TranscriptFooter']['line1']; ?></td>
	</tr>
	<tr>
		<td>Footer Line 2</td>
		<td><?php echo $transcriptFooter['TranscriptFooter']['line2']; ?></td>
	</tr>
	<tr>
		<td>Footer Line 3</td>
		<td><?php echo $transcriptFooter['TranscriptFooter']['line3']; ?></td>
	</tr>
	<tr>
		<td>Program:</td>
		<td><?php echo $transcriptFooter['Program']['name']; ?></td>
	</tr>
	<tr>
		<td>Admission Year:</td>
		<td><?php echo $transcriptFooter['TranscriptFooter']['academic_year']; ?></td>
	</tr>
	<tr>
		<td>Date Created:</td>
		<td><?php echo $this->Format->humanize_date($transcriptFooter['TranscriptFooter']['created']); ?></td>
	</tr>
	<tr>
		<td>Date Modified:</td>
		<td><?php echo $this->Format->humanize_date($transcriptFooter['TranscriptFooter']['modified']); ?></td>
	</tr>
</table>
</div>
