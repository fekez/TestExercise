<?php

class Program {
    private string $startDate;
    private string $startTime;
    private string $title;
    private string $shortDescription;
    private int $ageLimit;
    private string $channelId;

    /**
     * @param string $startDate
     * @param string $startTime
     * @param string $title
     * @param string $shortDescription
     * @param int $ageLimit
     * @param string $channelId
     */
    public function __construct(string $startDate, string $startTime, string $title, string $shortDescription, int $ageLimit, string $channelId)
    {
        $this->startDate = $startDate;
        $this->startTime = $startTime;
        $this->title = $title;
        $this->shortDescription = $shortDescription;
        $this->ageLimit = $ageLimit;
        $this->channelId = $channelId;
    }

    /**
     * @return string
     */
    public function getStartDate(): string
    {
        return $this->startDate;
    }

    /**
     * @param string $startDate
     */
    public function setStartDate(string $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return string
     */
    public function getStartTime(): string
    {
        return $this->startTime;
    }

    /**
     * @param string $startTime
     */
    public function setStartTime(string $startTime): void
    {
        $this->startTime = $startTime;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     */
    public function setShortDescription(string $shortDescription): void
    {
        $this->shortDescription = $shortDescription;
    }

    /**
     * @return int
     */
    public function getAgeLimit(): int
    {
        return $this->ageLimit;
    }

    /**
     * @param int $ageLimit
     */
    public function setAgeLimit(int $ageLimit): void
    {
        $this->ageLimit = $ageLimit;
    }

    /**
     * @return string
     */
    public function getChannelId(): string
    {
        return $this->channelId;
    }

    /**
     * @param string $channelId
     */
    public function setChannelId(string $channelId): void
    {
        $this->channelId = $channelId;
    }


}