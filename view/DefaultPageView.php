<?php

namespace view;

class DefaultPageView {
	
	/**
	 * @param string $title
	 * @param string $authBody
	 * @return string of HTML
	 */
	public function getPage($title, $loginBody, $mainBody) {
		
		if(strlen($mainBody) < 5) //TODO: might not be the best way
			$mainBody = "You are currently offline. Please log in to use this application!";
		
		return "
		<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'> 
		<html xmlns='http://www.w3.org/1999/xhtml'> 
		  <head> 
		     <title>" . $title . "</title> 
		     <meta http-equiv='content-type' content='text/html; charset=utf-8' />
		     <link rel='stylesheet' type='text/css' media='all' href='css/Style.css' />
		  </head> 
		  <body>
		    <div id='loginContainer'>
		    	". $loginBody ."
		    </div>
		    <div id='mainContainer'>
		    	". $mainBody ."
		    </div>
		  </body>
		</html>
		";
	}
	
	/**
	 * return string of HTML
	 */
	public function getOfflineHTML() {
		return "You are currently offline. Please log in to use this application!";
	}
	
	/**
	 * @return String $location
	 * TODO: Finish this, right now we are att start oage all the time
	 */
	public function getPageLocation() {
		$location = "start";
		
		return $location;
	}

}