Welcome to YQL PHP Library
==========================

YQL PHP Library is alibrary for convenient executions of Yahoo Query Language queries.

Requirements
------------

YQL PHP Library requires PHP 5.3. 

Installation
------------

Just copy the files into your lib folder and require YQL.php;


Quick start
---------------

Static style:
    $response = YQL::query('select * from internet');
    
Object style:
    $yql = new YQL;
    $response = $yql->execute('select * from internet');

or:
    $yql = new YQL;
    $ylq->setQuery('select * from internet');
    $response = $yql->execute();

Get the count of result elements:
    $response->count or $response->getCount()

Get the result elements:
    $response->results or $response->getResults()