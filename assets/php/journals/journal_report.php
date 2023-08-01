<?php
    require_once('../connect/logic.php');
    
    $idJournal = $_GET['idJournal'];

    $sql = "SELECT * FROM `journals` WHERE `id_journal` = ?";
    $res = $pdo -> prepare($sql);
    $res -> execute(array($idJournal));
    $journal_line = $res -> fetch();

    $sqlUser = "SELECT * FROM `users` WHERE `role` = 'admin'";
    $resUser = $pdo -> query($sqlUser);
    $user_line = $resUser -> fetch();

    $sqlMicrotr = "SELECT * FROM `microtraumas`  WHERE `id_journal` = ? ORDER BY `date_microtr` DESC";
    $resMicrotr = $pdo -> prepare($sqlMicrotr);
    $resMicrotr -> execute(array($journal_line['id_journal']));
    $microtr_lines = $resMicrotr -> fetchAll();
    $count = count($microtr_lines);

    if($journal_line['type_victim'] == 'students') {
?>
        <div class="report-view" id="journal-report">
            <style>
                .report-inner {
                    display: flex;
                    flex-direction: column;
                }

                .report-inner .title-block {
                    font-size: 25px;
                    text-align: center;
                    margin: 25px 0;
                }

                .report-inner .title-block p {
                    margin: 0;
                }

                .report-inner .title-block .line {
                    margin-top: 15px;
                }

                .report-inner .sub-text {
                    display: inline-block;
                    /* position: absolute; */
                    margin: auto;
                    font-size: 14px;
                    width: 100%;
                    text-align: center;
                }

                .report-inner .date-block {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                }

                .report-inner .date-block p {
                    font-size: 18px;
                    font-weight: 500;
                    text-align: center;
                }

                .report-inner table {
                    max-width: 100%;
                }

                .report-inner table .row-numbers td {
                    text-align: center;
                }

                .report-inner table th {
                    word-break: break-all;
                    padding: 5px;
                }

                .report-inner table td {
                    padding: 5px;
                    word-break: break-all;
                }

                .report-inner table .id-td {
                    text-align: center;
                }

                .underline {
                    text-decoration: underline;
                }
            </style>
            <div class="report-inner">
                <div class="title-block">
                    <p>Журнал учета микроповреждений (микротравм) обучающихся</p>
                    <div class="title-org">
                        <p class="line">______________<span class="underline">ГАПОУ СО &laquo;НТСК&raquo;</span>______________</p>
                        <p class="sub-text">(наименование организации)</p>
                    </div>
                </div>
                <div class="date-block">
                    <div class="date-start">
                        <p>Дата начала ведения журнала - <?=date('d.m.Y', strtotime($journal_line['date_start'])); ?></p>
                    </div>
                    <div class="date-end">
                        <p>Дата окончания ведения журнала - <?=$journal_line['date_end'] == '1970-01-01' ? date('d.m.Y') : date('d.m.Y', strtotime($journal_line['date_end'])); ?></p>
                    </div>
                </div>
                <div class="table-block">
                    <table class="table" border="1" cellspacing="0">
                        <tr>
                            <th>№ п/п</th>
                            <th>ФИО пострадавшего обучаюегося, группа, курс</th>
                            <th>Место и время получения микроповреждения (микротравмы)</th>
                            <th>Обстоятельства получения микроповреждения (микротравмы)</th>
                            <th>Причины микроповреждения (микротравмы)</th>
                            <th>Время обращения в медпункт и поставленный диагнос</th>
                            <th>Принятые меры</th>
                            <th>Последствия микроповреждения (микротравмы)</th>
                            <th>ФИО лица, должность проводившего запись</th>
                        </tr>
                        <tr class="row-numbers">
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                            <td>6</td>
                            <td>7</td>
                            <td>8</td>
                            <td>9</td>
                        </tr>
<?php
                    $iteration = 0;

                    foreach($microtr_lines as $microtr) {
                        $iteration++;

                        $sqlStudent = "SELECT * FROM `students` INNER JOIN `groups` ON `students`.`id_group` = `groups`.`id_group` WHERE `id_student` = ?";
                        $resStudent = $pdo -> prepare($sqlStudent);
                        $resStudent -> execute(array($microtr['id_student']));
                        $student_line = $resStudent -> fetch();

                        $sqlGroup = "SELECT * FROM `groups` WHERE `id_group` = ?";
                        $resGroup = $pdo -> prepare($sqlGroup);
                        $resGroup -> execute(array($microtr['id_group']));
                        $group_line = $resGroup -> fetch();

                        $sqlReason = "SELECT * FROM `reasons` WHERE `id_reason` = ?";
                        $resReason = $pdo -> prepare($sqlReason);
                        $resReason -> execute(array($microtr['id_reason']));
                        $reason_line = $resReason -> fetch();
?>
                        <tr>
                            <td class="id-td"><?=$iteration; ?></td>
                            <td>
                                <?=$student_line['FIO'].', '.$group_line['title_group'].', '.$group_line['course']; ?>
                            </td>
                            <td>
                                <?=$microtr['place_microtr'].', '.date('d.m.Y H:i', strtotime($microtr['date_microtr'])); ?>
                            </td>
                            <td>
                                <?=$microtr['circumstances']; ?>
                            </td>
                            <td>
                                <?=$microtr['id_reason'] == 0 ? $microtr['custom_reason'] : $reason_line['reason_title'] ; ?>
                            </td>
                            <td>
                                <?=date('d.m.Y H:i', strtotime($microtr['date_of_application'])).', '.$microtr['trauma']; ?>
                            </td>
                            <td>
                                <?=$microtr['first_aid']; ?>
                            </td>
                            <td>
                                <?=$microtr['duration_release'] == '' ? 'нет' : 'Освобождение - '.$microtr['duration_release']; ?>
                            </td>
                            <td>
                                <?=$user_line['FIO'].', '.$user_line['post']; ?>
                            </td>
                        </tr>
<?php
                    }
?>
                        <tr>
                            <td colspan="8">
                                Всего микротравм:
                            </td>
                            <td style="text-align: center;">
                                <?=$count; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
<?php
    } else {
?>
        <div class="report-view" id="journal-report">
            <style>
                .report-inner {
                    display: flex;
                    flex-direction: column;
                }

                .report-inner .title-block {
                    font-size: 25px;
                    text-align: center;
                    margin: 25px 0;
                }

                .report-inner .title-block p {
                    margin: 0;
                }

                .report-inner .title-block .line {
                    margin-top: 15px;
                }

                .report-inner .sub-text {
                    display: inline-block;
                    /* position: absolute; */
                    margin: auto;
                    font-size: 14px;
                    width: 100%;
                    text-align: center;
                }

                .report-inner .date-block {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                }

                .report-inner .date-block p {
                    font-size: 18px;
                    font-weight: 500;
                    text-align: center;
                }

                .report-inner table {
                    max-width: 100%;
                }

                .report-inner table .row-numbers td {
                    text-align: center;
                }

                .report-inner table th {
                    word-break: break-all;
                    padding: 5px;
                    width: 11%;
                }

                .report-inner table td {
                    padding: 5px;
                    width: 11%;
                }

                .report-inner table .id-td {
                    text-align: center;
                }
            </style>
            <div class="report-inner">
                <div class="title-block">
                    <p>Журнал учета микроповреждений (микротравм) работников</p>
                    <div class="title-org">
                        <p class="line">_______________________________________</p>
                        <p class="sub-text">(наименование организации)</p>
                    </div>
                </div>
                <div class="date-block">
                    <div class="date-start">
                        <p>Дата начала ведения журнала - <?=date('d.m.Y', strtotime($journal_line['date_start'])); ?></p>
                    </div>
                    <div class="date-end">
                        <p>Дата окончания ведения журнала - <?=$journal_line['date_end'] == '1970-01-01' ? date('d.m.Y') : date('d.m.Y', strtotime($journal_line['date_end'])); ?></p>
                    </div>
                </div>
                <div class="table-block">
                    <table class="table" border="1" cellspacing="0">
                        <tr>
                            <th>№ п/п</th>
                            <th>ФИО пострадавшего работника, должность, подразделение</th>
                            <th>Место и время получения микроповреждения (микротравмы)</th>
                            <th>Обстоятельства получения микроповреждения (микротравмы)</th>
                            <th>Причины микроповреждения (микротравмы)</th>
                            <th>Время обращения в медпункт и поставленный диагнос</th>
                            <th>Принятые меры</th>
                            <th>Последствия микроповреждения (микротравмы)</th>
                            <th>ФИО лица, должность проводившего запись</th>
                        </tr>
                        <tr class="row-numbers">
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                            <td>6</td>
                            <td>7</td>
                            <td>8</td>
                            <td>9</td>
                        </tr>
<?php
                    $iteration = 0;

                    foreach($microtr_lines as $microtr) {
                        $iteration++;

                        $sqlStaff = "SELECT * FROM `staff` WHERE `id_staff` = ?";
                        $resStaff = $pdo -> prepare($sqlStaff);
                        $resStaff -> execute(array($microtr['id_staff']));
                        $staff_line = $resStaff -> fetch();

                        $sqlReason = "SELECT * FROM `reasons` WHERE `id_reason` = ?";
                        $resReason = $pdo -> prepare($sqlReason);
                        $resReason -> execute(array($microtr['id_reason']));
                        $reason_line = $resReason -> fetch();
?>
                        <tr>
                            <td class="id-td"><?=$iteration; ?></td>
                            <td>
                                <?=$staff_line['FIO'].', '.$staff_line['post'].', '.$staff_line['division']; ?>
                            </td>
                            <td>
                                <?=$microtr['place_microtr'].', '.date('d.m.Y H:i', strtotime($microtr['date_microtr'])); ?>
                            </td>
                            <td>
                                <?=$microtr['circumstances']; ?>
                            </td>
                            <td>
                                <?=$microtr['id_reason'] == 0 ? $microtr['custom_reason'] : $reason_line['reason_title'] ; ?>
                            </td>
                            <td>
                                <?=date('d.m.Y H:i', strtotime($microtr['date_of_application'])).', '.$microtr['trauma']; ?>
                            </td>
                            <td>
                                <?=$microtr['first_aid']; ?>
                            </td>
                            <td>
                                <?=$microtr['duration_release'] == '' ? 'нет' : 'Освобождение - '.$microtr['duration_release']; ?>
                            </td>
                            <td>
                                <?=$user_line['FIO'].', '.$user_line['post']; ?>
                            </td>
                        </tr>
<?php
                    }
?>
                        <tr>
                            <td colspan="8">
                                Всего микротравм:
                            </td>
                            <td style="text-align: center;">
                                <?=$count; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
<?php
    }
?>