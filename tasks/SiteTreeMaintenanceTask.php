<?php
/**
 * @package cms
 * @subpackage tasks
 */
class SiteTreeMaintenanceTask extends Controller {
	static $allowed_actions = array(
		'*' => 'ADMIN'
	);
	
	public function makelinksunique() {
		$pages = SiteTree::get()->where('"SiteTree"."URLSegment" IN (SELECT URLSegment FROM SiteTree GROUP BY URLSegment HAVING count(*) > 1)');

		foreach($pages as $page) {
			echo "<li>$page->Title: ";
			$urlSegment = $page->URLSegment;
			$page->write();
			if($urlSegment != $page->URLSegment) {
				echo _t(
					'SiteTree.LINKSCHANGEDTO', 
					" changed {url1} -> {url2}", 
					array('url1' => $urlSegment, 'url2' => $page->URLSegment)
				);
			}
			else {
				echo _t(
					'SiteTree.LINKSALREADYUNIQUE', 
					" {url} is already unique",
					array('url' => $urlSegment)
				);
			}
			die();
		}
	}
}
