<?php

namespace Parser;

/**
 * Search user agents words from additional info.
 *
 * @package Parser
 */
class SearchBot
{
    public function search($list): ?string
    {
        $bot_list = [
            'Google',
            'Bing',
            'Baidu',
            'Yandex',
        ];

        foreach ($bot_list as $bl) {
            if (stripos($list, $bl) !== false) {
                return $bl;
            }
        }

        return null;
    }
}