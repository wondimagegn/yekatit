<?php ?>
<div class="box">
    <div class="box-body">
        <div class="row">
            <div
                class="large-12 columns">

                <div
                    class="acceptedStudents index">
                    <?php echo $this->Form->create('AcceptedStudent', array('controller' => 'acceptedStudents', 'action' => 'import_newly_students', 'type' => 'file'));

                    ?>
                    <table>
                        <tbody>
                            <tr>
                                <th
                                    colspan=5>
                                    <p
                                        class="fs16">
                                        <span
                                            class="rejected">Be-aware:</span>
                                        Before
                                        importing
                                        the
                                        excel
                                        ,make
                                        sure
                                        that
                                        the
                                        value
                                        of
                                        department,field
                                        of
                                        study,
                                        region,
                                        program,program
                                        types,
                                        and
                                        field
                                        of
                                        study
                                        (if
                                        exist)
                                        field
                                        as
                                        listed
                                        below.
                                        If
                                        you
                                        think
                                        there
                                        is
                                        a
                                        missing
                                        stream,de,region,
                                        program
                                        type,
                                        and
                                        program
                                        name,department,
                                        please
                                        contact
                                        the
                                        system
                                        administrator.
                                        Click
                                        the
                                        link
                                        below
                                        to
                                        download
                                        the
                                        excel
                                        template
                                        that
                                        shows
                                        you
                                        how
                                        you
                                        can
                                        store
                                        the
                                        data
                                        in
                                        excel
                                        that
                                        are
                                        compatible
                                        with
                                        the
                                        system
                                        database.
                                        <a
                                            href="/files/template/template.xls">Download
                                            Import
                                            Template!</a>
                                    </p>
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                    echo "<table><tbody><tr><th>Import Accepted Students</th></tr>";
                                    echo "<tr><td>";
                                    echo $this->Form->input('AcceptedStudent.academicyear', array(
                                        'id' => 'academicyear',
                                        'label' => 'Academic Year', 'type' => 'select', 'options' => $acyear_array_data,
                                        'empty' => "--Select Academic Year--",
                                        'selected' => isset($this->request->data['AcceptedStudent']['academicyear'])
                                            && !empty($this->request->data['AcceptedStudent']['academicyear']) ?
                                            $this->request->data['AcceptedStudent']['academicyear'] : ''
                                    ));
                                    echo "</td></tr><tr><td>";

                                    echo $this->Form->file('File') . '</td></tr>';
                                    echo '<tr><td>' . $this->Form->submit(
                                        'Upload',
                                        array('class' => 'tiny radius button bg-blue')
                                    ) . '</td></tr></tbody></table>';
                                    ?>
                                </td>
                                <td
                                    width='30%'>
                                    <?php
                                    echo "<table><tbody><tr><th>Stream</th>";
                                    /* foreach($colleges as $ck=>$cv) {
        echo "<tr><td>".$cv."</td></tr>";
    }
    */
                                    foreach ($departments_organized_by_college as $college => $department) {
                                        echo "<tr><td><strong>" . $college . "</strong></td></tr>";
                                        echo "<tr><td><table>";
                                        foreach ($department as $k => $dep) {
                                            echo "<tr><td>" . $dep . "</td></tr>";
                                        }
                                        echo "</table></td></tr>";
                                    }
                                    echo "</tbody></table>";
                                    ?>

                                </td>
                                <td>
                                    <?php
                                    echo "<table><tbody><tr><th>Regions</th></tr>";
                                    foreach ($regions as $ck => $cv) {
                                        echo "<tr><td>" . $cv . "</td></tr>";
                                    }
                                    echo "</tbody></table>";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo "<table><tbody><tr><th>Program</th></tr>";

                                    foreach ($programs as $ck => $cv) {
                                        echo "<tr><td>" . $cv . "</td></tr>";
                                    }
                                    echo "</tbody></table>";

                                    echo "<table><tbody><tr><th>Attended Stream</th></tr>";
                                    foreach ($streams as $ck => $cv) {
                                        echo "<tr><td>" . $cv . "</td></tr>";
                                    }
                                    echo "</tbody></table>";

                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo "<table><tbody><tr><th>Program Types</th></tr>";
                                    foreach ($programTypes as $ck => $cv) {
                                        echo "<tr><td>" . $cv . "</td></tr>";
                                    }
                                    echo "</tbody></table>";


                                    ?>
                                </td>

                                <td>

                                </td>

                            </tr>
                            <tr>
                                <?php
                                if (isset($non_valide_rows)) {
                                    echo "<td colspan=5>";
                                    echo "<ul style='color:red'>";
                                    foreach ($non_valide_rows as $k => $v) {
                                        echo "<li>" . $v . "</li>";
                                    }
                                    echo "</ul>";
                                    echo "</td></tr>";
                                }

                                ?>
                        </tbody>
                    </table>
                    <?php
                    echo $this->Form->end();

                    ?>
                </div>
            </div>
            <!-- end of columns 12 -->
        </div>
        <!--- end of row -->
    </div>
    <!--- end of box-body -->
</div>
<!--- end of box -->