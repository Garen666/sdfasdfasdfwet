<?php
class robots_txt extends Engine_Class {

    public function process() {
        $robots = PackageLoader::Get()->getProjectPath().'robots.txt';

        header('Content-type: text/plain');

        // показываем robots.txt если он есть
        if (file_exists($robots)) {
            $robots = file_get_contents($robots);
            if ($robots) {
                echo $robots;
                exit();
            }
        }

        echo "User-agent: *\n";
        echo "Disallow: /*currency*\n";
        echo "Disallow: /*.php$\n";
        echo "Disallow: /*p=0*\n";
        echo "Disallow: /*p=all*\n";
        echo "Disallow: /*show=table*\n";
        echo "Disallow: /*buy=*\n";
        echo "Disallow: /*show=thumbs*\n";
        echo "Disallow: /*category=*category=*\n";
        echo "Disallow: /*query=*\n";
        echo "Disallow: /client/*\n";
        echo "Disallow: /admin/*\n";
        echo "Sitemap: ".Engine::Get()->getProjectURL()."/sitemap.xml\n";
        echo "Host: ".Engine::Get()->getProjectHost()."\n";

        exit();
    }

}