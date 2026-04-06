<?php
if (isset($section_published_courses_for_display) && !empty($section_published_courses_for_display)) { ?>
    <div style="overflow-x:auto;">
        <table cellpadding="0" cellspacing="0" class="table">
            <thead>
                <tr>
                    <th class="center" style="width: 5%;">#</th>
                    <th class="vcenter">Published Course Title</th>
                    <th class="center">Course Code</th>
                    <th class="center">Credit</th>
                    <th class="center">L T L</th>
                    <th class="center">Elective</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                $total_published_credits = 0;
                foreach ($section_published_courses_for_display as $publishedCourse) {
                    if (!empty($publishedCourse)) { 
                        $style = ($publishedCourse['PublishedCourse']['elective'] == 1 ? 'style="color: red;"' : ''); ?>
                        <tr>
                            <td class="center" <?= $style; ?>><?= $count++; ?></td>
                            <td class="vcenter" <?= $style; ?>><?= $this->Html->link($publishedCourse['Course']['course_title'], array('controller' => 'courses', 'action' => 'view', $publishedCourse['PublishedCourse']['id']), array('style' => (empty($style) ? '' : 'color:red;'))); ?></td>
                            <td class="center" <?= $style; ?>><?= $publishedCourse['Course']['course_code']; ?></td>
                            <td class="center" <?= $style; ?>><?= $publishedCourse['Course']['credit']; ?></td>
                            <td class="center" <?= $style; ?>><?= $publishedCourse['Course']['course_detail_hours']; ?></td>
                            <td class="center" <?= $style; ?>><?= ($publishedCourse['PublishedCourse']['elective'] == 1 ? 'Yes' : 'No'); ?></td>
                        </tr>
                        <?php
                        if (isset($publishedCourse['Course']['credit']) && $publishedCourse['Course']['credit']) {
                            $total_published_credits += $publishedCourse['Course']['credit'];
                        }
                    }
                } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"></td>
                    <td class="center">Total</td>
                    <td class="center"><?= $total_published_credits; ?></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <?php 
}  ?>