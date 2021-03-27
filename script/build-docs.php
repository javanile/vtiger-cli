<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Javanile\VtigerCli\App;
use phpDocumentor\Reflection\DocBlockFactory;

$toc = '';
$documentation = "<hr/>"."\n\n";
$docBlockFactory = DocBlockFactory::createInstance();

$sections = [
    App::class,
];

try {
    foreach ($sections as $class) {
        $reflection = new ReflectionClass($class);
        $docBlock = $docBlockFactory->create($reflection->getDocComment());
        $description = trim($docBlock->getDescription(), '.');
        $toc .= $description."\n\n";
        $toc .= '| Command | Description |'."\n";
        $toc .= '| --- | --- |'."\n";
        foreach (get_class_methods($class) as $method) {
            $reflection = new ReflectionMethod($class, $method);
            if ($method == '__construct' || $reflection->class != $class) {
                continue;
            }
            echo "> {$class}::{$method}\n";
            $docBlock = $docBlockFactory->create($reflection->getDocComment());
            $summary = trim($docBlock->getSummary(), '.');
            $description = $docBlock->getDescription();
            $usage = $docBlock->getTagsByName('usage')[0];
            $toc .= '| ['.$method.'](#'.strtr($method, ' ', '-').') | '.$summary.' |'."\n";
            $documentation .= '### ' . $summary . "\n\n";
            $documentation .= $description . "\n\n";
            $documentation .= "#### Usage \n\n```\n" . $usage->getDescription() . "\n```\n\n";
            $documentation .= "#### Examples\n\n";
            foreach ($docBlock->getTagsByName('example') as $tag) {
                $documentation .= "```php\n<?php\n" . $tag->getDescription() . "\n```\n\n";
            }
            $documentation .= '[[back to top]](#Documentation)'."\n\n";
            $documentation .= "<hr/>"."\n\n";
        }
    }
} catch (ReflectionException $exception) {
    echo $exception->getMessage()."\n";
    echo $exception->getTraceAsString();
    exit(1);
}

$readme = file_get_contents('./docs/README.md');

$updatedReadme = preg_replace(
    '/## The Commands.*## The `vtiger.json` schema/s',
    '## The Commands'."\n\n".$toc."\n\n".$documentation."\n\n".'## The `vtiger.json` schema',
    $readme
);

file_put_contents('./docs/README.md', $updatedReadme);
