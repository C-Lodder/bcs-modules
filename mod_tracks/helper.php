<?php
/**
 * @package    BCS_Latest_Tracks
 * @author     Lodder
 * @copyright  Copyright (C) 2018 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Http\HttpFactory;
use Joomla\Registry\Registry;
use Joomla\CMS\Helper\ModuleHelper;

\JLoader::register('TMFColorParser', JPATH_BASE . '/tmfcolorparser.php');

class ModTracksHelper
{
	private static $baseurl = 'https://tm.mania-exchange.com/tracksearch2/search?api=on&mode=2&limit=20&authorid=';

	/**
	 *  The contructor
	 */
	public function __construct()
	{
		$this->imgurl  = 'https://tm.mania-exchange.com/tracks/thumbnail/';
		$this->objects = 'https://api.mania-exchange.com/tm/tracks/embeddedobjects/';
	}

	/**
	 *  Get a JSON object or the tracks by the defined author ID's
	 */
	public static function getAuthorTracksAjax()
	{
		$helper  = new ModTracksHelper;
		$authors = explode(',', $helper->getParams()->get('authors'));

		$results = [];
		$httpOptions = [
			'userAgent' => "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17\r\n"
		];
		$options = new Registry($httpOptions);
		$http    = HttpFactory::getHttp($options);

		foreach ($authors as $author)
		{
			$httpResult = $http->get(self::$baseurl . $author);
			$json       = json_decode($httpResult->body);

			if ($json->totalItemCount === 0)
			{
				continue;
			}

			$results[] = $json;
		}

		return $helper->extractData($results);
	}

	private function getParams()
	{
		$module = ModuleHelper::getModule('mod_tracks');
		$moduleParams = new Registry;

		// When using the preview feature when no module params have been saved we get an
		// empty string back from ModuleHelper::getModule for the params which is obviously
		// not valid json and as a result Registry blows up.
		if ($module->params !== '')
		{
			$moduleParams->loadString($module->params);
		}

		return $moduleParams;
	}
	
	/**
	 *  Get the track objects and detect if it contains any magnetic blocks
	 */
	private function checkMagnets($id)
	{
		$httpOptions = [
			'userAgent' => "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17\r\n"
		];
		$options    = new Registry($httpOptions);
		$http       = HttpFactory::getHttp($options);
		$httpResult = $http->get($this->objects . $id);

		if (strpos($httpResult->body, 'Magnet') !== false)
		{
			return true;
		}

		return false;
	}

	/**
	 *  Get the thumbnail extracted from the track
	 */
	private function getTrackImage($id)
	{
		$url = $this->imgurl . $id;

		return $url;
	}

	/**
	 *  Extract the data we need from the object
	 */
	private function extractData($results)
	{
		$cp = new TMFColorParser();
		$cp->replaceHex('#ffffff', '#aaaaaa');

		$tracks = [];

		foreach ($results as $key => $val)
		{
			$result  = $val->results[0];
			$trackId = $result->TrackID;

			$tracks[$trackId]['TrackID']    = $trackId;
			$tracks[$trackId]['Username']   = $cp->toHTML($result->Username);
			$tracks[$trackId]['GbxMapName'] = $cp->toHTML($result->GbxMapName);
			$tracks[$trackId]['UploadedAt'] = $this->timeElapsed($result->UploadedAt);
			$tracks[$trackId]['screenshot'] = $this->getTrackImage($trackId);
			$tracks[$trackId]['magnets']    = $this->checkMagnets($trackId);
		}

		return $this->sortArray($tracks);
	}

	/**
	 *  Sory the array by key in reverse order
	 */
	private function sortArray($array)
	{
		krsort($array);

		return $array;
	}

	/**
	 * Converts the date to an elapsed time, e.g "1 day ago"
	 *
	 * @param     string   $datetime  The date to be converted
	 * @param     boolean  $full      Show the full elapsed time
	 *
	 * @return    string   The elapsed time
	 */
	private function timeElapsed($datetime, $full = false)
	{
		$now  = Factory::getDate();
		$ago  = Factory::getDate($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = [
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
		];

		foreach ($string as $k => &$v)
		{
			if ($diff->$k)
			{
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			}
			else
			{
				unset($string[$k]);
			}
		}

		if (!$full)
		{
			$string = array_slice($string, 0, 1);
		}

		return $string ? implode(', ', $string) . ' ago' : 'just now';
	}
}
