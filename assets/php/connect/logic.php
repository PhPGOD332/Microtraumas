<?php
    require_once('connect.php');

    // Вывод данных из таблицы "Микротравмы"
    $sql = 'SELECT * FROM `microtraumas` WHERE `status` = "В рассмотрении" ORDER BY `date_microtr` DESC';
    $res = $pdo -> query($sql);
    $microtraumas_line = $res -> fetchAll();

    // Вывод данных из таблицы "Микротравмы архив"
    $sql1 = 'SELECT * FROM `microtraumas` WHERE `status` = "Завершено" AND NOW() - INTERVAL 14 DAY ORDER BY `date_microtr` DESC';
    $res1 = $pdo -> query($sql1);
    $microtraumas_archive_line = $res1 -> fetchAll();

    // Вывод данных из таблицы "Студенты"
    $sql2 = 'SELECT * FROM `students` ORDER BY `FIO` ASC';
    $res2 = $pdo -> query($sql2);
    $students_line = $res2 -> fetchAll();

    // Вывод данных из таблицы "Сотрудники"
    $sql3 = 'SELECT * FROM `staff` ORDER BY `FIO` ASC';
    $res3 = $pdo -> query($sql3);
    $staff_line = $res3 -> fetchAll();

    // Вывод данных из таблицы "Пользователи"
    $sql4 = 'SELECT * FROM `users`';
    $res4 = $pdo -> query($sql4);
    $users_line = $res4 -> fetchAll();

    // Вывод данных из таблицы "Последние микротравмы + Пользователи + Группы"
    $sql5 = 'SELECT * FROM `microtraumas` INNER JOIN `students` ON `microtraumas`.`id_student` = `students`.`id_student` INNER JOIN `groups` ON `students`.`id_group` = `groups`.`id_group` WHERE `status` = "В рассмотрении" ORDER BY `date_microtr` DESC';
    $res5 = $pdo -> query($sql5);
    $microtraumas_student_full_line = $res5 -> fetchAll();

    // Вывод данных из таблицы "Архивные микротравмы + Пользователи + Группы"
    $sql6 = 'SELECT * FROM `microtraumas` INNER JOIN `students` ON `microtraumas`.`id_student` = `students`.`id_student` INNER JOIN `groups` ON `students`.`id_group` = `groups`.`id_group` WHERE `status` = "Завершено" AND `date_microtr` >= NOW() - INTERVAL 14 DAY  ORDER BY `date_microtr` DESC';
    $res6 = $pdo -> query($sql6);
    $microtraumas_student_archive_full_line = $res6 -> fetchAll();

    // Вывод данных из таблицы "Группы"
    $sql7 = 'SELECT * FROM `groups` ORDER BY `title_group` ASC';
    $res7 = $pdo -> query($sql7);
    $groups_line = $res7 -> fetchAll();

    // Вывод данных из таблицы "Последние микротравмы + Сотрудники"
    $sql8 = 'SELECT * FROM `microtraumas` INNER JOIN `staff` ON `microtraumas`.`id_staff` = `staff`.`id_staff` WHERE `status` = "В рассмотрении" ORDER BY `date_microtr` DESC';
    $res8 = $pdo -> query($sql8);
    $microtraumas_staff_full_line = $res8 -> fetchAll();

    // Вывод данных из таблицы "Архивные микротравмы + Сотрудники"
    $sql9 = 'SELECT * FROM `microtraumas` INNER JOIN `staff` ON `microtraumas`.`id_staff` = `staff`.`id_staff` WHERE `status` = "Завершено" AND `date_microtr` >= NOW() - INTERVAL 14 DAY ORDER BY `date_microtr` DESC';
    $res9 = $pdo -> query($sql9);
    $microtraumas_staff_archive_full_line = $res9 -> fetchAll();

    // Вывод данных из таблицы "Архивные микротравмы + Сотрудники"
    // $sql10 = 'SELECT * FROM `microtraumas` INNER JOIN `students` ON `microtraumas`.`id_student` = `students`.`id_student` INNER JOIN `groups` ON `students`.`id_group` = `groups`.`id_group` INNER JOIN `staff` ON `microtraumas`.`id_staff` = `staff`.`id_staff` WHERE `status` = "Завершено" AND NOW() - INTERVAL 14 DAY';
    // $res10 = $pdo -> query($sql10);
    // $microtraumas_archive_full_line = $res10 -> fetchAll();

    // Вывод данных из таблицы "Студенты + Группы"
    $sql11 = 'SELECT * FROM `students` INNER JOIN `groups` ON `students`.`id_group` = `groups`.`id_group` ORDER BY `FIO` ASC';
    $res11 = $pdo -> query($sql11);
    $students_groups_line = $res11 -> fetchAll();

    // Вывод данных из "Специальностей"
    $sql12 = 'SELECT * FROM `specializations` ORDER BY `title_specialization` ASC';
    $res12 = $pdo -> query($sql12);
    $specializations_line = $res12 -> fetchAll();

    // Вывод дынных из "Жкрналов"
    $sql13 = 'SELECT * FROM `journals` ORDER BY `archive` ASC';
    $res13 = $pdo -> query($sql13);
    $journals_line = $res13 -> fetchAll();

    // Вывод данных из таблицы "Архивные микротравмы + Сотрудники (Страница - Архив)"
    $sql14 = 'SELECT * FROM `microtraumas` INNER JOIN `staff` ON `microtraumas`.`id_staff` = `staff`.`id_staff` WHERE `status` = "Завершено" ORDER BY `date_microtr` DESC';
    $res14 = $pdo -> query($sql14);
    $microtraumas_staff_archive_line = $res14 -> fetchAll();

    // Вывод данных из таблицы "Архивные микротравмы + Пользователи + Группы (Страница - Архив)"
    $sql15 = 'SELECT * FROM `microtraumas` INNER JOIN `students` ON `microtraumas`.`id_student` = `students`.`id_student` INNER JOIN `groups` ON `students`.`id_group` = `groups`.`id_group` WHERE `status` = "Завершено" ORDER BY `date_microtr` DESC';
    $res15 = $pdo -> query($sql15);
    $microtraumas_student_archive_line = $res15 -> fetchAll();
?>