<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Funel extends Model 
{

    protected $table = 'funel';
    private $project_name;
    private $configuration;
    private $attribute;
    private $hash;
    private $timestamp;
    private $job_id;

    public function __construct($project_name, $configuration, $attribute, $hash, $timestamp)
    {
        $this->project_name = $project_name;
    	  $this->configuration = $configuration;
        $this->attribute = $attribute;
        $this->hash = $hash;
        $this->timestamp = $timestamp;
    }

    /**
     * Save a funel record in database
     *
     * @return void
     */
    public function store()
    {
        $data = array('project_name' => $this->project_name, 
                      'configuration' => $this->configuration,
                      'attribute' => $this->attribute,
                      'job_id' => $this->job_id,
                      'hash' => $this->hash,
                      'time' => $this->timestamp
        );
        DB::table($this->table)->insert($data);
    }

    public function updateData($hash, $field, $data)
    {
        DB::table($this->table)->where('hash', $this->hash)->update([$field => $data]);
    }

    public function getProjectName()
    {
        return $this->project_name;
    }

    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * Get the number of attributes of a record
     * Function name is defined with 's' because Model class already has getAttribute($key)
     *
     * @return string
     */
    public function getAttributes()
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

    public function getTable()
    {
        return $this->table;
    }

}
