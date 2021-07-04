<?php

function generateAttribute(bool $unicode, string $version = 'latest'): string
{
    $content = file_get_contents(sprintf(
        "https://unpkg.com/filter-validate-email@%s/lib/regexp/%s.js",
        $version,
        $unicode ? 'unicode' : 'ascii'
    ));

    if (!preg_match('#^var _default = /(.*)/[a-z]+;$#im', $content, $match)) {
        throw new \RuntimeException('Invalid Response.');
    }

    return htmlspecialchars(strtr($match[1], ['a-z' => 'a-zA-Z', 'a-f' => 'a-fA-F']), ENT_QUOTES);
}

echo "# HTML Pattern Attribute (Unicode)\n";
echo generateAttribute(true, $_SERVER['argv'][1] ?? 'latest') . "\n";
echo "\n";
echo "# HTML Pattern Attribute (Ascii)\n";
echo generateAttribute(false, $_SERVER['argv'][1] ?? 'latest') . "\n";
echo "\n";
