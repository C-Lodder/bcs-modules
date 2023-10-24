<?php
/**
 * @package    BCS_Latest_Tracks
 * @author     Lodder
 * @copyright  Copyright (C) 2022 Lodder. All Rights Reserved
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
	private static $endpoints = [
		'https://tm.mania-exchange.com',
		'https://trackmania.exchange',
	];

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
		
		foreach (self::$endpoints as $endpoint)
		{
			foreach ($authors as $author)
			{
				try
				{
					$result = $http->get($endpoint . '/tracksearch2/search?api=on&mode=2&limit=20&priord=2&authorid=' . $author);
				}
				catch (RuntimeException $e)
				{
					throw new \RuntimeException('Unable to fetch API data.', $e->getCode(), $e);
				}

				$json = json_decode($result->body);
				$game = 'tm2';

				if ($endpoint === self::$endpoints[1])
				{
					$game = 'tm2020';
				}

				$json->Game = $game;

				if ($json->totalItemCount === 0)
				{
					continue;
				}

				$results[] = $json;
			}
		}

		return $helper->extractData($results);
	}

	/**
	 * Detect if it contains any magnetic blocks
	 *
	 * @param   string  $id        The ID of the track
	 * @param   string  $endpoint  The API endpoint
	 *
	 * @return  bool
	 */
	private function checkMagnets($id, $endpoint)
	{
		$options = new Registry;
		$options->set('userAgent', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0');

		try
		{
			$result = HttpFactory::getHttp($options)->get($endpoint . '/api/maps/embeddedobjects/' . $id);
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
	 * @param   string  $id        The ID of the track
	 * @param   string  $endpoint  The API endpoint
	 *
	 * @return  string  The URL of the track image
	 */
	private function getTrackImage($id, $endpoint)
	{
		return $endpoint . '/tracks/thumbnail/' . $id;
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
			$result   = $val->results[0];
			$trackId  = $result->TrackID;
			$time     = $result->UploadedAt;
			$endpoint = $val->Game === 'tm2020' ? self::$endpoints[1] : self::$endpoints[0];

			$tracks[$time]['endpoint']   = $endpoint;
			$tracks[$time]['TrackID']    = $trackId;
			$tracks[$time]['Game']       = $val->Game;
			$tracks[$time]['Username']   = $cp->toHTML($result->Username);
			$tracks[$time]['GbxMapName'] = $cp->toHTML($result->GbxMapName);
			$tracks[$time]['UploadedAt'] = $this->timeElapsed($time);
			$tracks[$time]['screenshot'] = $this->getTrackImage($trackId, $endpoint);
			//$tracks[$time]['magnets']    = $this->checkMagnets($trackId, $endpoint);
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
	 * @param   string   $datetime  The date to be converted
	 * @param   boolean  $full      Show the full elapsed time
	 *
	 * @return  string   The elapsed time
	 */
	private function timeElapsed($datetime, $full = false)
	{
		$now  = Factory::getDate();
		$ago  = Factory::getDate($datetime);
		$diff = (array) $now->diff($ago);

		$diff['w'] = floor($diff['d'] / 7);
		$diff['d'] -= $diff['w'] * 7;

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
			if ($diff[$k])
			{
				$v = $diff[$k] . ' ' . $v . ($diff[$k] > 1 ? 's' : '');
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
