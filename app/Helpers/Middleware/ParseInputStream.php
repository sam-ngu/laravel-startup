<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 27-06-2018
 * Time: 9:55 AM
 */

namespace App\Helpers\Middleware;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyFile;
/**
 * stream - Handle raw input stream
 *
 * LICENSE: This source file is subject to version 3.01 of the GPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/licenses/gpl.html. If you did not receive a copy of
 * the GPL License and are unable to obtain it through the web, please
 *
 * @author jason.gerfen@gmail.com
 * @license http://www.gnu.org/licenses/gpl.html GPL License 3
 *
 * Massive modifications by TGE (dev@mycloudfulfillment.com) to support
 * proper parameter name processing and Laravel compatible UploadedFile
 * support. Class name changed to be more descriptive and less likely to
 * collide.
 *
 * Original Gist at:
 *   https://gist.github.com/jas-/5c3fdc26fedd11cb9fb5#file-class-stream-php
 *
 */
class ParseInputStream
{

    public static function convertEmptyArrayStringToArray(array $data)
    {
        return collect($data)->map(function ($value, $key){
            if($value === '[]'){
                return [];
            }
            return $value;
        })->toArray();
    }

    /**
     * @abstract Raw input stream
     */
    protected $input;
    /**
     * @function __construct
     *
     * @param array $data stream
     */
    public function __construct(array &$data)
    {
        $this->input = file_get_contents('php://input');
        $boundary = $this->boundary();
        if (!strlen($boundary)) {
            $data = [
                'parameters' => $this->parse(),
                'files' => []
            ];
        } else {
            $blocks = $this->split($boundary);
            $data = $this->blocks($blocks);
        }
        // convert to empty array string to empty array.
        return $this->convertEmptyArrayStringToArray($data);

    }
    /**
     * @function boundary
     * @returns string
     */
    private function boundary()
    {
        if(!isset($_SERVER['CONTENT_TYPE'])) {
            return null;
        }
        preg_match('/boundary=(.*)$/', $_SERVER['CONTENT_TYPE'], $matches);
        return $matches[1] ?? null;
    }
    /**
     * @function parse
     * @returns array
     */
    private function parse()
    {
        parse_str(urldecode($this->input), $result);
        return $result;
    }
    /**
     * @function split
     * @param $boundary string
     * @returns array
     */
    private function split($boundary)
    {
        $result = preg_split("/-+$boundary/", $this->input);
        array_pop($result);
        return $result;
    }
    /**
     * @function blocks
     * @param $array array
     * @returns array
     */
    private function blocks($array)
    {
        $results = [];
        foreach($array as $key => $value)
        {
            if (empty($value))
                continue;
            $block = $this->decide($value);
            foreach ( $block['parameters'] as $key => $val ) {
                $this->parse_parameter( $results, $key, $val );
            }
            foreach ( $block['files'] as $key => $val ) {
                $this->parse_parameter( $results, $key, $val );
            }
        }
        return $results;
    }
    /**
     * @function decide
     * @param $string string
     * @returns array
     */
    private function decide($string)
    {
        if (strpos($string, 'application/octet-stream') !== FALSE)
        {
            return [
                'parameters' => $this->file($string),
                'files' => []
            ];
        }
        if (strpos($string, 'filename') !== FALSE)
        {
            return [
                'parameters' => [],
                'files' => $this->file_stream($string)
            ];
        }
        return [
            'parameters' => $this->parameter($string),
            'files' => []
        ];
    }
    /**
     * @function file
     *
     * @param $string
     *
     * @return array
     */
    private function file($string)
    {
        preg_match('/name=\"([^\"]*)\".*stream[\n|\r]+([^\n\r].*)?$/s', $string, $match);
        return [
            $match[1] => ($match[2] !== NULL ? $match[2] : '')
        ];
    }
    /**
     * @function file_stream
     *
     * @param $string
     *
     * @return array
     */
    private function file_stream($data)
    {
        $result = [];
        $data = ltrim($data);
        $idx = strpos( $data, "\r\n\r\n" );
        if ( $idx === FALSE ) {
            Log::warning( "ParseInputStream.file_stream(): Could not locate header separator in data:" );
            Log::warning( $data );
        } else {
            $headers = substr( $data, 0, $idx );
            $content = substr( $data, $idx + 4, -2 ); // Skip the leading \r\n and strip the final \r\n
            $name = '-unknown-';
            $filename = '-unknown-';
            $filetype = 'application/octet-stream';
            $header = strtok( $headers, "\r\n" );
            while ( $header !== FALSE ) {
                if ( substr($header, 0, strlen("Content-Disposition: ")) == "Content-Disposition: " ) {
                    // Content-Disposition: form-data; name="attach_file[TESTING]"; filename="label2.jpg"
                    if ( preg_match('/name=\"([^\"]*)\"/', $header, $nmatch ) ) {
                        $name = $nmatch[1];
                    }
                    if ( preg_match('/filename=\"([^\"]*)\"/', $header, $nmatch ) ) {
                        $filename = $nmatch[1];
                    }
                } elseif ( substr($header, 0, strlen("Content-Type: ")) == "Content-Type: " ) {
                    // Content-Type: image/jpg
                    $filetype = trim( substr($header, strlen("Content-Type: ")) );
                } else {
                    Log::debug( "PARSEINPUTSTREAM: Skipping Header: " . $header );
                }
                $header = strtok("\r\n");
            }
            if ( substr($data, -2) === "\r\n" ) {
                $data = substr($data, 0, -2);
            }
            $path = sys_get_temp_dir() . '/php' . substr( sha1(rand()), 0, 6 );
            $bytes = file_put_contents( $path, $content );
            if ( $bytes !== FALSE ) {
                $file = UploadedFile::createFromBase(new SymfonyFile( $path, $filename, $filetype, $bytes, UPLOAD_ERR_OK ));
                $result = array( $name => $file );
            }
        }
        return $result;
    }
    /**
     * @function parameter
     *
     * @param $string
     *
     * @return array
     */
    private function parameter($string)
    {
        $data = [];
        if ( preg_match('/name=\"([^\"]*)\"[\n|\r]+([^\n\r].*)?\r$/s', $string, $match) ) {
            if (preg_match('/^(.*)\[\]$/i', $match[1], $tmp)) {
                $data[$tmp[1]][] = (data_get($match, '2') !== null && $match[2] !== NULL ? $match[2] : '');
            } else {
                $data[$match[1]] = (data_get($match, '2') !== null && $match[2] !== NULL ? $match[2] : '');
            }
        }
        return $data;
    }

