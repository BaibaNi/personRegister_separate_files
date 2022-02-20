<style><?php
require_once 'vendor/autoload.php';

include 'registryStyle.css';
include "app/Database.class.php";
include "app/Person.class.php";
include "app/Registry.class.php";

$errorMessage = '';
$registry = new Registry();

if(isset($_POST['submit'])) {

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $code = $_POST['code'];

    $person = new Person($name, $surname, $code);

    try {
        $errorMessage = $registry->registerPerson($person);
    } catch (\Doctrine\DBAL\Exception $e) {
        $errorMessage = $e->getMessage();
    }
}

?></style>


<!doctype html>
<html lang="en">
<head>
    <title>PERSON REGISTER</title>
</head>


<body>
<h1><b>PERSON REGISTER</b></h1>

<div class='alert'><?php echo $errorMessage; ?></div>

<section class="getdata">
    <form method="post">
        <label> Name: <input type="text" name="name" placeholder="Name"></label>
        <label> Surname: <input type="text" name="surname" placeholder="Surname"></label>
        <label> ID code: <input type="text" name="code" placeholder="ID code"></label>
        <button type="submit" name="submit">Register</button>
    </form>
</section>

<section>
    <table>
        <tr style="background-color: lightcoral">
            <th>Nr.</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Personal ID code</th>
            <th>DataBase ID</th>
        </tr>
        <?php
        $i=1;
        try {
            foreach ($registry->getDatabaseRecords() as $id => $data): ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $data['name']; ?></td>
                    <td><?php echo $data['surname']; ?></td>
                    <td><?php echo $data['code']; ?></td>
                    <td><?php echo $id; ?></td>
                </tr>
                <?php $i++;
            endforeach;
        } catch (\Doctrine\DBAL\Exception $e) {
            echo 'ERROR! ' . $e->getMessage();
        } ?>
    </table>
</section>

</body>
</html>