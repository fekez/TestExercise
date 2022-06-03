<?php
    if(file_exists("Controllers/HomeController.php")) {
        include_once("Controllers/HomeController.php");
    }

    $channelFromGet = "";
    $dateFromGet = "";

    if(count($_GET) > 0 &&
        array_key_exists("channels", $_GET) &&
        array_key_exists("dates", $_GET)) {
            $channelFromGet = $_GET["channels"];
            $dateFromGet = $_GET["dates"];
    }

    $homeController = new HomeController($channelFromGet, $dateFromGet);
?>

<div class="d-flex justify-content-center flex-column flex-fill">
    <?php
    $error = $homeController->getError();
    if($error != null && count($error) > 0) {
        ?><div class="flex-row flex-fill justify-content-center" style="margin-bottom: 20px;">
        <h3><?php foreach ($error["message"] as $message) { echo $message; ?><br><?php }?></h3>
        </div><?php
    }
    ?>
    <div class="flex-row flex-fill justify-content-center" style="margin-bottom: 20px;">
        <form action="">
            <div class="mb-3 mt-3">
                <label for="channels" class="form-label">Csatornák:</label>
                <select class="form-select" aria-label="Default select example" name="channels">
                    <?php
                    foreach ($homeController->getChannels() as $channel) {
                        ?><option <?= $channel->getId() == $homeController->getSelectedChannel()->getId() ? 'Selected' : ''?> value="<?=$channel->getId()?>"><?=$channel->getName()?></option><?php
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3 mt-3">
                <label for="dates" class="form-label">Választható időpontok:</label>
                <select class="form-select" aria-label="Default select example" name="dates">
                    <?php
                    foreach ($homeController->getDates() as $date) {
                        ?><option <?= $date == $homeController->getDate() ? 'Selected' : ''?> value="<?=$date?>"><?=$date?></option><?php
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Műsorok lekérése</button>
        </form>
    </div>

    <table class="table table-striped table-hover">
        <tr>
            <img src="<?=$homeController->getSelectedChannel()->getLogo()?>" style="max-width: 10%; " class="img-fluid" alt="<?=$homeController->getSelectedChannel()->getName()?>">
        </tr>
        <thead>
        <tr>
            <th scope="col">Kezdési idő</th>
            <th scope="col">Cím</th>
            <th scope="col">Rövid leírás</th>
            <th scope="col">Korhatár</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if($homeController->getPrograms() != null) {
            foreach ($homeController->getPrograms() as $program) {
                $str = explode(":", $program->getStartTime());
                ?><tr>
                <th scope=""row><?=$str[0].":".$str[1]?></th>
                <td ><?=$program->getTitle()?></td>
                <td ><?=$program->getShortDescription()?></td>
                <td ><?=$program->getAgeLimit()?></td>
                </tr><?php
            }
        }
        ?>
        </tbody>
    </table>

</div>
