<?php
	function message() {
		if(isset($_SESSION["message"])){
			$output = "<div class=\"bg-primary message text-center\">";
			$output .= "<div class=\"container\"><p>";
			$output .= htmlentities($_SESSION["message"]);
			$output .= "</p></div>";
			$output .= "</div>";

			$_SESSION["message"] = null;
			return $output;
		}
	}
?>