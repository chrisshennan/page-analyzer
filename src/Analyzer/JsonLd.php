<?php

namespace Cas\PageAnalyzer\Analyzer;

use Psr\Http\Message\ResponseInterface;

/**
 * Class JsonLd
 * @package Cas\PageAnalyzer\Analyzer
 */
class JsonLd extends BaseAnalyzer
{
    /**
     * @param string $content
     * @return array
     */
    public function analyze(string $content) : array
    {
        if (!preg_match_all('/<script[^>]*?type=["\']application\/ld\+json["\'].*?>(.*?)<\/script>/i', $content, $matches)) {
            return array();
        }

        $data = array();
        foreach ($matches[1] as $match) {
            $extractedData = json_decode($match);

            if (is_object($extractedData) && get_class($extractedData) == 'stdClass') {
                $data[] = json_decode($match, true);
            } elseif (is_array($extractedData)) {
                $extractedData = json_decode($match, true);

                foreach ($extractedData as $extractedDataElement) {
                    $data[] = $extractedDataElement;
                }
            }
        }

        return $data;
    }
}
