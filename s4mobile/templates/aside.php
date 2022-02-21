<div id="maincontent">
    <div class="container">
        <div class="col-md-3  fixside">
            <div class="box-left box-menu">
                <h3 class="box-title"><i class="fa fa-list"></i>Danh mục</h3>
          
              
                <ul>
                <?php 
                $stmt = $objConn->prepare("SELECT * FROM category ORDER BY category.id_category ASC");
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $category = $stmt->fetchAll();
                foreach($category as $cate ){
                ?>
                    <li>
                        <a href="?page=productCate&id=<?php echo $cate['id_category']; ?>"><?php echo $cate['name_category']; ?></a>
                    </li>
                <?php } ?>
                </ul>
    
            </div>

            <div class="box-left box-menu">
                <h3 class="box-title"><i class="fa fa-list"></i>Mức giá</h3>
                <ul>
                    <li>
                        <a href="?page=search&price=all">Tất cả</a>
                    </li>
                    <li>
                        <a href="?page=search&price=2">Dưới 2 triệu</a>
                    </li>
                    <li>
                        <a href="?page=search&price=24">Từ 2 -4 triệu</a>
                    </li>
                    <li>
                        <a href="?page=search&price=47">Từ 4 - 7 triệu</a>
                    </li>
                    <li>
                        <a href="?page=search&price=713">Từ 7 - 13 triệu</a>
                    </li>
                    <li>
                        <a href="?page=search&price=13">Trên 13 triệu</a>
                    </li>
                </ul>
                <!-- </marquee> -->
            </div>

            <div class="box-left box-menu">
                <h3 class="box-title"><i class="fa fa-warning"></i> Sản phẩm mới </h3>
               
                <ul>
                <?php 
                    $stmt = $objConn->prepare("SELECT * FROM products LIMIT 3");
                    $stmt->execute();
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $news = $stmt->fetchAll();
                    foreach($news as $new){
                ?>

                    <li class="clearfix">
                        <a href="?page=detail&id=<?php echo $new['id_product']; ?>">
                            <img src="<?php echo $new['images']; ?>" class="img-responsive pull-left" width="80" height="80">
                            <div class="info pull-right">
                                <p class="name"> <?php echo $new['name_product']; ?></p>
                                <b class="price">Giảm giá: <?php echo  number_format($new['sale'])."đ"; ?> </b><br>
                                <b class="sale">Giá gốc:  <?php echo  number_format($new['price_old'])."đ"; ?></b><br>
                            </div>
                        </a>
                    </li>

                <?php } ?>
                </ul>
                <!-- </marquee> -->
            </div>
        </div>
     

          


            