    private function parse_parameter( &$params, $parameter, $value ) {
        if ( strpos($parameter, '[') !== FALSE ) {
            $matches = array();
            if ( preg_match( '/^([^[]*)\[([^]]*)\](.*)$/', $parameter, $match ) ) {
                $name = $match[1];
                $key = $match[2];
                $rem = $match[3];
                if ( $name !== '' && $name !== NULL ) {
                    if ( ! isset($params[$name]) || ! is_array($params[$name]) ) {
                        $params[$name] = array();
                    } else {
                    }
                    if ( strlen($rem) > 0 ) {
                        if ( $key === '' || $key === NULL ) {
                            $arr = array();
                            $this->parse_parameter( $arr, $rem, $value );
                            $params[$name][] = $arr;
                        } else {
                            if ( !isset($params[$name][$key]) || !is_array($params[$name][$key]) ) {
                                $params[$name][$key] = array();
                            }
                            $this->parse_parameter( $params[$name][$key], $rem, $value );
                        }
                    } else {
                        if ( $key === '' || $key === NULL ) {
                            $params[$name][] = $value;
                        } else {
                            $params[$name][$key] = $value;
                        }
                    }
                } else {
                    if ( strlen($rem) > 0 ) {
                        if ( $key === '' || $key === NULL ) {
                            // REVIEW Is this logic correct?!
                            $this->parse_parameter( $params, $rem, $value );
                        } else {
                            if ( ! isset($params[$key]) || ! is_array($params[$key]) ) {
                                $params[$key] = array();
                            }
                            $this->parse_parameter( $params[$key], $rem, $value );
                        }
                    } else {
                        if ( $key === '' || $key === NULL ) {
                            $params[] = $value;
                        } else {
                            $params[$key] = $value;
                        }
                    }
                }
            } else {
                Log::warning( "ParseInputStream.parse_parameter() Parameter name regex failed: '" . $parameter . "'" );
            }
        } else {
            $params[$parameter] = $value;
        }
    }
}
