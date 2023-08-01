<?php
    session_start();
    require_once('../connect/logic.php');

    try {
        $date = date('Y-m-d');
        $sql7 = 'SELECT * FROM `groups` ORDER BY `title_group` DESC';
        $res7 = $pdo -> query($sql7);
        $groups_line = $res7 -> fetchAll();
    
        foreach($groups_line as $group) {
            $title_group = $group['title_group'];
            $title_next_group = '';
            
            $sqlStudents = "SELECT * FROM `students` WHERE `id_group` = ?";
            $resStudents = $pdo -> prepare($sqlStudents);
            $resStudents -> execute(array($group['id_group']));
            $students_line = $resStudents -> fetchAll();
    
            if($group['course'] == $group['max_course']) {
                foreach($students_line as $student) {
                    $sql = "UPDATE `students` SET `archive` = 1, `date_archive` = ? WHERE `id_student` = ?";
                    $res = $pdo -> prepare($sql);
                    $res -> execute(array($date, $student['id_student']));
                }
            } else {
                $count = 0;
                foreach(str_split($title_group) as $simbol) {
                    if(is_numeric($simbol) && $count == 0) {
                        $simbol++;
                        $count++;
                    }
    
                    $title_next_group .= $simbol;
                }
    
                $sqlNextGroup = "SELECT * FROM `groups` WHERE `title_group` LIKE ?";
                $resNextGroup = $pdo -> prepare($sqlNextGroup);
                $resNextGroup -> execute(array("$title_next_group"));
                $next_group_line = $resNextGroup -> fetch();
    
                if(!$next_group_line) {
                    echo "Одной из предшествующих групп не существует. Пожалуйста, убедитесь, что все группы существуют.";
                    $count_errors++;
                    exit;
                } else {
                    foreach($students_line as $student) {
                        $sqlUpdateStudent = "UPDATE `students` SET `id_group` = ? WHERE `id_student` = ?";
                        $resUpdateStudent = $pdo -> prepare($sqlUpdateStudent);
                        $resUpdateStudent -> execute(array($next_group_line['id_group'], $student['id_student']));
                    }
                }
            }
        }

        echo 'Все студенты успешно переведены на следующий курс';
    } catch(Exception $e) {
        echo 'Произошла ошибка - '.$e;
    }
?>