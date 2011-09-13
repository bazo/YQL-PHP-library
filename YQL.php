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

if(!class_exists('YQL\Response')) include('Response.php');
if(!class_exists('YQL\Exception')) include('Exception.php');

/**
 * YQL class for convenient work with Yahoo Query Language
 * @author Martin Bažík
 * 
 * @property-read string $query
 */
class YQL 
{
    public static
	/** @var string */
	$defaultTablesDefinitionUrl = 'http://datatables.org/alltables.env'
    ;
    
    private
	$yqlUrl = 'http://query.yahooapis.com/v1/public/yql?q=',
	$query,
	$tablesDefinitionUrl
    ;
    
    /**
     * @param string $tablesDefinitionUrl Url of the tables definitions file 
     */
    public function __construct($tablesDefinitionUrl = null) 
    {
	if($tablesDefinitionUrl == null) $tablesDefinitionUrl = self::$defaultTablesDefinitionUrl;
	$this->tablesDefinitionUrl = $tablesDefinitionUrl;
    }
    
    /**
     * Gets the query to use
     * @return string 
     */
    public function getQuery() 
    {
	return $this->query;
    }

    /**
     * Sets the query to use
     * @param string $query
     * @return YQL 
     */
    public function setQuery($query) 
    {
	$this->query = $query;
	return $this;
    }

    private function prepareRequest($query)
    {
	return $this->yqlUrl
		.urlencode($query)
		."&format=json"
		.'&env='
		.urlencode($this->tablesDefinitionUrl);
	    ;
    }
    
    private function executeRequest($request)
    {
	$session = curl_init($request);  
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);      
	return curl_exec($session);
    }
    
    private function parseResponse($data)
    {
	$jsonObj = json_decode($data);
	if(isset($jsonObj->error))
	    throw new Exception($jsonObj->error->description);
	$response = new Response($data, $jsonObj->query->count, 
		$jsonObj->query->created, $jsonObj->query->lang, $jsonObj->query->results);
	return $response;
    }
    
    /**
     * Executes the YQL query
     * @param string $query
     * @throws Exception
     * @return Response 
     */
    public function execute($query = null)
    {
	if($query == null) 
	    $query = $this->query;
	if($query == null) 
	    throw new Exception('No query set');
	$request = $this->prepareRequest($query);
	$response = $this->executeRequest($request);
	return $this->parseResponse($response);
    }
    
    public static function query($query)
    {
	$yql = new static();
	return $yql->execute($query);
    }
}