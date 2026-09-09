<?php

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\FileCookieJar;

class Insta {
	public $url;
	public $id;
	public $links = null;
	public $error = false;

	function __construct( $url ) {
		$this->points = ['https://www.instagram.com/p/%s/embed/captioned/'];
		$this->points[] = 'https://www.instagram.com/graphql/query/?query_hash=9f8827793ef34641b2fb195d4d41151c&variables={"shortcode":"%s"}';
		$this->url = $url;
		$this->id = $this->videoid();
	}

	public function videoid() {
		$this->url = rtrim(preg_replace('/\?.*/', '', $this->url), '/').'/';
        if(preg_match('/instagram.com\/(?:.*\/*)(?:p|tv|reel)\/(.+)\//u', $this->url, $matches)) return $matches[1];
		return null;
	}

    public function get_media() {
        $contents = $this->contents(sprintf($this->points[0], $this->id));
        preg_match_all('/"contextJSON":"(.*?)"}]]/', $contents, $matches);
        if (!isset($matches[1][0]) || empty($matches[1][0])) {
            $data = $this->getAPIResponse();
        }else{
            $verify = json_decode(json_decode('"'.$matches[1][0].'"', true), true)['gql_data'];
            if($this->mediaError($contents, $verify)) {
                $data = $this->getAPIResponse();
            }else{
                $data = $verify;
            }
        }
		if($this->error) return false;
        $video["links"] = array();
        if (!isset($data["shortcode_media"])) {
            preg_match_all('/<img class="EmbeddedMediaImage" alt=".*" src="(.*?)"/', $contents, $matches);
            if (isset($matches[1][0]) != "") {
                $video["title"] = get_string_between($contents, '<img class="EmbeddedMediaImage" alt="', '"');
                $video["source"] = "instagram";
                $video["thumbnail"] = $matches[1][0];
                $media_url = html_entity_decode($matches[1][0]);
                $size = get_file_size($media_url);
                $key = md5($media_url);
                $_SESSION[$key] = $media_url;
                array_push($video["links"], [
                    "preview" => SITE_URL.'img.php?img='.$key,
                    "url" => $media_url,
                    "type" => "jpg",
                    "size" => $size,
                    "quality" => "HD",
                    "mute" => 0
                ]);
            } else {
                return false;
            }
        } else {
            $video["title"] = $data["shortcode_media"]["edge_media_to_caption"]["edges"][0]["node"]["text"] ?? "";
            if (empty($video["title"]) && isset($data["shortcode_media"]["owner"]["username"]) != "") {
                $video["title"] = "Instagram Post from " . $data["shortcode_media"]["owner"]["username"];
            } else {
                $video["title"] = "Instagram Post";
            }
            $video["source"] = "instagram";
            $video["thumbnail"] = $data["shortcode_media"]["display_resources"][0]["src"];
            if ($data['shortcode_media']['__typename'] == "GraphImage") {
                $images_data = $data['shortcode_media']['display_resources'];
                $length = count($images_data);
                $bytes = get_file_size($images_data[$length - 1]['src']);
                $key = md5($images_data[$length - 1]['src']);
                $_SESSION[$key] = $images_data[$length - 1]['src'];
                array_push($video["links"], [
                    "preview" => SITE_URL.'img.php?img='.$key,
                    "url" => $images_data[$length - 1]['src'],
                    "type" => "jpg",
                    "bytes" => $bytes,
                    "size" => format_size($bytes),
                    "quality" => "HD",
                    "mute" => 0
                ]);
            } else {
                if ($data['shortcode_media']['__typename'] == "GraphSidecar") {
                    $multiple_data = $data['shortcode_media']['edge_sidecar_to_children']['edges'];
                    foreach ($multiple_data as $media) {
                        if ($media['node']['is_video'] == "true") {
                            $media_url = $media['node']['video_url'];
                            $type = "mp4";
                        } else {
                            $length = count($media['node']['display_resources']);
                            $media_url = $media['node']['display_resources'][$length - 1]['src'];
                            $type = "jpg";
                        }
                        $size = get_file_size($media_url);
                        $key = md5($media['node']['display_url']);
                        $_SESSION[$key] = $media['node']['display_url'];
                        array_push($video["links"], [
                            "preview" => SITE_URL.'img.php?img='.$key,
                            "url" => $media_url,
                            "type" => $type,
                            "size" => $size,
                            "quality" => "HD",
                            "mute" => 0
                        ]);
                    }
                } else {
                    if ($data['shortcode_media']['__typename'] == "GraphVideo") {
                        $size = get_file_size($data['shortcode_media']['video_url']);
                        $key = md5($data['shortcode_media']['display_url']);
                        $_SESSION[$key] = $data['shortcode_media']['display_url'];
                        array_push($video["links"], [
                            "preview" => SITE_URL.'img.php?img='.$key,
                            "url" => $data['shortcode_media']['video_url'],
                            "type" => "mp4",
                            "size" => $size,
                            "quality" => "HD",
                            "mute" => 0
                        ]);
                    }
                }
            }
        }
        return $video;
    }

    private function getAPIResponse() {
        $client = new Client();
        try {
            $proxies = file_get_contents(INSTA_PROXIES);
            $proxies = explode(PHP_EOL, $proxies);
			$proxies = array_filter($proxies);
			if(!empty($proxies))
				$proxy = $proxies[array_rand($proxies)];
			else
				$proxy = '';
            $response = $client->request('GET', sprintf($this->points[1], $this->id), ['proxy' => $proxy, 'verify' => false]);
        } catch (\Exception $e) {
			$this->error = false;
			file_put_contents(INSTA_LOG, $this->id.': '.$e->getMessage().PHP_EOL, FILE_APPEND);
          //echo $e->getMessage();
            return [];
        }

        $json = @json_decode((String)$response->getBody(), true);
        return $json['data'] ?? [];
    }
	
	function mediaError($contents, $json) {
	    $error = false;
        $needles=["WatchOnInstagram", "photo or video may be broken,"];
        $offset = 0;
		foreach($needles as $needle) {
			if(strpos($contents, $needle, $offset) !== false) {
			    $error = true;
			    break;
            }
		}
        if ($json['shortcode_media']['__typename'] == "GraphSidecar") {
            $multiple_data = $json['shortcode_media']['edge_sidecar_to_children']['edges'];
            foreach ($multiple_data as $media) {
                if ($media['node']['is_video'] == "true" && !isset($media['node']['video_url'])) {

                    $error = true;
                    break;
                }
            }
        }
		return $error;
	}

    private function contents($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders());
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
	
	private function getHeaders() {
		$headers = array();
		$headers[] = 'Authority: www.instagram.com';
		$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
		$headers[] = 'Accept-Language: en-US,en;q=0.9';
		$headers[] = 'Cache-Control: max-age=0';
		$headers[] = 'Cookie: ';
		$headers[] = 'Sec-Ch-Prefers-Color-Scheme: dark';
		$headers[] = 'Sec-Ch-Ua: "Not?A_Brand";v="8", "Chromium";v="108", "Google Chrome";v="108"';
		$headers[] = 'Sec-Ch-Ua-Mobile: ?0';
		$headers[] = 'Sec-Ch-Ua-Platform: "Windows"';
		$headers[] = 'Sec-Fetch-Dest: document';
		$headers[] = 'Sec-Fetch-Mode: navigate';
		$headers[] = 'Sec-Fetch-Site: cross-site';
		$headers[] = 'Sec-Fetch-User: ?1';
		$headers[] = 'Upgrade-Insecure-Requests: 1';
		$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36';
		return $headers;
	}

}
