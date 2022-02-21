<?php
    // hiện thị số lượng của giỏ hàng
    if(isset($_SESSION['cart'])){
        $total_count_cart=$_SESSION['cart'];
        $tong=0;
        foreach($total_count_cart as $key=>$value){
            $tong+=$value['sl'];
        }
    }
?>
     <!--MENUNAV-->
     <div id="menunav">
            <div class="container">
                <nav>
                    <div class="home pull-left">
                        <a href="?page">Trang chủ</a>
                    </div>
                    <!--menu main-->
                    <ul id="menu-main">
                        <li>
                            <a href="?page=lien-he">Liên hệ</a>
                        </li>
                    </ul>
                    <!-- end menu main-->

                    <!--Shopping-->
                    <ul class="pull-right" id="main-shopping">
                        <li>
                            <a href="?page=cart"><i class="fa fa-shopping-basket"></i> My Cart <?php 
                                if(!isset($tong)){
                                    $tong=0;
                                }
                            echo 
                            '<span style="border:1px white solid; color:white; padding:5px; font-size:12px;">'.$tong.'</span>';
                            ?></a>
                        </li>
                    </ul>
                    <!--end Shopping-->
                </nav>
            </div>
        </div>
        <!--ENDMENUNAV-->