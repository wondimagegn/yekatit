<?php
$items = isset($items) ? $items : array();
$type = isset($type) ? $type : '';

if (empty($items)):
    ?>
    <p><?php echo __('No backups found.'); ?></p>
    <?php
    return;
endif;
?>

<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped">
    <thead>
    <tr>
        <th><?php echo __('Filename'); ?></th>
        <th><?php echo __('Size'); ?></th>
        <th><?php echo __('Modified'); ?></th>
        <th><?php echo __('Status'); ?></th>
        <th><?php echo __('Created By'); ?></th>
        <th><?php echo __('Created At'); ?></th>
        <th><?php echo __('Restored By'); ?></th>
        <th><?php echo __('Restored At'); ?></th>
        <?php if ($type !== 'database'): ?>
            <th><?php echo __('Base Full'); ?></th>
            <th><?php echo __('Changed'); ?></th>
            <th><?php echo __('Deleted'); ?></th>
        <?php endif; ?>
        <th><?php echo __('Last Error'); ?></th>
        <th class="actions"><?php echo __('Actions'); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($items as $item): ?>
        <?php
        $file = $item['file'];
        $record = $item['record'];

        $status = !empty($record['Backup']['status']) ? $record['Backup']['status'] : __('untracked');

        $createdBy = '-';
        if (!empty($record['CreatedBy']['id'])) {
            $nameParts = array_filter(array(
                !empty($record['CreatedBy']['first_name']) ? $record['CreatedBy']['first_name'] : '',
                !empty($record['CreatedBy']['middle_name']) ? $record['CreatedBy']['middle_name'] : '',
                !empty($record['CreatedBy']['last_name']) ? $record['CreatedBy']['last_name'] : '',
            ));
            $createdBy = !empty($nameParts) ? implode(' ', $nameParts) : (!empty($record['CreatedBy']['username']) ? $record['CreatedBy']['username'] : $record['CreatedBy']['id']);
        }

        $restoredBy = '-';
        if (!empty($record['RestoredBy']['id'])) {
            $nameParts = array_filter(array(
                !empty($record['RestoredBy']['first_name']) ? $record['RestoredBy']['first_name'] : '',
                !empty($record['RestoredBy']['middle_name']) ? $record['RestoredBy']['middle_name'] : '',
                !empty($record['RestoredBy']['last_name']) ? $record['RestoredBy']['last_name'] : '',
            ));
            $restoredBy = !empty($nameParts) ? implode(' ', $nameParts) : (!empty($record['RestoredBy']['username']) ? $record['RestoredBy']['username'] : $record['RestoredBy']['id']);
        }

        $createdAt = !empty($record['Backup']['created_at']) ? $record['Backup']['created_at'] : '-';
        $restoredAt = !empty($record['Backup']['restored_at']) ? $record['Backup']['restored_at'] : '-';
        $errorMessage = !empty($record['Backup']['error_message']) ? $record['Backup']['error_message'] : '-';
        $baseFull = !empty($file['base_full']) ? $file['base_full'] : (!empty($record['Backup']['base_filename']) ? $record['Backup']['base_filename'] : '-');
        $changedCount = isset($file['changed_count']) ? $file['changed_count'] : '-';
        $deletedCount = isset($file['deleted_count']) ? $file['deleted_count'] : '-';
        ?>
        <tr>
            <td><?php echo h($file['name']); ?></td>
            <td><?php echo number_format($file['size'] / 1024, 2); ?> KB</td>
            <td><?php echo h($file['modified']); ?></td>
            <td><?php echo h($status); ?></td>
            <td><?php echo h($createdBy); ?></td>
            <td><?php echo h($createdAt); ?></td>
            <td><?php echo h($restoredBy); ?></td>
            <td><?php echo h($restoredAt); ?></td>

            <?php if ($type !== 'database'): ?>
                <td><?php echo h($baseFull); ?></td>
                <td><?php echo h($changedCount); ?></td>
                <td><?php echo h($deletedCount); ?></td>
            <?php endif; ?>

            <td style="max-width:240px;word-break:break-word;"><?php echo h($errorMessage); ?></td>
            <td class="actions">
                <?php if ($type === 'database'): ?>
                    <?php
                    echo $this->Html->link(__('Download'), array('controller' => 'backups', 'action' => 'download_database', $file['name']));
                    echo ' ';
                    echo $this->Form->postLink(
                        __('Restore'),
                        array('controller' => 'backups', 'action' => 'restore_database', $file['name']),
                        array(),
                        __('This will overwrite the current database. Continue?')
                    );
                    echo ' ';
                    echo $this->Form->postLink(
                        __('Delete'),
                        array('controller' => 'backups', 'action' => 'delete_database', $file['name']),
                        array(),
                        __('Delete this database backup?')
                    );
                    ?>
                <?php elseif ($type === 'media_full'): ?>
                    <?php
                    echo $this->Html->link(__('Download'), array('controller' => 'backups', 'action' => 'download_media_full', $file['name']));
                    echo ' ';
                    echo $this->Form->postLink(
                        __('Restore Full'),
                        array('controller' => 'backups', 'action' => 'restore_media_full', $file['name']),
                        array(),
                        __('This will overwrite the current media folder. Continue?')
                    );
                    echo ' ';
                    echo $this->Form->postLink(
                        __('Delete'),
                        array('controller' => 'backups', 'action' => 'delete_media_full', $file['name']),
                        array(),
                        __('Delete this media full backup?')
                    );
                    ?>
                <?php else: ?>
                    <?php
                    echo $this->Html->link(__('Download'), array('controller' => 'backups', 'action' => 'download_media_incremental', $file['name']));
                    echo ' ';
                    echo $this->Form->postLink(
                        __('Restore Chain'),
                        array('controller' => 'backups', 'action' => 'restore_media_incremental_chain', $file['name']),
                        array(),
                        __('This will restore the base full backup plus incrementals up to this point, overwriting the current media folder. Continue?')
                    );
                    echo ' ';
                    echo $this->Form->postLink(
                        __('Delete'),
                        array('controller' => 'backups', 'action' => 'delete_media_incremental', $file['name']),
                        array(),
                        __('Delete this media incremental backup?')
                    );
                    ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
