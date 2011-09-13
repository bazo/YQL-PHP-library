<?php
/**
 * This file is part of the YQL PHP Library
 *
 * Copyright (c) 2011 Martin Bažík (http://bazik.biz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */
namespace YQL;
use 
    \DateTime, 
    \stdClass
;
/**
 * YQL Response
 * 
 * @author Martin Bažík
 * 
 * @property-read string $raw
 * @property-read int $count
 * @property-read DateTime $created
 * @property-read string $lang
 * @property-read stdClass $results
 */
class Response
{
    private 
	$raw,
	$count,
	$created,
	$lang,
	$results
    ;
    
    /**
     * @param string $raw
     * @param int $count
     * @param string $created
     * @param string $lang
     * @param stdClass $results 
     */
    public function __construct($raw, $count, $created, $lang, $results) 
    {
	$this->raw = $raw;
	$this->count = $count;
	$this->created = new DateTime($created);
	$this->lang = $lang;
	if($results === null) $results = array();
	$this->results = $results;
    }
    
    public function __get($name) 
    {
	if(isset($this->$name))
	    return $this->$name;
	else throw new Exception(sprintf('Undefined variable %s', $name));
    }
    
    /**
     * Returns the raw json response as string
     * @return string
     */
    public function getRaw()
    {
	return $this->raw;
    }
    
    /**
     * Returns the count of results
     * @return int
     */
    public function getCount()
    {
	return $this->count;
    }
    
    /**
     * Returns a DateTime object with the time when the response was generated
     * @return DateTime
     */
    public function getCreated()
    {
	return new $this->created;
    }
    
    /**
     * Returns locale of the returned results
     * @return string
     */
    public function getLang()
    {
	return $this->lang;
    }
    
    /**
     * Returns the results of the YQL query
     * @return stdClass
     */
    public function getResults()
    {
	return $this->results;
    }
}