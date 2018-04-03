<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 */
class Test_ParserProductAPI_Price extends TestKit_TestClass {

    public function testYazz1() {
        $p = new ParserProductAPI('http://yazz.com.ua/spinning-favorite-absolute-662ul-198m-2-10g-fast');

        try {
            $this->assertEquals(
            $p->getPrice(),
            504
            );
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    /*public function testFotos1() {
    $p = new ParserProductAPI('http://fotos.ua/favorite/absolute-662ul-1-98m
    -2-10g-fast.html');

    $this->assertEquals(
    $p->getPrice(),
    504
    );
    }*/

    public function testFishRiver1() {
        $p = new ParserProductAPI('http://www.fish-river.com.ua/products/spinning-favorite/spinning-favorite-solo-602ul-183m-05-6g-exfast.html');

        try {
            $this->assertEquals(
            $p->getPrice(),
            4536
            );
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testLuckyFisher1() {
        $p = new ParserProductAPI('http://luckyfisher.com.ua/rods/spinningi/favorite-1/spinning-favorite-absolute-662ul-198m-2-10g-fast-16930037');

        try {
            $this->assertEquals(
            $p->getPrice(),
            473
            );
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testKapitanKo1() {
        $p = new ParserProductAPI('http://kapitan.kolesiko.ua/Favorite-Absolute-662UL.-1.98m-2-10g-Fast.html');

        try {
            $this->assertEquals(
            $p->getPrice(),
            504
            );
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testIbis1() {
        $p = new ParserProductAPI('http://ibis.net.ua/ru/products/details/16930037/');

        try {
            $this->assertEquals(
            $p->getPrice(),
            504
            );
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testSokol1() {
        $p = new ParserProductAPI('http://www.sokol.ua/spinning-favorite-balance-blc-662l-1693-01-64-14a78/p212015/');

        try {
            $this->assertEquals(
            $p->getPrice(),
            599
            );
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testRovita1() {
        $p = new ParserProductAPI('http://rovita.com.ua/fishing/16482-katushka-cobra-640a-met-shpulja.htm');

        try {
            $this->assertEquals(
            $p->getPrice(),
            167.65
            );
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testRovita2() {
        $p = new ParserProductAPI('http://rovita.com.ua/fishing/16412-katushka-zhibo-green-cobra-cb-440.htm');

        try {
            $this->assertEquals(
            $p->getPrice(),
            96.67
            );
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testRovita3() {
        $p = new ParserProductAPI('http://rovita.com.ua/fishing/16412-katushka-zhibo-green-cobra-cb-440.htm1');

        try {
            $p->getPrice();
        } catch (Exception $e) {
            return;
        }

        $this->fail();
    }

    public function testKruchkoff1() {
        $p = new ParserProductAPI('http://kruchkoff.net.ua/p41938604-shnur-power-pro.html');

        try {
            $this->assertEquals(
            $p->getPrice(),
            225
            );
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testLovim1() {
        $p = new ParserProductAPI('http://lovim.com.ua/product_info.php?products_id=8437');

        try {
            $this->assertEquals(
            $p->getPrice(),
            7504
            );
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testXZone1() {
        $p = new ParserProductAPI('http://www.x-zone.com.ua/fishing/rods/spinnings/taifun_40_2116_300.html');

        try {
            $this->assertEquals(
            $p->getPrice(),
            162
            );
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testUK1() {
        $p = new ParserProductAPI('http://ukostra.ua/catalog/rybolovnye_snasti/leski_shnury_povodki/shnury/shnur_berkley_fireline_braid_moss_green/?offer_id=127906');

        try {
            $this->assertEquals(
            $p->getPrice(),
            793.53
            );
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function tesFS1() {
        $p = new ParserProductAPI('http://fishingstock.ua/catalog/soare_ss/udilishche_shimano_soare_ss_s700uls_/');

        try {
            $this->assertEquals(
            $p->getPrice(),
            234
            );
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testFishingShop1() {
        $p = new ParserProductAPI('http://fishing-shop.com.ua/36_udilitscha/1152_udilitscha_Libao/1153_spinningovye_udilitscha/1197_ACTIVE_SPIN_/6309_spinningovoe_udilitsche_LIBAO_ACTIVE_SPIN_2_10m_10_30gr');

        try {
            $this->assertEquals(
            $p->getPrice(),
            256
            );
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testAdams1() {
        $p = new ParserProductAPI('http://adams.com.ua/udilischa/spinningovye-udilischa/spinning-microport-light-180-3-16.html');

        try {
            $this->assertEquals(
            $p->getPrice(),
            490.10
            );
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testGoodcatch() {
        $p = new ParserProductAPI('http://goodcatch.com.ua/5861_кровать_экстра-прочной_стальной_конструкции_carp_zoom_heavy_duty_bedchair_до_150_кг');

        try {
            $this->assertEquals(
            $p->getPrice(),
            3001
            );
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testRozetka1() {
        $p = new ParserProductAPI('http://rozetka.com.ua/favorite_absolute_662l/p414094/');

        try {
            $this->assertEquals(
            $p->getPrice(),
            520
            );
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

}