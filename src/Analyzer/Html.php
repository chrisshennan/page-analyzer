<?php

namespace Cas\PageAnalyzer\Analyzer;

use Psr\Http\Message\ResponseInterface;

/**
 * Class Html
 * @package Cas\PageAnalyzer\Analyzer
 */
class Html extends BaseAnalyzer
{
    /**
     * @param string $content
     * @return array
     */
    public function analyze(string $content) : array
    {
        $data = [];

        // Get the page title
        if (preg_match_all('/<title>(.*?)<\/title>/i', $content, $matches)) {
            $data['title'] = reset($matches[1]);
        }

        // Get the first H1 tag - assuming best practices and there there is a single H1 tag per page
        if (preg_match_all('/<h1.*?>(.*?)<\/h1>/i', $content, $matches)) {
            $data['h1'] = reset($matches[1]);
        }

        return $data;
    }
}
