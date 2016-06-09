<?php
//PDO接続
$dsn = 'mysql:dbname=recommend;host=localhost';
$user = 'root';
$password = 'wjinka';
$pdo = new PDO($dsn,$user,$password);

//ユーザーの志望ゼミを取得
$user_zemis = [];
$user_zemis = array(
    'zemi1' => 1,
    'zemi2' => 2,
    'zemi3' => 3
);
//DBからuser_zemis[zemi1]と同じゼミを第１志望にしているユーザーを取得
$stmt = $pdo->query("SELECT classes.user_id, classes.class1, classes.class2, classes.class3, classes.class4, classes.class5 FROM classes INNER JOIN zemis ON classes.user_id = zemis.user_id WHERE zemis.zemi1 = $user_zemis[zemi1]");
$classIdsByZemi1 = $stmt->fetchAll(PDO::ASSOC);
//user_idから、好きな授業を取得
//N+1なんとかしてくれ
//$stmt = $pdo->query("SELECT * FROM classes WHERE user_id = $userIdsByZemi1")
//$classIdsByZemi1 = $stmt->fetchAll(PDO::ASSOC);

var_dump($classIdsByZemi1);
//
$sum = [];
foreach($classIdsByZemi1 as $classId){
    if(count($classId) == 0){
        continue;
    }
}
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