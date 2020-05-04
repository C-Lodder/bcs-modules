<?php
/**
 * @package    BCS_Latest_Tracks
 * @author     Lodder
 * @copyright  Copyright (C) 2020 Lodder. All Rights Reserved
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
	private static $baseurl = 'https://tm.mania-exchange.com/tracksearch2/search?api=on&mode=2&limit=20&priord=2&authorid=';

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
		$authors = Factory::getApplication()->input->json->get('authors');

		$results = [];
		$options = new Registry;
		$options->set('userAgent', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0');
		$http = HttpFactory::getHttp($options);
		
		foreach ($authors as $author)
		{
			try
			{
				$result = $http->get(self::$baseurl . $author);
			}
			catch (RuntimeException $e)
			{
				throw new \RuntimeException('Unable to fetch API data.', $e->getCode(), $e);
			}

			$json = json_decode($result->body);

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
	 * Detect if it contains any magnetic blocks
	 *
	 * @param   string  $id  The ID of the track
	 *
	 * @return  bool
	 */
	private function checkMagnets($id)
	{
		$options = new Registry;
		$options->set('userAgent', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0');

		try
		{
			$result = HttpFactory::getHttp($options)->get($this->objects . $id);
		}
		catch (RuntimeException $e)
		{
			throw new \RuntimeException('Unable to fetch API data.', $e->getCode(), $e);
		}

		if (strpos($result->body, 'Magnet') !== false)
		{
			return true;
		}

		return false;
	}

	/**
	 * Get the thumbnail extracted from the track
	 *
	 * @param   string  $id  The ID of the track
	 *
	 * @return  string  The URL of the track image
	 */
	private function getTrackImage($id)
	{
		$url = $this->imgurl . $id;

		return $url;
	}

	/**
	 * Extract the data we need from the object
	 *
	 * @param   array  $results  The results from the request
	 *
	 * @return  array  The filtered results
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
			$time    = $result->UploadedAt;

			$tracks[$time]['TrackID']    = $trackId;
			$tracks[$time]['Username']   = $cp->toHTML($result->Username);
			$tracks[$time]['GbxMapName'] = $cp->toHTML($result->GbxMapName);
			$tracks[$time]['UploadedAt'] = $this->timeElapsed($time);
			$tracks[$time]['screenshot'] = $this->getTrackImage($trackId);
			$tracks[$time]['magnets']    = $this->checkMagnets($trackId);
		}

		return $this->sortArray($tracks);
	}

	/**
	 * Sory the array by key
	 *
	 * @param   array  $array  The array to be sorted
	 *
	 * @return  array  The sorted array
	 */
	private function sortArray($array)
	{
		ksort($array);

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
