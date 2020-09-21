<?php

use Parser\SearchBot;

require_once("Search/SearchBot.php");

/**
 * Get access_log File parse and get info.
 */
class LogParser
{
    /**
     * LogParser constructor.
     *
     * @param string $fileContent
     *
     * @throws JsonException
     */
    public function __construct($fileContent)
    {
        $lines = $this->getLines($fileContent);
        $this->getResult($lines);
    }

    /**
     * Getting array of strings.
     *
     * @param $data
     *
     * @return array
     */
    public function getLines($data): array
    {
        return explode(PHP_EOL, $data);
    }

    /**
     * Parse info and get result.
     *
     * @param array $lines
     *
     * @throws JsonException
     */
    public function getResult($lines): void
    {
        $result = [
            'views'       => 0,
            'urls'        => 0,
            'traffic'     => 0,
            'crawlers'    => [
                'Google' => 0,
                'Bing'   => 0,
                'Baidu'  => 0,
                'Yandex' => 0,
            ],
            'statusCodes' => [],
        ];

        $search = new SearchBot();

        $urls      = [];
        $lineParts = [];
        $crawlers  = [];
        $status    = [];

        foreach ($lines as $line) {
            $url = preg_match(
                '/(?<ip>[\S]+).+" (?<code>\d+) (?<length>\d*) (?<http>\S+) (?<additionalInfo>\S+.+)/',
                $line,
                $lineParts
            );

            if (!empty($url)) {
                $result['views']++;
            }

            if (!empty($lineParts['http'])) {
                if (!array_key_exists($lineParts['http'], $urls)) {
                    $urls[$lineParts['http']] = true;
                    $result['urls']++;
                }
            }

            if (!empty($lineParts['code'])) {
                $status[] = $lineParts['code'];
            }

            if (!empty($lineParts['length'])) {
                $result['traffic'] += $lineParts['length'];
            }

            if (!empty($lineParts['additionalInfo'])) {
                $is_bot = $search->search($lineParts['additionalInfo']);
                if (!is_null($is_bot)) {
                    $crawlers[] = $is_bot;
                }
            }
        }

        $result['statusCodes'] = array_count_values($status);
        $count                 = array_count_values($crawlers);

        foreach ($count as $key => $value) {
            $result['crawlers'] = $count;
        }

        echo json_encode($result, JSON_THROW_ON_ERROR);
    }
}