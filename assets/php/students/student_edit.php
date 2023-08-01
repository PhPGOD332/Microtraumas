<?php
    session_start();
    require_once('../connect/logic.php');

    try {
        $data = [
            'FIO' => $_POST['fio'],
            'img' => $_FILES['img'],
            'address' => $_POST['address'],
            'phone' => $_POST['phone'],
            'idGroup' => $_POST['idGroup'],
            'dateStudy' => $_POST['dateStudy'],
            'dateBirth' => $_POST['dateBirth'],
            'addInfo' => $_POST['addInfo'],
            'idStudent' => $_SESSION['idStudent'],
            'archive' => $_POST['archive']
        ];

        $date = date('Y-m-d');
    
        if($data['img']['size'] > 0) {
            $absPath = $_SERVER['DOCUMENT_ROOT'];
            $imgTmpPath = $data['img']['tmp_name'];
            $imgName = $data['img']['name'];

            if(file_exists($absPath.'/assets/img/students/'.$data['idStudent'])) {
                foreach(glob($absPath.'/assets/img/students/'.$data['idStudent'].'/*') as $file) {
                    unlink($file);
                }

                move_uploaded_file($imgTmpPath, $absPath."/assets/img/students/$data[idStudent]/$imgName");
                $pathDB = "/assets/img/students/$data[idStudent]/$imgName";
            } else {
                mkdir($absPath."/assets/img/students/$data[idStudent]");
                move_uploaded_file($imgTmpPath, $absPath."/assets/img/students/$data[idStudent]/$imgName");
                $pathDB = "/assets/img/students/$data[idStudent]/$imgName";
            }
    
            $sql = "UPDATE `students` SET `img` = ? WHERE `id_student` = ?";
            $res = $pdo -> prepare($sql);
            $res -> execute(array($pathDB, $data['idStudent']));
    
            // array_push($array, $pathDB);
        } else {
            $sql = "UPDATE `students` SET";
            $edit = "";
            $where = " WHERE `id_student` = $data[idStudent]";
            $array = array();
    
            if($edit != '') {
                $edit .= ", `FIO` = ?";
            } else {
                $edit .= " `FIO` = ?";
            }

            array_push($array, $data['FIO']);

            if($edit != '') {
                $edit .= ", `address` = ?";
            } else {
                $edit .= " `address` = ?";
            }

            array_push($array, $data['address']);

            if($edit != '') {
                $edit .= ", `phone` = ?";
            } else {
                $edit .= " `phone` = ?";
            }

            array_push($array, $data['phone']);
    
            if(is_numeric($data['idGroup'])) {
                if($edit != '') {
                    $edit .= ", `id_group` = ?";
                } else {
                    $edit .= " `id_group` = ?";
                }
    
                array_push($array, $data['idGroup']);
            }
    
            if($edit != '') {
                $edit .= ", `admission_to_study` = ?";
            } else {
                $edit .= " `admission_to_study` = ?";
            }

            array_push($array, $data['dateStudy']);
    
            if($data['dateBirth']) {
                if($edit != '') {
                    $edit .= ", `date_birth` = ?";
                } else {
                    $edit .= " `date_birth` = ?";
                }
    
                array_push($array, $data['dateBirth']);
            }
    
            if($edit != '') {
                $edit .= ", `add_information` = ?";
            } else {
                $edit .= " `add_information` = ?";
            }

            array_push($array, $data['addInfo']);
    
            if($data['archive']) {
                if($data['archive'] == 'on') {
                    $data['archive'] = 1;

                    if($edit != '') {
                        $edit .= ", `date_archive` = ?";
                    } else {
                        $edit .= " `date_archive` = ?";
                    }
                    array_push($array, $date);
                } else {
                    $data['archive'] = 0;

                    if($edit != '') {
                        $edit .= ", `date_archive` = '1970-01-01'";
                    } else {
                        $edit .= " `date_archive` = '1970-01-01'";
                    }
                }
    
                if($edit != '') {
                    $edit .= ", `archive` = ?";
                } else {
                    $edit .= " `archive` = ?";
                }
    
                array_push($array, $data['archive']);
            } else {
                $data['archive'] = 0;
                
                if($edit != '') {
                    $edit .= ", `archive` = ?";
                } else {
                    $edit .= " `archive` = ?";
                }
    
                array_push($array, $data['archive']);

                if($edit != '') {
                    $edit .= ", `date_archive` = '1970-01-01'";
                } else {
                    $edit .= " `date_archive` = '1970-01-01'";
                }
            }
    
            if($edit != '') {
                $sql .= $edit;
                $sql .= $where;
                $res = $pdo -> prepare($sql);
                $res -> execute($array);
            }
        }

        echo 'Данные успешно сохранены';
    } catch(Exception $e) {
        echo 'Произошла ошибка - '.$e;
    }

    // header("Location: ../../../pages/admin/student_detailed/index.php?idStudent=$data[idStudent]");
?>