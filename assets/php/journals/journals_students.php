<?php
    session_start();
    require_once('../connect/logic.php');

    $_SESSION['journal'] = 'students';

    $sql = "SELECT * FROM `journals` WHERE `type_victim` = 'students' ORDER BY `date_start` DESC";
    $res = $pdo -> query($sql);
    $journal_lines = $res -> fetchAll();

    foreach($journal_lines as $line) {
        $sql = "SELECT * FROM `microtraumas` WHERE `id_journal` = ?";
        $res = $pdo -> prepare($sql);
        $res -> execute(array($line['id_journal']));
        $microtr = $res -> fetchAll();
        $countMicrotr = count($microtr);
?>
        <a href="/pages/admin/journal_detailed/index.php?idJournal=<?=$line['id_journal']; ?>" class="row-table <?=$line['archive'] == 1 ? 'archive-row' : 'last-row' ; ?>">
            <input type="hidden" id="id-journal" value="<?=$line['id_journal']; ?>">
            <div class="body-item body-fio">
                <span><?=$line['date_end'] == '1970-01-01' ? 'Журнал от '.date('d.m.Y', strtotime($line['date_start'])) : 'Журнал от '.date('d.m.Y', strtotime($line['date_start'])).' до '.date('d.m.Y', strtotime($line['date_end'])); ?></span>
            </div>
            <div class="body-item body-fio">
                <span><?=$countMicrotr; ?> микротравм</span>
            </div>
            <div class="body-item body-center">
                <span><?=$line['archive'] == 1 ? 'Архив' : 'Действующий' ; ?></span>
            </div>
        </a>
<?php
    }
?>