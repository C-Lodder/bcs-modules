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

class ModBcstracksHelper
{
	public $authors = null;

	/**
	 *  The contructor
	 */
	public function __construct($authors)
	{
		$this->authors = explode(',', $authors);
		$this->baseurl = 'https://tm.mania-exchange.com/tracksearch2/search?api=on&mode=2&authorid=';
		$this->imgurl  = 'https://tm.mania-exchange.com/tracks/thumbnail/';
	}

	/**
	 *  Get a JSON object or the tracks by the defined author ID's
	 */
	public function getAuthorTracks()
	{
		$results = [];

		$httpOptions = [
			'userAgent' => "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17\r\n"
		];
		$options = new Registry($httpOptions);
		$http    = HttpFactory::getHttp($options);

		foreach ($this->authors as $author)
		{
			$httpResult = $http->get($this->baseurl . $author);
			$json       = json_decode($httpResult->body);

			if ($json->totalItemCount === 0)
			{
				continue;
			}

			$results[] = $json;
		}

		return $this->extractData($results);
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
		$track = [];

		foreach ($results as $key => $val)
		{
			$result  = $val->results[0];
			$trackId = $result->TrackID;

			$track[$trackId]['TrackID']    = $trackId;
			$track[$trackId]['Username']   = $result->Username;
			$track[$trackId]['GbxMapName'] = $result->GbxMapName;
			$track[$trackId]['UploadedAt'] = $this->timeElapsed($result->UploadedAt);
			$track[$trackId]['screenshot'] = $this->getTrackImage($trackId);
		}

		return $this->sortArray($track);
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
	public function timeElapsed($datetime, $full = false)
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
