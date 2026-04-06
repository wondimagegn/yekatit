<div class="box">
	<div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class="fontello-attach-outline" style="font-size: larger; font-weight: bold;"></i>
			<span style="font-size: medium; font-weight: bold; margin-top: 20px;"> <?= 'Link Study Program to a Curriculum' ; ?></span>
		</div>

		<a class="close-reveal-modal">&#215;</a>
	</div>
    <div class="row">
        <div class="large-12 columns">
            <hr style="margin-top: 5px;">
            <?php
            if (count($departmentStudyPrograms) == 0 && isset($curriculumDetail['Curriculum'])) { ?>
                <div class="error-box error-message" style="font-family: 'Times New Roman', Times, serif; font-weight: bold;"><span style='margin-right: 15px;'></span>No study program is defined for <i>"<?= $curriculumDetail['Curriculum']['name']; ?>"</i> curriculum. Communicate the Registrar to define Department Study Program for the curriculum with <i>"<?= $curriculumDetail['Program']['name']; ?>"</i> program. </div>
                <?php
            } else if (!empty($departmentStudyPrograms)) { ?>
                <?= $this->Form->create('Curriculum', array('action' => 'add_departmernt_study_program_for_curriculum', "method" => "POST")); ?>
                <?= $this->Form->hidden('id', array('value' => $curriculumDetail['Curriculum']['id'])); ?>
                <div class="row">
                    <div class="large-12 columns">
                        <fieldset style="margin-top: 5px; padding-bottom: 5px;padding-top: 5px;">
                            <legend>&nbsp;&nbsp; <span class="fs16 text-gray"><?= $curriculumDetail['Curriculum']['name']; ?></span> &nbsp;&nbsp;</legend>
                            <span class="fs14 text-gray">
                                <strong>Department: </strong> <?= $curriculumDetail['Department']['name']; ?><br />
                                <strong>Program: </strong> <?= $curriculumDetail['Program']['name']; ?><br />
                                <strong>Degree Nomenclature: </strong> <?= $curriculumDetail['Curriculum']['english_degree_nomenclature']; ?><br />
                                <strong>Specialization: </strong> <?= (!empty($curriculumDetail['Curriculum']['specialization_english_degree_nomenclature']) ? $curriculumDetail['Curriculum']['specialization_english_degree_nomenclature'] : 'N/A' ); ?><br />
                                <strong>Credit Type: </strong> <?= $curriculumDetail['Curriculum']['type_credit']; ?><br />
                                <strong>Minimum Credits Required: </strong> <?= $curriculumDetail['Curriculum']['minimum_credit_points']; ?><br />
                                <strong>Year Introduced: </strong> <?= $this->Time->format("F j, Y", $curriculumDetail['Curriculum']['year_introduced'], NULL, NULL); ?><br />
                            </span>
                            <hr>
                            <?= $this->Form->input('department_study_program_id', array('label' => 'Department Study Program:', 'type' => 'select', 'style' => 'width: 100%;', 'empty' => '[ Select Department Study Program ]', 'required', 'options' => $departmentStudyPrograms)); ?>
                        </fieldset>
                    </div>
                </div>
                <br>
                <?= $this->Form->end(array('label' => 'Attach Selected', 'id' => 'SubmitID', 'class' => 'tiny radius button bg-blue')); ?>
                <?php
            }?>
        </div>
    </div>
</div>
