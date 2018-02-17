<?php

	require_once 'config.php';
	require_once 'database.php';

	/*
		Put an error message on session 
	*/
	function setError($errorMessage)
	{
		if (!isset($_SESSION['diamond_error'])) {
			$_SESSION['diamond_error'] = array();
		}
		
		$_SESSION['diamond'][] = $errorMessage;

	}

	/*
	print the error message
	*/
	function displayError()
	{
		if (isset($_SESSION['diamond_error']) && count($_SESSION['diamond_error'])) {
			$numError = count($_SESSION['diamond_error']);
			
			echo '<table id="errorMessage" width="550" align="center" cellpadding="20" cellspacing="0"><tr><td>';
			for ($i = 0; $i < $numError; $i++) {
				echo '&#8226; ' . $_SESSION['diamond_error'][$i] . "<br>\r\n";
			}
			echo '</td></tr></table>';
			
			// remove all error messages from session
			$_SESSION['diamond_error'] = array();
		}
	}

	/**************************
		Paging Functions
	***************************/
	function getPagingQuery($sql, $itemPerPage = 10)
	{
		if (isset($_GET['page']) && (int)$_GET['page'] > 0) {
			$page = (int)$_GET['page'];
		} else {
			$page = 1;
		}
		// start fetching from this row number
		$offset = ($page - 1) * $itemPerPage;
		return $sql . " LIMIT $offset, $itemPerPage";
	}
	function getPagingLink($dbConn, $sql, $itemPerPage = 10, $strGet = ''){
		$result        = dbQuery($dbConn, $sql);
		$pagingLink    = '';
		$totalResults  = dbNumRows($result);
		$totalPages    = ceil($totalResults / $itemPerPage);
		// how many link pages to show
		$numLinks      = 5;		
		// create the paging links only if we have more than one page of results
		if ($totalPages > 1) {
			$self = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ;
			if (isset($_GET['page']) && (int)$_GET['page'] > 0) {
				$pageNumber = (int)$_GET['page'];
			} else {
				$pageNumber = 1;
			}
			// print 'previous' link only if we're not
			// on page one
			if ($pageNumber > 1) {
				$page = $pageNumber - 1;
				if ($page > 1) {
					$prev = "<a href=\"$self?page=$page&$strGet\" class=\"page\">Previous</a>";
				} else {
					$prev = "<a href=\"$self?$strGet\" class=\"page\">Previous</a>";
				}
				$first = " <a href=\"$self?$strGet\" class=\"page\">First</a> ";
			} else {
				$prev  = ''; // we're on page one, don't show 'previous' link
				$first = ''; // nor 'first page' link
			}
			// print 'next' link only if we're not
			// on the last page
			if ($pageNumber < $totalPages) {
				$page = $pageNumber + 1;
				$next = "<a href=\"$self?page=$page&$strGet\" class=\"page\">Next</a> ";
				$last = " <a href=\"$self?page=$totalPages&$strGet\" class=\"page\">Last</a> ";
			} else {
				$next = ''; // we're on the last page, don't show 'next' link
				$last = ''; // nor 'last page' link
				// $last = " <a href=\"$self?page=$totalPages&$strGet\" class=\"page\">Last</a> ";
			}
			$start = $pageNumber - ($pageNumber % $numLinks) + 1;
			$end   = $start + $numLinks - 1;		
			$end   = min($totalPages, $end);
			$pagingLink = array();
			for($page = $start; $page <= $end; $page++)	{
				if ($page == $pageNumber) {
					$pagingLink[] = "<b><span  class=\"page active\">$page</span></b>";   // no need to create a link to current page
				} else {
					if ($page == 1) {
						$pagingLink[] = "<a href=\"$self?$strGet\" class=\"page\">$page</a>";
					} else {	
						$pagingLink[] = "<a href=\"$self?page=$page&$strGet\" class=\"page\">$page</a>";
					}
				}
			}
			$pagingLink = implode('', $pagingLink);
			// return the page navigation link
			//$pagingLink = $first . $prev . $pagingLink . $next . $last;
			//$pagingLink =  "<div style='width:50%; magin: 0 auto;'>"  . $prev . "<div id='paging'><ul>" . $pagingLink . "</ul></div>" .  $next .  "</div>";
			$pagingLink =  "<div class='pagination'>" .$first . $prev .  $pagingLink  .  $next . $last .  "</div>";
		}
		return $pagingLink;
	}

?>