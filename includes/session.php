<?php
    //initialize seesion
	session_start();
	//store message
	function message() {
		if (isset($_SESSION["message"])) {
			$output = "<div class=\"message\">";
			$output .= htmlentities($_SESSION["message"]);
			$output .= "</div>";

			// clear message after use
			$_SESSION["message"] = null;
			
			return $output;
		}
	}
	//store errors
	function errors() {
		if (isset($_SESSION["errors"])) {
			$errors = $_SESSION["errors"];
			
			// clear message after use
			$_SESSION["errors"] = null;
			
			return $errors;
		}
	}
	
?>