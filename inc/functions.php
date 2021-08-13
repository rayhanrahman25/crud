<?php
define('STUDENT_DATABASE','/Program Files/Ampps/www/crud/data/db.txt');
//=================== seed function =======================
function seed(){
    $student = [
        [
            'id'    => '1',
            'fname' => 'Rayhan',
            'lname' => 'Rahman',
            'roll'  => 22,
        ],
        [
            'id'    => 2,
            'fname' => 'Kaisher',
            'lname' => 'Saikat',
            'roll'  => 23,
        ],
        [
            'id'    => 3,
            'fname' => 'Mahumd',
            'lname' => 'Tonmoy',
            'roll'  => 04,
        ],
        [
            'id'    => 4,
            'fname' => 'Sabbirul',
            'lname' => 'Shakil',
            'roll'  => 25,
        ],
        [
            'id'    => 5,
            'fname' => 'Kazi',
            'lname' => 'Rabbi',
            'roll'  => 26,
        ],
    ];
  $data = serialize($student);
  file_put_contents(STUDENT_DATABASE, $data);
}
// ============================ all student function =======================
function addStudent(){
    $data = file_get_contents(STUDENT_DATABASE);
    $students = unserialize($data);
    ?>
    <table>
        <tr>
            <th>Name</th>
            <th>Roll</th>
            <th>Action</th>
        </tr>
        <?php
        foreach($students as $student){
         ?>
         <tr>
             <td><?php printf("%s %s", $student['fname'], $student['lname']); ?></td>
             <td><?php printf("%s ", $student['roll']); ?></td>
             <td><?php  printf("<a href='/crud/index.php?task=edit&id=%s'>Edit</a> | <a class='delete' href='/crud/index.php?task=delete&id=%s'>Delete</a>",$student['id'],$student['id']); ?></td>
         </tr>
         <?
        }
        ?>
    </table>
    <?
}
//=============================  add student function ===============
function addOneStudent($fname, $lname, $roll){
    $found = '';
    $data = file_get_contents(STUDENT_DATABASE);
    $students = unserialize($data);
    $id = newId($students);
    foreach($students as $_student){
        if($_student['roll'] == $roll){
            $found = true;
            break;
        }
    }
    if(!$found){
    $inputStudent = [
        'id'=>$id,
        'fname'=>$fname,
        'lname'=>$lname,
        'roll'=>$roll
    ];
    array_push($students, $inputStudent);
 $data2 = serialize($students);
 file_put_contents(STUDENT_DATABASE, $data2);
 return true;
}
return false;
}

//======================= edit student function =================
function editStudent($id){
    $data = file_get_contents(STUDENT_DATABASE);
    $students = unserialize($data);
    foreach($students as $_student){
        if($_student['id'] == $id){
            return $_student;
        }
    }
}
function editNupdate($id, $fname,$lname,$roll){
    $found = false;
    $data = file_get_contents(STUDENT_DATABASE);
    $students = unserialize($data);
    foreach($students as $_student){
        if($_student['roll'] == $roll && $_student['id'] != $id){
            $found = true;
            break;
        }
    }
    if(!$found){
    $students[$id - 1]['fname'] = $fname;
    $students[$id - 1]['lname'] = $lname;
    $students[$id - 1]['roll'] = $roll;
    $data2 = serialize($students);
    file_put_contents(STUDENT_DATABASE, $data2);
    return true;
}
return false;
}
function deleteStudent($id){
    $data = file_get_contents(STUDENT_DATABASE);
    $students = unserialize($data);
  unset($students[$id-1]);
  $data2 = serialize($students);
  file_put_contents(STUDENT_DATABASE, $data2, LOCK_EX);
}
function newId($students){
    $maxVal = max(array_column($students,'id'));
    return $maxVal+1;
}