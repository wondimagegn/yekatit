<?php ?>	
<table style="width:100%;border:0px;" class="condence" id="AutoMessage">
		
			<?php
			if(empty($auto_messages)) {
				echo '<tr><td style="border:0px solid #ffffff" colspan="2"><p style="padding-bottom:17px">There is no message to display.</p></td></tr>';
			}
			else {
				foreach($auto_messages as $key => $auto_message) {
					?>
					<tr id="<?php echo $auto_message['AutoMessage']['id']; ?>1">
						<td style="font-size:10px; font-weight:bold"><?php echo $this->Format->humanize_date($auto_message['AutoMessage']['created']); ?> (<span style="color:red; cursor:url('../img/error.ico'), default" onclick="closeMessage('<?php echo $auto_message['AutoMessage']['id']; ?>')">close</span>)</td>
					</tr>
					<tr id="<?php echo $auto_message['AutoMessage']['id']; ?>2">
						<td style="padding-left:10px"><?php echo $auto_message['AutoMessage']['message']; ?></td>
					</tr>
					<?php
				}
			}
			?>
</table>
