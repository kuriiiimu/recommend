<?php
//PDO接続
require_once("connection.php");
$pdo = db_connection();

//ユーザーの志望ゼミを取得
$user_zemis = [];
$user_zemis = array(
    'zemi1' => 1,
    'zemi2' => 2,
    'zemi3' => 3
);
$sum = array();
//ユーザーが登録した志望ゼミを第１志望ゼミにしている登録済みデータを取りだし、その重み付け後の値を作る
foreach($user_zemis as $user_zemi){
    //foreachで回している回数を取る
    $i = 0;
    //第１志望ゼミのひとと第２志望ゼミのひとと第３志望ゼミのひとの間で重み付け
    $weighting = 30-$i*5;
    //DBからuser_zemisと同じゼミを第１志望にしているユーザーとその人が登録している科目を取得
    $stmt = $pdo->query("SELECT classes.user_id, classes.class1, classes.class2, classes.class3, classes.class4, classes.class5 FROM classes INNER JOIN zemis ON classes.user_id = zemis.user_id WHERE zemis.zemi1 = $user_zemi");
    $classIdsByZemi = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($classIdsByZemi as $classId){
        if(count($classId) == 0){
            continue;
        }
        $class1 = $classId["class1"];
        $class2 = $classId["class2"];
        $class3 = $classId["class3"];
        $class4 = $classId["class4"];
        $class5 = $classId["class5"];
        if(empty($sum[$class1])){
            $sum += array(
                $class1 => $weighting
            );
        }else{
            $sum[$class1] = $sum[$class1] + $weighting;
        }
        if(empty($sum[$class2])){
            $sum += array(
                $class2 => $weighting - 1
        );
        }else{
            $sum[$class2] = $sum[$class2] + $weighting - 1;
        }
        if(empty($sum[$class3])){
            $sum += array(
                $class3 => $weighting - 2
            );
        }else{
            $sum[$class3] = $sum[$class3] + $weighting - 2;
        }
        if(empty($sum[$class4])){
            $sum += array(
                $class4 => $weighting - 3
            );
        }else{
            $sum[$class4] = $sum[$class4] + $weighting - 3;
        }
        if(empty($sum[$class5])){
            $sum += array(
                $class5 => $weighting - 4
            );
        }else{
            $sum[$class5] = $sum[$class5] + $weighting - 4;
        }
    }
    $i ++;
}
var_dump($sum);
//resultから5件だけを確率で取得
//度数の合計
$total = 0;
$weightedClasses = [];
foreach($sum as $item){
    $total = $total + $item;
    $weightedClasses = array(
        array(
            'class_id' => $key,
            'weight'   => $total
        )
    );
}
var_dump($weightedClasses);


