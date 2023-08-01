<?php
    session_start();
    require_once('../connect/logic.php');
?>
    <html>
        <head>
            <meta charset="utf-8">
            <link rel="stylesheet" href="/assets/css/style.css">
        </head>
<?php
    try {
        $data = [
            'FIO' => $_POST['fio'],
            'img' => $_FILES['img'],
            'post' => $_POST['post'],
            'division' => $_POST['division'],
            'category' => $_POST['category'],
            'director' => $_POST['director'],
            'dateHiring' => $_POST['dateHiring'],
            'dateBirth' => $_POST['dateBirth'],
            'SNILS' => $_POST['SNILS'],
            'exp' => $_POST['exp'],
            'email' => $_POST['email'],
            'passport' => $_POST['passport'],
            'address' => $_POST['address'],
            'combining' => $_POST['combining'],
            'disability' => $_POST['disability'],
            'maternity' => $_POST['maternity'],
            'pregnancy' => $_POST['pregnancy'],
            'easywork' => $_POST['easywork'],
            'addInfo' => $_POST['addInfo'],
            'archive' => $_POST['archive'],
            'idStaff' => $_POST['idStaff']
        ];

        $date = date('Y-m-d');
    
        $sql = "UPDATE `staff` SET";
        $edit = "";
        $where = " WHERE `id_staff` = $data[idStaff]";
        $array = array();
    
        if($data['img']['size'] > 0) {
            if($edit != '') {
                $absPath = $_SERVER['DOCUMENT_ROOT'];
                $imgTmpPath = $data['img']['tmp_name'];
                $imgName = $data['img']['name'];
    
                if(file_exists($absPath.'/assets/img/staff/'.$data['idStaff'])) {
                    foreach(glob($absPath.'/assets/img/staff/'.$data['idStaff'].'/*') as $file) {
                        unlink($file);
                    }
    
                    move_uploaded_file($imgTmpPath, $absPath."/assets/img/staff/$data[idStaff]/$imgName");
                    $pathDB = "/assets/img/staff/$data[idStaff]/$imgName";
                } else {
                    mkdir($absPath."/assets/img/staff/$data[idStaff]");
                    move_uploaded_file($imgTmpPath, $absPath."/assets/img/staff/$data[idStaff]/$imgName");
                    $pathDB = "/assets/img/staff/$data[idStaff]/$imgName";
                }
                $edit .= ", `img` = ?";
            } else {
                $absPath = $_SERVER['DOCUMENT_ROOT'];
                $imgTmpPath = $data['img']['tmp_name'];
                $imgName = $data['img']['name'];
    
                if(file_exists($absPath.'/assets/img/staff/'.$data['idStaff'])) {
                    foreach(glob($absPath.'/assets/img/staff/'.$data['idStaff'].'/*') as $file) {
                        unlink($file);
                    }
    
                    move_uploaded_file($imgTmpPath, $absPath."/assets/img/staff/$data[idStaff]/$imgName");
                    $pathDB = "/assets/img/staff/$data[idStaff]/$imgName";
                } else {
                    mkdir($absPath."/assets/img/staff/$data[idStaff]");
                    move_uploaded_file($imgTmpPath, $absPath."/assets/img/staff/$data[idStaff]/$imgName");
                    $pathDB = "/assets/img/staff/$data[idStaff]/$imgName";
                }
                
                $edit .= " `img` = ?";
            }
    
            array_push($array, $pathDB);
        }
    
        if($edit != '') {
            $edit .= ", `FIO` = ?";
        } else {
            $edit .= " `FIO` = ?";
        }

        array_push($array, $data['FIO']);

        if($edit != '') {
            $edit .= ", `post` = ?";
        } else {
            $edit .= " `post` = ?";
        }

        array_push($array, $data['post']);

        if($edit != '') {
            $edit .= ", `division` = ?";
        } else {
            $edit .= " `division` = ?";
        }

        array_push($array, $data['division']);

        if($edit != '') {
            $edit .= ", `personnel_category` = ?";
        } else {
            $edit .= " `personnel_category` = ?";
        }

        array_push($array, $data['category']);

        if($edit != '') {
            $edit .= ", `director` = ?";
        } else {
            $edit .= " `director` = ?";
        }

        array_push($array, $data['director']);

        if($data['dateHiring']) {
            if($edit != '') {
                $edit .= ", `date_hiring` = ?";
            } else {
                $edit .= " `date_hiring` = ?";
            }
    
            array_push($array, $data['dateHiring']);
        }

        if($data['dateBirth']) {
            if($edit != '') {
                $edit .= ", `date_birth` = ?";
            } else {
                $edit .= " `date_birth` = ?";
            }
    
            array_push($array, $data['dateBirth']);
        }

        $data['SNILS'] = str_replace(' ', '', str_replace('-', '', $data['SNILS']));
        if($edit != '') {
            $edit .= ", `SNILS` = ?";
        } else {
            $edit .= " `SNILS` = ?";
        }

        array_push($array, $data['SNILS']);

        if($edit != '') {
            $edit .= ", `experience` = ?";
        } else {
            $edit .= " `experience` = ?";
        }

        array_push($array, $data['exp']);

        if($edit != '') {
            $edit .= ", `email` = ?";
        } else {
            $edit .= " `email` = ?";
        }

        array_push($array, $data['email']);
    
        $data['passport'] = str_replace(' ', '', str_replace('-', '', $data['passport']));
        if($edit != '') {
            $edit .= ", `№_passport` = ?";
        } else {
            $edit .= " `№_passport` = ?";
        }

        array_push($array, $data['passport']);

        if($edit != '') {
            $edit .= ", `address` = ?";
        } else {
            $edit .= " `address` = ?";
        }

        array_push($array, $data['address']);

        if($data['combining']) {
            if($data['combining'] == 'on') {
                $data['combining'] = 1;
            } else {
                $data['combining'] = 0;
            }

            if($edit != '') {
                $edit .= ", `combining` = ?";
            } else {
                $edit .= " `combining` = ?";
            }
    
            array_push($array, $data['combining']);
        } else {
            $data['combining'] = 0;
            
            if($edit != '') {
                $edit .= ", `combining` = ?";
            } else {
                $edit .= " `combining` = ?";
            }
    
            array_push($array, $data['combining']);
        }

        if($data['disability']) {
            if($data['disability'] == 'on') {
                $data['disability'] = 1;
            } else {
                $data['disability'] = 0;
            }

            if($edit != '') {
                $edit .= ", `disability` = ?";
            } else {
                $edit .= " `disability` = ?";
            }
    
            array_push($array, $data['disability']);
        } else {
            $data['disability'] = 0;
            
            if($edit != '') {
                $edit .= ", `disability` = ?";
            } else {
                $edit .= " `disability` = ?";
            }
    
            array_push($array, $data['disability']);
        }

        if($data['maternity']) {
            if($data['maternity'] == 'on') {
                $data['maternity'] = 1;
            } else {
                $data['maternity'] = 0;
            }

            if($edit != '') {
                $edit .= ", `maternity_leave` = ?";
            } else {
                $edit .= " `maternity_leave` = ?";
            }
    
            array_push($array, $data['maternity']);
        } else {
            $data['maternity'] = 0;
            
            if($edit != '') {
                $edit .= ", `maternity_leave` = ?";
            } else {
                $edit .= " `maternity_leave` = ?";
            }
    
            array_push($array, $data['maternity']);
        }

        if($data['pregnancy']) {
            if($data['pregnancy'] == 'on') {
                $data['pregnancy'] = 1;
            } else {
                $data['pregnancy'] = 0;
            }

            if($edit != '') {
                $edit .= ", `pregnancy` = ?";
            } else {
                $edit .= " `pregnancy` = ?";
            }
    
            array_push($array, $data['pregnancy']);
        } else {
            $data['pregnancy'] = 0;
            
            if($edit != '') {
                $edit .= ", `pregnancy` = ?";
            } else {
                $edit .= " `pregnancy` = ?";
            }
    
            array_push($array, $data['pregnancy']);
        }

        if($data['easywork']) {
            if($data['easywork'] == 'on') {
                $data['easywork'] = 1;
            } else {
                $data['easywork'] = 0;
            }

            if($edit != '') {
                $edit .= ", `easy_work` = ?";
            } else {
                $edit .= " `easy_work` = ?";
            }
    
            array_push($array, $data['easywork']);
        } else {
            $data['easywork'] = 0;
            
            if($edit != '') {
                $edit .= ", `easy_work` = ?";
            } else {
                $edit .= " `easy_work` = ?";
            }
    
            array_push($array, $data['easywork']);
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
        
        echo "Данные успешно сохранены";
    } catch(Exception $e) {
        echo "Произошла ошибка - ".$e;
    }

    // header("Location: ../../../pages/admin/student_detailed/index.php?idStudent=$data[idStudent]");
?>
    </html>