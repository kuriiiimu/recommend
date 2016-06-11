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
//DBからuser_zemis[zemi1]と同じゼミを第１志望にしているユーザーとその人が登録している科目を取得
$stmt = $pdo->query("SELECT classes.user_id, classes.class1, classes.class2, classes.class3, classes.class4, classes.class5 FROM classes INNER JOIN zemis ON classes.user_id = zemis.user_id WHERE zemis.zemi1 = $user_zemis[zemi1]");
$classIdsByZemi1 = $stmt->fetchAll(PDO::FETCH_ASSOC);

//var_dump($classIdsByZemi1);
//
$sum = array();
foreach($classIdsByZemi1 as $classId){
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
            $class1 => 5
        );
    }else{
        $sum[$class1] = $sum[$class1] + 5;
    }
    if(empty($sum[$class2])){
        $sum += array(
            $class2 => 4
        );
    }else{
        $sum[$class2] = $sum[$class2] + 4;
    }
    if(empty($sum[$class3])){
        $sum += array(
            $class3 => 3
        );
    }else{
        $sum[$class3] = $sum[$class3] + 3;
    }
    if(empty($sum[$class4])){
        $sum += array(
            $class4 => 2
        );
    }else{
        $sum[$class4] = $sum[$class4] + 2;
    }
    if(empty($sum[$class5])){
        $sum += array(
            $class5 => 1
        );
    }else{
        $sum[$class5] = $sum[$class5] + 1;
    }
    //$sum[$class2] = $sum[$class2] + 4;
}
var_dump($sum);
foreach ($zemis as $zemi) {
    $base = $classIdsByZemi1;
    if (count($base) === 0) {
        continue;
    }
    foreach ($class_ids as $class_id){
        if (count($class_id) === 0) {
            continue;
        }
        # ジャッカード指数を計算
        $join = floatval(count(array_unique(array_merge($base, $target))));
        $intersect = floatval(count(array_intersect($base, $target)));
        if ($intersect == 0 || $join == 0) {
            continue;
        }
        $jaccard = $intersect / $join;

        if ($jaccard == 0) {
            continue;
        }
        $Redis->zAdd('Jaccard:Item:' . $item_id1, $jaccard, $item_id2);
    }
}