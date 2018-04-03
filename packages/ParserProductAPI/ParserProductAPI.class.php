<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package ParserProductAPI
 */
class ParserProductAPI {

    public function __construct($url) {
        $this->_url = $url;
    }

    public function getName() {
        $html = $this->_getContent();

        $html = preg_replace("/<script(.+?)<\/script>/ius", '', $html);
        $html = preg_replace("/<style(.+?)<\/style>/ius", '', $html);
        $html = preg_replace("/<!--(.+?)-->/ius", '', $html);
        $html = preg_replace("/style=[\"'](.+?)[\"']/ius", '', $html);

        if (preg_match("/<h1(?:.+?)>(.+?)<\/h1>/ius", $html, $r)) {
        	return trim($r[1]);
        }

        if (preg_match("/itemprop=['\"]name['\"].{0,50}?>(.+?)<\//ius", $html, $r)) {
        	return trim($r[1]);
        }

        $html = preg_replace("/([\w]+?)=[\"'](.*?)[\"']/iuse", '$this->_removeNot("$2", "name")', $html);

        if (preg_match("/name.{0,50}?>(.+?)<\//ius", $html, $r)) {
        	return trim($r[1]);
        }

        throw new Exception('name', 0);
    }

    public function getPrice() {
        $html = $this->_getContent();

        $html = preg_replace("/<script(.+?)<\/script>/ius", '', $html);
        $html = preg_replace("/<style(.+?)<\/style>/ius", '', $html);
        $html = preg_replace("/<!--(.+?)-->/ius", '', $html);
        $html = preg_replace("/style=[\"'](.+?)[\"']/ius", '', $html);
        $html = preg_replace("/([\w]+?)=[\"'](.*?)[\"']/iuse", '$this->_removeNot("$2", "price")', $html);

        // идея в том чтобы в коде найти все упоминания price + чило
        if (preg_match_all("/price.{0,200}?([\d\.]+\s*[\d]*)/ius", $html, $r)) {
            //print_r($r);

            $a = array();
            foreach ($r[1] as $x) {
                $x = trim($x);
                if (!preg_match("/\d+/ius", $x)) {
                    continue;
                }
                if (!$x) {
                    continue;
                }

                if (empty($a)) {
                    $a[$x] = 5;
                } else {
                    @$a[$x] ++;
                }
            }

            if ($a) {
                arsort($a);
                foreach ($a as $price => $frequency) {
                    return round($price, 2);
                }
            }
        }

        throw new Exception('price', 0);
    }

    private function _getContent() {
        if ($this->_html) {
            return $this->_html;
        }

        if (!$this->_url) {
            throw new Exception('url', 0);
        }

        $ttl = 100*24*60*60;

        $userAgent = 'Googlebot/2.1 (+http://www.google.com/bot.html)';

        $p = new TextProcessor();
        $p->addAction(new TextProcessor_ActionContentFromURL($this->_url, $ttl, $userAgent));
        $html = $p->process();

        if (!preg_match("//u", $html)) {
            $html = iconv('windows-1251', 'utf-8', $html);
        }

        if (!$html) {
            throw new Exception('content', 0);
        }

        $this->_html = $html;

        return $this->_html;
    }

    private function _removeNot($s, $prefix) {
        if (!preg_match("/{$prefix}/ius", $s)) {
            return '';
        }

        $s = preg_replace("/[^{$prefix}]+/ius", '', $s);
        return $s;
    }

    private $_url;

    private $_html;

}