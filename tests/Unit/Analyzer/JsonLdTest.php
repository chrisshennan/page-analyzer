<?php

namespace Tests\Unit\Analyzer;

use Cas\PageAnalyzer\Analyzer\JsonLd;
use PHPUnit\Framework\TestCase;

class JsonLdTest extends TestCase
{
    /**
     * @dataProvider getDataProviderForJsonLd
     * @return void
     */
    public function testAnalyze($html, $expected)
    {
        $analyzer = new JsonLd();
        $actual = $analyzer->analyze($html);

        $this->assertEquals($expected, $actual);
    }

    public function getDataProviderForJsonLd()
    {
        $variations = [
            [
                // Basic Case
                '<script type="application/ld+json">
                    [
                        {
                            "url":"https://www.chrisshennan.com"
                        }
                    ]
                </script>',
                [
                    [
                        'url' => 'https://www.chrisshennan.com'
                    ],
                ],
            ],
            // With additional attributes after type i.e. TechCrunch
            [
                '<script type="application/ld+json" class="yoast-schema-graph">
                    [
                        {
                            "url":"https://www.chrisshennan.com"
                        }
                    ]
                </script>',
                [
                    [
                        'url' => 'https://www.chrisshennan.com'
                    ],
                ],
            ],
        ];

        $replacements = [
            "\r\n"  => '',
            "\n"    => '',
        ];

        foreach ($variations as &$case) {
            $case[0] = str_replace(array_keys($replacements), $replacements, $case[0]);
        }

        return $variations;
    }
}