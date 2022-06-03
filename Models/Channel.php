<?php

class Channel
{
    private string $id;
    private string $name;
    private string $logo;

    /**
     * @param string $id
     * @param string $name
     * @param string $logo
     */
    public function __construct(string $id, string $name, string $logo)
    {
        $this->id = $id;
        $this->name = $name;
        $this->logo = $logo;
    }


    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLogo(): string
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     */
    public function setLogo(string $logo): void
    {
        $this->logo = $logo;
    }


}