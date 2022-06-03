<?php

if(file_exists("Models/Channel.php")) {
    include_once("Models/Channel.php");
}

if(file_exists("Models/Program.php")) {
    include_once("Models/Program.php");
}

if(file_exists("Datas/Database.php")) {
    include_once("Datas/Database.php");
}



class HomeController {
    private array $channels;
    private array $dates;
    private array $programs;

    private string $channel;
    private string $date;

    private array $error;

    /**
     * @param string $channel
     * @param string $date
     */
    public function __construct(string $channel, string $date)
    {
        $this->channels = [];
        $this->dates = [];
        $this->programs = [];
        $this->error = [];

        $this->getChannelsData();
        $this->getDatesData();


        if(in_array($channel, $this->getChannelsIds())){
            $this->channel = $channel;
        } elseif (count($this->channels) > 0){
            $this->channel = $this->channels[0]->getId();
        } else {
            $this->channel = "";
        }


        if(in_array($date, $this->dates)) {
            $this->date = $date;
        } elseif (count($this->dates) > 0){
            $this->date = $this->dates[0];
        } else {
            $this->date = "";
        }

        $this->getProgramsData($this->channel, $this->date);
    }

    /**
     * @return string
     */
    public function getChannel(): string
    {
        return $this->channel;
    }

    /**
     * @return mixed|string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return ?array
     */
    public function getPrograms(): ?array
    {
        return $this->programs;
    }


    /**
     * @return ?array
     */
    public function getDates(): ?array
    {
        return $this->dates;
    }


    /**
     * @return ?array
     */
    public function getChannels() : ?array
    {
        return $this->channels;
    }

    /**
     * $return ?Channel
     */
    public function getSelectedChannel() : ?Channel {
        if($this->channel != "") {
            foreach ($this->channels as $ch) {
                if($ch->getId() == $this->channel){
                    return $ch;
                }
            }
        }
        return null;
    }

    /**
     * @return ?array
     */
    public function getError(): ?array
    {
        return $this->error;
    }

    /**
     * @return ?array
     */
    private function getChannelsIds(): ?array {
        $ids = [];
        foreach ($this->channels as $channel) {
            $ids[] = $channel->getId();
        }
        return $ids;
    }



    public function getChannelsData() {
        try{
            $conn = Database::getConnection();
            $stmt = $conn->prepare("SELECT id, name, logo
                                            FROM channels 
                                            GROUP  BY name");
            $stmt->execute();

            foreach ($stmt->fetchAll() as $data) {
                $this->channels[] = new Channel($data["id"], $data["name"], $data["logo"]);
            }

        } catch (PDOException $e) {
            $this->error["error"][] = $e;
            $this->error["message"][] = "Adat lekérési hiba";
        } finally {
            $conn = null;
        }
    }

    public function getDatesData() {
        try{
            $conn = Database::getConnection();
            $stmt = $conn->prepare("SELECT start_date
                                            FROM programs 
                                            GROUP  BY start_date
                                            ORDER BY start_date DESC");
            $stmt->execute();

            foreach ($stmt->fetchAll() as $data) {
                $this->dates[] = $data["start_date"];
            }

        } catch (PDOException $e) {
            $this->error["error"][] = $e;
            $this->error["message"][] = "Adat lekérési hiba";
        } finally {
            $conn = null;
        }
    }

    /**
     * @param string $channel
     * @param string $date
     */
    public function getProgramsData(string $channel, string $date) {
        try{
            $conn = Database::getConnection();
            $stmt = $conn->prepare("SELECT *
                                            FROM programs
                                            WHERE start_date = :start_date AND 
                                                  channel_id = :channel_id
                                            ORDER BY start_time ASC");
            $stmt->bindValue(':start_date', $date);
            $stmt->bindValue(':channel_id', $channel);
            $stmt->execute();

            foreach ($stmt->fetchAll() as $data) {
                $this->programs[] =new Program($data["start_date"],
                                                $data["start_time"],
                                                $data["title"],
                                                $data["short_description"],
                                                $data["age_limit"],
                                                $data["channel_id"]);
            }
        } catch (PDOException $e) {
            $this->error["error"][] = $e;
            $this->error["message"][] = "Adat lekérési hiba";
        } finally {
            $conn = null;
        }
    }
}