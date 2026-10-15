<?php

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function safe_href(?string $url): string
{
    $url = trim((string) $url);
    if (preg_match('#^https?://#i', $url) === 1) {
        return e($url);
    }

    return '#';
}
