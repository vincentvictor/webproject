<?php

namespace App;

class Funel
{
    private $project_name;
    private $configuration;
    private $attribute;
    private $hash;
    private $timestamp;
    private $job_id;

     /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($project_name, $configuration, $attribute, $hash, $timestamp)
    {
    	$this->project_name = $project_name;
    	$this->configuration = $configuration;
        $this->attribute = $attribute;
        $this->hash = $hash;
        $this->timestamp = $timestamp;
        $this->job_id = 0;
    }

    public function getProjectName()
    {
        return $this->project_name;
    }

    public function getConfiguration()
    {
        return $this->configuration;
    }

    public function getAttribute()
    {
        return $this->attribute;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function getJobId()
    {
        return $this->job_id;
    }
    
}
