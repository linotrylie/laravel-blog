<?php
/**
 * Created by PhpStorm.
 * User: edz
 * Date: 2020/3/25
 * Time: 14:27
 */

namespace App\Tool;
use App\Tool\HyperDown;

class MarkdownTypecho
{
    /**
     * convert
     *
     * @param string $text
     * @return string
     */
    public static function convert($text)
    {
        static $parser;

        if (empty($parser)) {
            $parser = new HyperDown();

            $parser->hook('afterParseCode', function ($html) {
                return preg_replace("/<code class=\"([_a-z0-9-]+)\">/i", "<code class=\"lang-\\1\">", $html);
            });

            $parser->hook('beforeParseInline', function ($html) use ($parser) {
                return preg_replace_callback("/^\s*<!\-\-\s*more\s*\-\->\s*$/s", function ($matches) use ($parser) {
                    return $parser->makeHolder('<!--more-->');
                }, $html);
            });

            $parser->enableHtml(true);
            $parser->_commonWhiteList .= '|img|cite|embed|iframe';
            $parser->_specialWhiteList = array_merge($parser->_specialWhiteList, array(
                'ol'            =>  'ol|li',
                'ul'            =>  'ul|li',
                'blockquote'    =>  'blockquote',
                'pre'           =>  'pre|code'
            ));
        }

        return str_replace('<p><!--more--></p>', '<!--more-->', $parser->makeHtml($text));
    }

    /**
     * transerCodeClass
     *
     * @param string $html
     * @return string
     */
    public static function transerCodeClass($html)
    {
        return preg_replace("/<code class=\"([_a-z0-9-]+)\">/i", "<code class=\"lang-\\1\">", $html);
    }

    /**
     * @param $html
     * @return mixed
     */
    public static function transerComment($html)
    {
        return preg_replace_callback("/<!\-\-(.+?)\-\->/s", array('Markdown', 'transerCommentCallback'), $html);
    }

    /**
     * @param $matches
     * @return string
     */
    public static function transerCommentCallback($matches)
    {
        return self::$parser->makeHolder($matches[0]);
    }
}