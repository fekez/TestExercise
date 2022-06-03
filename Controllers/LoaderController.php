<?php

if(file_exists("Datas/Database.php")) {
    include_once("Datas/Database.php");
}


class LoaderController {
    private string $baseURL = 'https://port.hu/tvapi';

    public function loader($requestDate) {

        //get all channel
        $channelsResponse = json_decode(file_get_contents($this->baseURL.'/init'));
        $fiveChannel = [];

        //select the default 5 channel
        foreach ($channelsResponse->channels as $channel) {
            if($channel->channelPrio < 6 && $channel->channelGroups[0]->id == 1) {
                $fiveChannel[] = $channel;
            }
        }

        //post channels to database
        if(count($fiveChannel) > 0) {
            foreach ($fiveChannel as $channel) {

                $result = 1;
                //check table to don't write twice
                try{
                    $conn = Database::getConnection();
                    $stmt = $conn->prepare("SELECT COUNT(*) 
                                            FROM channels 
                                            WHERE id = :id 
                                            GROUP BY id");
                    $stmt->bindValue(':id', $channel->id);
                    $stmt->execute();

                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $result = $stmt->fetch();

                } catch (PDOException $e) {

                } finally {
                    $conn = null;
                }

                if($result == 0) {
                    try{
                        $conn = Database::getConnection();
                        $stmt = $conn->prepare("INSERT INTO channels (id, name, logo) 
                                                VALUES (:id, :name, :logo)");
                        $stmt->bindValue(':id', $channel->id);
                        $stmt->bindValue(':name', $channel->name);
                        $stmt->bindValue(':logo', $channel->logo);
                        $stmt->execute();
                    } catch (PDOException $e) {

                    } finally {
                        $conn = null;
                    }
                }
            }
        }

        //get the programs from channels
        foreach ($fiveChannel as $channel) {

            $programsResponse = json_decode(file_get_contents($this->baseURL . '?channel_id[0]=' . $channel->id . '&date=' . $requestDate));

            foreach ($programsResponse->channels[0]->programs as $program) {

                $strArray = explode("T", $program->start_datetime);
                $start_date = $strArray[0];
                $strArray = explode("+", $strArray[1]);
                $start_time = $strArray[0];

                $result = 1;
                //check table to don't write twice
                try{
                    $conn = Database::getConnection();
                    $stmt = $conn->prepare("SELECT COUNT(*) 
                                            FROM programs
                                            WHERE start_date = :start_date AND 
                                                start_time = :start_time AND 
                                                title = :title AND 
                                                short_description = :short_description AND 
                                                age_limit = :age_limit AND 
                                                channel_id = :channel_id 
                                            GROUP BY id");
                    $stmt->bindValue(':start_date', $start_date);
                    $stmt->bindValue(':start_time', $start_time);
                    $stmt->bindValue(':title', $program->title);
                    $stmt->bindValue(':short_description', $program->short_description);
                    $stmt->bindValue(':age_limit', $program->restriction->age_limit);
                    $stmt->bindValue(':channel_id', $channel->id);
                    $stmt->execute();

                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $result = $stmt->fetch();

                } catch (PDOException $e) {

                } finally {
                    $conn = null;
                }


                if($result == 0) {
                    try {
                        $conn = Database::getConnection();
                        $stmt = $conn->prepare("INSERT INTO programs (start_date, start_time, title, short_description, age_limit, channel_id) 
                                                VALUES (:start_date, :start_time, :title, :short_description, :age_limit, :channel_id)");
                        $stmt->bindValue(':start_date', $start_date);
                        $stmt->bindValue(':start_time', $start_time);
                        $stmt->bindValue(':title', $program->title);
                        $stmt->bindValue(':short_description', $program->short_description);
                        $stmt->bindValue(':age_limit', $program->restriction->age_limit);
                        $stmt->bindValue(':channel_id', $channel->id);
                        $stmt->execute();
                    } catch (PDOException $e) {

                    } finally {
                        $conn = null;
                    }
                }
            }
        }
    }
}


?>