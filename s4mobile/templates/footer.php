</div>
</section>

</div>
</div>
<div class="container">
    <div class="col-md-4 bottom-content">
        <img src="images/free-shipping.png">
    </div>
    <div class="col-md-4 bottom-content">
        <img src="images/guaranteed.png">
    </div>
    <div class="col-md-4 bottom-content">
        <img src="images/deal.png">
    </div>
</div>
<div class="container-pluid">
    <section id="footer">
        <div class="container">
            <div class="col-md-3" id="shareicon" style="background: #00BBA6;">
                <ul>
                    <li>
                        <i class="fa fa-facebook"></i>
                    </li>
                    <li>
                        <i class="fa fa-twitter"></i>
                    </li>
                    <li>
                        <i class="fa fa-google-plus"></i>
                    </li>
                    <li>
                        <i class="fa fa-youtube"></i>
                    </li>
                </ul>
            </div>
            <div class="col-md-8" id="title-block">
                <div class="pull-left">

                </div>
                <div class="pull-right">

                </div>
            </div>

        </div>
    </section>
    <section id="footer-button">
        <div class="container-pluid">
            <div class="container">
                <div class="col-md-3" id="ft-about">
                    <h3 class="tittle-footer">Về chúng tôi</h3>
                    <p><?php echo $list_infor_website['aboutus']?></p>
                </div>
                <div class="col-md-3 box-footer">
                    <h3 class="tittle-footer">Tài khoản</h3>
                    <ul>
                        <li>
                            <i class="fa fa-angle-double-right"></i>
                            <a href="?page=register"><i></i> Đăng kí </a>
                        </li>
                        <li>
                            <i class="fa fa-angle-double-right"></i>
                            <a href="?page=login"><i></i> Đăng nhập </a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-3" id="footer-support">
                    <h3 class="tittle-footer"> Liên hệ</h3>
                    <ul>
                        <li>
                            <p><i class="fa fa-home" style="font-size: 16px;padding-right: 5px;"></i> <?php echo $list_infor_website['address']?> </p>
                            <p><i class="sp-ic fa fa-mobile" style="font-size: 22px;padding-right: 5px;"></i> <?php echo $list_infor_website['address']?></p>
                            <p><i class="sp-ic fa fa-envelope" style="font-size: 13px;padding-right: 5px;"></i> <?php echo $list_infor_website['phone']?></p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section id="ft-bottom">
        <p class="text-center">Copyright © 2020 . Design by team S4mobile </p>
    </section>
</div>
</div>
</div>
</div>
</div>
<script src="public/js/slick.min.js"></script>

</body>

</html>

<script type="text/javascript">
    $(function() {
        $hidenitem = $(".hidenitem");
        $itemproduct = $(".item-product");
        $itemproduct.hover(function() {
            $(this).children(".hidenitem").show(100);
        }, function() {
            $hidenitem.hide(500);
        })
    })
</script>