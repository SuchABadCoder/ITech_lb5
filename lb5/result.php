<!DOCKTYPE HTML>
<html>
<head>
    <title>Лаба 5</title>
    <meta charset="utf-8">
</head>
<body>
<?php 
    $dsn = "mysql:host = localhost;dbname=lab5_itech";
    $user = "root";
    $psw = "";
    //print_r($_GET);
    try{
        $dbh = new PDO($dsn, $user, $psw, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        $expr = $dbh->prepare("SELECT COUNT(a.ID_Worker) FROM worker a JOIN department b 
        ON a.FID_Department=b.ID_Department WHERE b.chief=:chief_name");
        $expr->execute(['chief_name'=>$_GET["chief"]]);
        $workers_number = $expr->fetch();

        $expr = $dbh->prepare("SELECT ROUND(TIME_TO_SEC(timediff(a.time_end, a.time_start))/3600) AS diff 
        FROM work a JOIN projects b ON a.FID_Projects=b.ID_Projects WHERE b.name=:project_name");
        $expr->execute(['project_name'=>$_GET["project_name"]]);
        $res = $expr->fetchAll();

        $total_time = 0;
        foreach ($res as $num)
            $total_time+=$num[0];

        $expr = $dbh->prepare("SELECT a.* FROM work a JOIN projects b ON a.FID_Projects=b.ID_Projects 
        WHERE b.name=:project_name AND a.date<=:work_date");
        $expr->execute(['project_name'=>$_GET["project_name2"], 'work_date'=>$_GET["date"]]);
        $res = $expr->fetchAll();

        echo "Информация о выполненных задачах по проекту ".$_GET["project_name2"]. " на дату ".$_GET["date"].":";
        echo "<p><table border='1'>
            <tr>
                <th>FID_Worker</th>
                <th>FID_Projects</th>
                <th>date</th>
                <th>time_start</th>
                <th>time_end</th>
                <th>description</th>
            </tr>";
        foreach ($res as $row){
            echo "<tr>";
            echo "<td>".$row[0]."</td>";
            echo "<td>".$row[1]."</td>";
            echo "<td>".$row[2]."</td>";
            echo "<td>".$row[3]."</td>";
            echo "<td>".$row[4]."</td>";
            echo "<td>".$row[5]."</td>";
            echo "</tr>";
        }
        echo "</table></p>";

    }
    catch(PDOException $ex){
        echo $ex->GetMessage();
    }
    $dbh = null;
?>
    <p>Число сотрудников отдела руководителя <?=$_GET["chief"]?>: <?=$workers_number['COUNT(a.ID_Worker)']?></p>
    <p>Oбщее время работы над проектом <?=$_GET["project_name"]?>: <?=$total_time?> ч.</p>
</body> 