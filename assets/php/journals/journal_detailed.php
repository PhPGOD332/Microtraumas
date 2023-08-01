<?php
    require_once('../connect/logic.php');

    $idJournal = $_GET['idJournal'];
    
    $sql = "SELECT * FROM `journals` WHERE `id_journal` = ?";
    $res = $pdo -> prepare($sql);
    $res -> execute(array($idJournal));
    $journal_line = $res -> fetch();

    $sqlMicrotr = "SELECT * FROM `microtraumas` INNER JOIN `groups` ON `microtraumas`.`id_group` = `groups`.`id_group` WHERE `microtraumas`.`id_journal` = ?";
    $resMicrotr = $pdo -> prepare($sqlMicrotr);
    $resMicrotr -> execute(array($journal_line['id_journal']));
    $microtr_lines = $resMicrotr -> fetchAll();

    $sql = "SELECT * FROM `microtraumas` WHERE `id_journal` = ?";
    $res = $pdo -> prepare($sql);
    $res -> execute(array($journal_line['id_journal']));
    $microtr = $res -> fetchAll();
    $countMicrotr = count($microtr);

?>
    
    <div class="journal-block" id="<?=$journal_line['id_journal']; ?>">
        <div class="info-block">
            <fieldset>
                <legend>Информация</legend>
                <div class="fieldset-body info-body">
                    <div class="info-row">
                        <span>Дата начала ведения журнала</span>
                        <span><?=date('d.m.Y', strtotime($journal_line['date_start'])); ?></span>
                    </div>
                    <div class="info-row">
                        <span>Дата окончания ведения журнала</span>
                        <span><?=$journal_line['date_end'] == '1970-01-01' ? 'нет' : date('d.m.Y', strtotime($journal_line['date_end'])); ?></span>
                    </div>
                    <div class="info-row">
                        <span>Количество микротравм</span>
                        <span><?=$countMicrotr; ?></span>
                    </div>
                </div>
                <div class="btn-block">
                    <button class="btn" id="report-btn">Печать</button>
                    <!-- <button class="btn">Скачать</button> -->
                </div>
            </fieldset>
        </div>
        <div class="microtr-block">
            <fieldset class="scroll-block">
                <legend>Микротравмы</legend>
                <div class="fieldset-body microtr-body" id="microtr-body">
                    
                </div>
            </fieldset>
        </div>
    </div>