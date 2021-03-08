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

        try{
            $dbh = new PDO($dsn, $user, $psw, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

            $expr = $dbh->prepare("SELECT chief FROM department");
            $expr->execute();
            $chief_options = $expr->fetchAll();

            $expr = $dbh->prepare("SELECT projects.name FROM projects");
            $expr->execute();
            $project_options = $expr->fetchAll();            
        }
        catch(PDOException $ex){
            echo $ex->GetMessage();
        }
        $dbh = null;
    ?>
    <form action="result.php" method="get">
        <p>Число сотрудников отдела выбранного руководителя:</p>
        <select name="chief">
            <?php foreach ($chief_options as $name): ?>
                <option value="<?=$name["chief"]?>"><?=$name["chief"]?></option>
            <?php endforeach ?>
        </select>

        <p>Oбщее время работы над выбранным проектом:</p>
        <select name="project_name">
            <?php foreach ($project_options as $project): ?>
                <option value="<?=$project["name"]?>"><?=$project["name"]?></option>
            <?php endforeach ?>
        </select>

        <p>Информация о выполненных задачах по выбранному проекту на указанную дату:</p>
        <select name="project_name2">
            <?php foreach ($project_options as $project): ?>
                <option value="<?=$project["name"]?>"><?=$project["name"]?></option>
            <?php endforeach ?>
        </select>
        <p><input type="date" name="date"></p>

        <button type="submit">Поиск</button><br>
    </form>
</body> 