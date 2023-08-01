<?php
    session_start();
    require_once('../connect/logic.php');

    $dateStart = $_POST['dateStart'];
    $dateEnd = $_POST['dateEnd'];
    $status = $_POST['status'];
    $count = 0;

    $dateStartFormat = date('d.m.Y', strtotime($dateStart));
    $dateEndFormat = date('d.m.Y', strtotime($dateEnd));

    $array = array($dateStart);

    $sql = "SELECT * FROM `microtraumas` WHERE `date_microtr` >= ?";

    if($dateEnd) {
        $sql .= " AND `date_microtr` <= ?";
        array_push($array, $dateEnd);
    }

    if($status) {
        $sql .= " AND `status` LIKE ?";
        array_push($array, $status);
    }

    echo $status;
    
    $res = $pdo -> prepare($sql);
    $res -> execute($array);
    $microtr_line = $res -> fetchAll();
?>
    <div class="preview" id="preview">
        <div class="preview-title-block">
            <div class="title-block">
                <span>Предпросмотр справки</span>
            </div>
        </div>
        <div class="preload-view">
            <div class="preview-inner" id="capture">
                <style>
                    .title-block > p {
                        font-size: 25px;
                        font-weight: 600;
                        text-align: center;
                        padding-bottom: 20px;
                    }

                    table {
                        margin: 0px auto;
                    }

                    table th {
                        padding: 5px 10px;
                    }

                    table td {
                        padding: 5px 10px;
                    }

                    table .date-td {
                        text-align: center;
                    }

                    .signature {
                        margin-top: 25px;
                    }

                    .signature > .sub-text {
                        display: inline-block;
                        /* position: absolute; */
                        margin: auto;
                        font-size: 13px;
                        width: 100%;
                        text-align: center;
                        margin-top: -15px;
                    }
                </style>
                <div class="title-block">
                    <p>Отчетность по микротравмам в ГАПОУ СО &laquo;НТСК&raquo; за период от <?=$dateStartFormat; ?> до <?=$dateEndFormat != '01.01.1970' ? $dateEndFormat : date('d.m.Y'); ?></p>
                </div>
                <div class="text-block">
                    <table border="1" cellspacing="0">
                        <tr>
                            <th>
                                ФИО
                            </th>
                            <th>
                                Поставленный диагноз
                            </th>
                            <th>
                                Дата и время микротравмы
                            </th>
                        </tr>
                    <?php
                        foreach($microtr_line as $line):
                            if($line['id_staff'] == 0):
                                $sqlStudent = "SELECT * FROM `students` WHERE `id_student` = ?";
                                $resStudent = $pdo -> prepare($sqlStudent);
                                $resStudent -> execute(array($line['id_student']));
                                $lineStudent = $resStudent -> fetch();
                                $count++;
                    ?> 
                            <tr>
                                <td>
                                    <?=$lineStudent['FIO']; ?>
                                </td>
                                <td>
                                    <?=$line['trauma']; ?>
                                </td>
                                <td class="date-td">
                                    <?=date('d.m.Y H:i', strtotime($line['date_microtr'])); ?>
                                </td>
                            </tr>
                    <?php
                            else:
                                $sqlStaff = "SELECT * FROM `staff`  WHERE `id_staff` = ?";
                                $resStaff = $pdo -> prepare($sqlStaff);
                                $resStaff -> execute(array($line['id_staff']));
                                $lineStaff = $resStaff -> fetch();
                                $count++;
                    ?>
                            <tr>
                                <td>
                                    <?=$lineStaff['FIO']; ?>
                                </td>
                                <td>
                                    <?=$line['truma']; ?>
                                </td>
                                <td class="date-td">
                                    <?=date('d.m.Y H:i', strtotime($line['date_microtr'])); ?>
                                </td>
                            </tr>
                    <?php
                            endif;
                        endforeach;
                    ?>
                        <tr>
                            <td colspan="2">
                                Итого микротравм:
                            </td>
                            <td style="text-align: center">
                                <?=$count; ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="text-block signature">
                    <p>Подпись: _______________________________________________________________________________</p>
                    <span class="sub-text">(Фамилия, инициалы, должность, дата)</span>
                </div>
            </div>
        </div>
        <div class="btn-block">
            <button class="btn" id="download-btn">Скачать</button>
            <button class="btn" id="close-btn">Свернуть</button>
        </div>
    </div>