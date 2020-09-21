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
            'Googlebot',
            'Baiduspider',
            'ia_archiver',
            'R6_FeedFetcher',
            'NetcraftSurveyAgent',
            'Sogou web spider',
            'bingbot',
            'Yahoo! Slurp',
            'facebookexternalhit',
            'PrintfulBot',
            'msnbot',
            'Twitterbot',
            'UnwindFetchor',
            'urlresolver',
            'AppleWebKit',
        ];

        foreach ($bot_list as $bl) {
            if (stripos($list, $bl) !== false) {
                return $bl;
            }
        }

        return null;
    }
}