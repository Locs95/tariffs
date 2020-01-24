<?php

namespace App;

class Tariff {

	private $url = './data.json';
    private $jsonData = null;
    
    public function __construct() {
        $res = file_get_contents($this->url);
        $this->jsonData = json_decode($res, true);
    }

    
    public function getGroups() {

        $prices = [];
        $arr = [];
        foreach($this->jsonData['tarifs'] as $k=>$item) {
    
            foreach($item['tarifs'] as $c=>$el) {

                foreach($el as $key=>$val) {
                   $arr[$c] = $el['price'];
                   $prices[$k]= $arr;
                }
            }
        }


    ?>
      <div class="d-flex flex-wrap mt-4">
    <?php
        foreach($this->jsonData['tarifs'] as $index=>$item) {
    ?>
         <div class="tariff col-md-6 col-lg-4 mb-4">
            <div class="card">
                <div class="tariff__title card-header">Тариф <?=$item['title']?></div>
                <div class="card-body">
                <a href="/group/<?=$index?>" target-link="group" class="d-flex align-items-start justify-content-between text-decoration-none tariff__link-block">
                    <div class="col-lg-8 pl-0">
                        <div class="tariff__speed d-inline
                             <?php 
                                if($item['speed'] == 100) {
                                    echo 'tariff__speed_blue';
                                } else if($item['speed'] == 50) {
                                    echo 'tariff__speed_brown';
                                } else if($item['speed'] == 200){
                                    echo 'tariff__speed_orange';
                                }
                             ?>
                            "><span><?=$item['speed']?> Мбит/с</span>
                        </div>
                        <div class="tariff__price d-flex align-items-center">
                            <span><?= min($prices[$index]).' - '. max($prices[$index]) ?> &#8381;/мес</span>
                        </div>
                        <?php if($item['free_options'] > 0): ?>
                            <div class="tariff__free-options">
                        <?php foreach($item['free_options'] as $key=>$el): ?>
                                <p class="mb-1"><?=$el?></p>
                        <?php  endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="tariff__arrow align-self-center">&rsaquo;</div>
                </a>
                </div>
                <div class="card-footer">
                    <a href="<?=$item['link']?>" class="tariff__link" target="__blank">узнать подробнее на сайте www.sknt.ru</a>
                </div>
            </div>
        </div>
    <?php
        }
    ?>
      </div>
    <?php

        
    }


    public function getGroupTariffs($id) {
        $data = [];

        foreach($this->jsonData['tarifs'] as $index=>$item) {
             if($index == $id) {
                array_push($data,$item);
             } 
        }

    ?>
        <div class="col-12">
        <a href="/" target-link="home" class="p-0 tariff__caption-block d-flex align-items-center mt-4 text-decoration-none">
            <div class="col-1 tariff__arrow-green">&lsaquo;</div>
            <div class="col-10 text-center"><h3 class="tariff__caption">Тариф "<?=$data[0]['title']?>"</h3></div>
        </a>
        </div>
        <div class="d-flex flex-wrap">
    <?php

        foreach($data[0]['tarifs'] as $el) {
    ?>

         <div class="tariff col-sm-6 col-lg-4 mb-4">
            <div class="card">
                <div class="card-header tariff__title">Тариф <?=$el['title']?></div>
                <div class="card-body">
                    <a href="/tariff/<?=$id?>/<?=$el['ID']?>" target-link="group-tariff" class="text-decoration-none d-flex align-items-center justify-content-between">
                    <div class="d-flex flex-column">
                         <div class="tariff__price d-flex align-items-center"><span><?=$el['price']?> &#8381;/мес</span></div>
                         <div class="tariff__payment">
                             <p>разовый платеж - <?=$el['price']?> &#8381;</p>
                         </div>
                    </div>
                    <div class="tariff__arrow">&rsaquo;</div>
                    </a>
                </div>
            </div>
        </div>
    <?php
        }
     ?>
     </div>
     <?php
       
    }

    public function getTariff($group_id, $tariff_id) {

        $data = [];
        $tariff = [];

        foreach($this->jsonData['tarifs'] as $index=>$item) {
            if($index == $group_id) {
                array_push($data,$item);
            }
        }

       
        foreach($data[0]['tarifs'] as $item) {
            if($item['ID'] == $tariff_id) {
                array_push($tariff, $item);
            }
        }

     ?>
  
        

         <div class="d-flex flex-wrap justify-content-center">
         <div class="tariff col-sm-5 mb-4">
            <a href="/group/<?=$group_id?>" target-link="group" class="d-flex align-items-center mt-4 text-decoration-none tariff__caption-block">
                <div class="tariff__arrow-green">&lsaquo;</div>
                <div class="col-11 text-center"><h3 class="tariff__caption">Выбор тарифа</h3></div>
            </a>
            <div class="tariff__card">
                <div class="card-header tariff__title">Тариф <?=$tariff[0]['title']?></div>
                    <div class="card-body">
                         <div class="tariff__price">
                            <p class="mb-1">Период оплаты - <?=$tariff[0]['pay_period']?> мес</p>
                            <p><?=$tariff[0]['price']?> &#8381;/мес</p>
                        </div>
                         <div class="tariff__payment">
                             <p class="mb-1">разовый платеж - <?=$tariff[0]['price']?> &#8381;</p>
                             <p>со счета спишется - <?=$tariff[0]['price']?> &#8381;</p>
                         </div>
                         <div class="tariff__info">
                             <p class="mb-1">вступит в силу - сегодня</p>
                             <p>активно до - <?=date('j.m.Y H:i:s', strtotime($tariff[0]['new_payday']))?></p>
                         </div>
                    </div>
                 <div class="card-footer tariff__btn">
                     <button class="btn btn-block">Выбрать</button>
                 </div>
            </div>
        </div>

    </div>

     <?php

    }

}