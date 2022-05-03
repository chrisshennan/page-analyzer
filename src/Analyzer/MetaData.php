<?php

namespace Cas\PageAnalyzer\Analyzer;

use Psr\Http\Message\ResponseInterface;

/**
 * Class MetaData
 * @package Cas\PageAnalyzer\Analyzer
 */
class MetaData extends BaseAnalyzer
{
    /**
     * @param string $content
     * @return array
     */
    public function analyze(string $content) : array
    {
        if (!preg_match_all('/<meta[^>]*?(name|property).*?>/i', $content, $matches)) {
            return array();
        }

        $data = array();
        $dom = new \DOMDocument();

        foreach ($matches[0] as $index => $match) {
            $match = str_replace(' & ', ' &amp; ', $match);

            $dom->loadHTML('<?xml encoding="UTF-8">' . $match);

            $name = $dom->getElementsByTagName('meta')->item(0)->getAttribute($matches[1][$index]);
            $content = $dom->getElementsByTagName('meta')->item(0)->getAttribute('content');

            $data[$name] = $content;
        }

        return $data;
    }
}
