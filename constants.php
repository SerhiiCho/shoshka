<?php

const TITLES_CACHE = __DIR__ . '/storage/titles';
const APP_DIR = __DIR__;

const LINK_REGEX = <<<REGEX
!<a href=["'](.*?)["']\sdata-rel=["']slide-.*?["']\sclass=["']slide-image["']\s.*?>.*?<\/a>!
REGEX;

const TITLE_REGEX = <<<REGEX
!<header class=['"]entry-content-header['"]><h3 class=['"]slide-entry-title\sentry-title['"].*?><a\s.*?>(.*?)<\/a><\/h3>!
REGEX;