<?php

function replaceInDir($dir) {
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    $count = 0;
    foreach ($files as $name => $file) {
        if (!$file->isDir() && $file->getExtension() === 'php') {
            $filePath = $file->getPathname();
            $content = file_get_contents($filePath);
            
            $replacements = [
                '/#0[Ff]5132/' => '#FF7A00', // green -> orange
                '/#[Dd]4[Aa]017/' => '#FF7A00', // gold -> orange
                '/#157347/' => '#E26C00', // green hover -> orange hover
                '/#0[aA]3620/' => '#0E101A', // dark green -> dark navy
                '/#082919/' => '#06070B', // deep dark green -> deep dark navy
                '/#0F5132/' => '#FF7A00', // uppercase green -> orange
                '/#D4A017/' => '#FF7A00', // uppercase gold -> orange
            ];

            $newContent = preg_replace(array_keys($replacements), array_values($replacements), $content, -1, $runCount);
            
            if ($runCount > 0) {
                file_put_contents($filePath, $newContent);
                echo "Updated ($runCount replacements): " . basename($filePath) . "\n";
                $count++;
            }
        }
    }
    echo "Total files updated: $count\n";
}

replaceInDir(__DIR__ . '/../resources/views');
