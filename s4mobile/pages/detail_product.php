<?php
date_default_timezone_set("Asia/Ho_Chi_Minh");
pdo_execute("UPDATE products SET view=view+1 WHERE id_product={$_GET['id']}", '');
$err = array();
if (isset($_GET['id_cmts']) && isset($_SESSION['user'])) {
    $id_cm = $_GET['id_cmts'];

    $stmt = $objConn->prepare(" DELETE FROM  comments WHERE id_cmt = $id_cm ");
    $stmt->execute();
}
if (isset($_GET['id_cmts']) && isset($_SESSION['admin'])) {
    $id_cm = $_GET['id_cmts'];

    $stmt = $objConn->prepare(" DELETE FROM  comments WHERE id_cmt = $id_cm ");
    $stmt->execute();
}
$id = $_GET['id'];
if (isset($_POST['btn_rate'])) {
        if(isset($_SESSION['admin'])||isset($_SESSION['user'])){
            $point_rate = $_POST['selected_rating'];
        if (empty($point_rate)) {
            $msg_rate = "Bạn chưa chọn điểm đánh giá";
        } else {
            pdo_execute("UPDATE products SET point=point+$point_rate WHERE id_product=$id", "");
            pdo_execute("UPDATE products SET count_point=count_point+1 WHERE id_product=$id", "");
        }
    }
    else{
        echo "<script>alert('Bạn cần đăng nhập để đánh giá!')</script>";
    }
}


try {
    $stmt = $objConn->prepare("SELECT * FROM products WHERE id_product = $id");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $detail = $stmt->fetch();
} catch (PDOException $e) {
    echo $e->getMessage();
}

$bought = pdo_query_one("SELECT COUNT(id_product) as 'count' FROM orderdetail WHERE id_product={$detail['id_product']}");
if (isset($_SESSION['user']) && isset($_POST['btnCmts'])) {

    $username  = $_SESSION['user'];
    $comment = $_POST['comment'];
    $status = 1;
    $date = date("Y-m-d");

    if (empty($comment)) {
        $err['content'] = "Bạn cần nhập bình luận";
    }
    if (empty($err)) {
        $stmt = $objConn->prepare("SELECT * FROM user WHERE username = '$username'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $son = $stmt->fetch();
        $id_user  =  $son['id_user'];

        $stmt = $objConn->prepare("INSERT INTO comments(content,id_product,id_user , status , create_at) 
        VALUES ('$comment' , '$id' , '$id_user' ,  '$status' , '$date') ");
        $stmt->execute();
    }
} elseif (isset($_SESSION['admin']) && isset($_POST['btnCmts'])) {
    $username  = $_SESSION['admin'];
    $comment = $_POST['comment'];
    $status = 1;
    $date = date("Y-m-d");
    if (empty($comment)) {
        $err['content'] = "Bạn cần nhập bình luận";
    }
    if (empty($err)) {
        $stmt = $objConn->prepare("SELECT * FROM user WHERE username = '$username'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $son = $stmt->fetch();
        $id_user  =  $son['id_user'];

        $stmt = $objConn->prepare("INSERT INTO comments(content,id_product,id_user , status , create_at) 
                                        VALUES ('$comment' , '$id' , '$id_user' ,  '$status' , '$date') ");
        $stmt->execute();
    }
} elseif (!isset($_SESSION['user']) && isset($_POST['btnCmts'])) { ?>
    <script>
        alert("Bạn cần đăng nhập với bình luận được");
    </script>

<?php
}


?>

<div class="col-md-9 bor">
    <section class="box-main1">
        <h3 class="title-main" style="text-align: center;"> Chi tiết sản phẩm </h3>

        <div class="detail">
            <div class="left">
                <div class="post-thumb">
                    <img src="<?php echo $detail['images']; ?>" alt="">
                </div>
                <div class="post-title" style="margin:0px; width:380px;"><?php echo $detail['name_product']; ?></div>
            </div>
            <div class="right">
                <div class="price">
                    <p class="sale">Giá cũ: <?php echo number_format($detail['price_old']); ?>vnd</p>
                    <p><?php echo number_format($detail['sale']); ?> vnd</p>
                </div>
                <div class="content">
                    <h4>Cấu hình:</h4>
                    <?php
                    echo $detail['decribe'];
                    ?>
                </div>
                <div class="view-bought" style="margin: 10px;font-size:18px;">
                    Lượt xem: <?php echo $detail['view'] ?><br>
                    Đã bán: <?php echo $bought['count'] ?>
                </div>
                <form action="" method="post">
                    <input type="hidden" name="id_cart" value="<?php echo $detail['id_product']; ?>" style="margin-left:30px;">
                    <input name="quantity" value="1" type="number" min="0" /> <br>
                    <button style="margin-top: 10px; padding: 6px; background-color:#00BBA6 ;color: white;margin-left: 8%;border-radius: 10px; width:250px;height:45px;font-weight:bolder;font-size:15px;" class="btn" name="btn_add_cart">Thêm vào giỏ hàng</button>
                </form>
            </div>
        </div>
        <div class="introduce">
            <h3>giới thiệu</h3>
            <p><?php echo $detail['detail']; ?> </p>
        </div>
        <div class="comment">
            <h3 id="comment2">bình luận</h3>
            <?php
            $stmt = $objConn->prepare("SELECT * FROM comments WHERE id_product = $id");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $cmts =   $stmt->fetchAll();
            foreach ($cmts as $cmt) {
                $id_user =  $cmt['id_user'];
                $stmt = $objConn->prepare("SELECT  *  FROM user WHERE id_user =  $id_user");
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $names =   $stmt->fetchAll();
                foreach ($names as $namess) {
                    $statuss =  $cmt['status'];
                    if ($statuss == 1) {
            ?>


                        <section style="height:50px;margin-top :20px;">
                            <div class="contents" style="width:700px;float:left;">
                                <span style="margin-right:5px;">
                                    <img src="<?php echo $namess['image'] ?>" alt="" width="30">
                                </span>
                                <a href="" style="font-size: 17px;padding-bottom:20px;"><?php echo $namess['username']; ?></a>
                                <?php
                                if ($namess['pemission'] == 1) {
                                    echo "<span style='margin:5px;border:0.2px solid red; padding:3px; border-radius:5px;'> Quản trị viên</span>";
                                } else {
                                    echo "<span style='margin:5px;border:0.2px solid red; padding:3px; border-radius:5px;'> Khách hàng</span>";
                                }
                                ?>
                                </span>
                                <p style="font-size: 17px;margin-left:20px;margin-top:10px;" class="content"> <?php echo $cmt['content']; ?></p>
                            </div>
                            <div style=" width:100px; height:70px; float:right;">
                                <p style="font-size: 17px;padding-bottom:10px;"><?php echo $cmt['create_at']; ?></p>
                                <?php if (isset($_SESSION['user'])) {
                                    if ($_SESSION['user'] == $namess['username']) { ?>
                                        <a href="?page=detail&id=<?php echo $detail['id_product'];  ?>&id_cmts=<?php echo $cmt['id_cmt']; ?> " onclick="return confirm('Bạn có đồng ý xóa bình luận này không?')">Xóa</a>
                                    <?php }
                                } elseif (isset($_SESSION['admin'])) {
                                    if ($_SESSION['admin'] == $namess['username']) {  ?>
                                        <a href="?page=detail&id=<?php echo $detail['id_product']; ?>&cate=&id_cmts=<?php echo $cmt['id_cmt']; ?>" onclick="return confirm('Bạn có đồng ý xóa bình luận này không?')">Xóa</a>
                                <?php }
                                }   ?>
                            </div>
                        </section>
            <?php
                    }
                }
            } ?>
            <form action="" method="post">
                <textarea name="comment" placeholder="Viết bình luận ở đây..."></textarea>
                <button name="btnCmts" class="btn btn-danger" onclick="btn_comment()">Bình luận</button>
            </form>
            <form action="" method="post">
                <div class="form-group-rate" id="rating-ability-wrapper" style="">
                    <label class="control-label" for="rating">
                        <span class="field-label-header">Đánh giá sản phẩm này </span><br>
                        <span class="field-label-info"></span>
                        <input type="hidden" id="selected_rating" name="selected_rating" value="" required="required">
                    </label>
                    <h2 class="bold rating-header" style="">
                        <span class="selected-rating">0</span><small> / 5</small>
                    </h2>
                    <button type="button" class="btnrating btn btn-default btn-lg" data-attr="1" id="rating-star-1" name="point" value="1">
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btnrating btn btn-default btn-lg" data-attr="2" id="rating-star-2">
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btnrating btn btn-default btn-lg" data-attr="3" id="rating-star-3">
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btnrating btn btn-default btn-lg" data-attr="4" id="rating-star-4">
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btnrating btn btn-default btn-lg" data-attr="5" id="rating-star-5">
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                    <p>Điểm đánh giá: <?php
                                            if ($detail['count_point'] != 0) {
                                                echo round($detail['point'] / $detail['count_point'],1);
                                            } else {
                                                echo "Chưa có lượt đánh giá nào!";
                                            }

                                            ?></p>
                </div>
                <button type="submit" style="width:120px;height:40px;" name="btn_rate">Đánh giá</button>
                <p style="color: red;"><?php echo @$msg_rate ?></p>
            </form>
        </div>
    </section>
</div>
<script>
    function btn_comment() {
        window.location.href = "#comment2";
    }
    $(function() {
        $('input[type="number"]').niceNumber({
            buttonDecrement: '-',
            buttonIncrement: "+",
            buttonPosition: 'around'

        });
    });
    jQuery(document).ready(function($) {

        $(".btnrating").on('click', (function(e) {

            var previous_value = $("#selected_rating").val();

            var selected_value = $(this).attr("data-attr");
            $("#selected_rating").val(selected_value);

            $(".selected-rating").empty();
            $(".selected-rating").html(selected_value);

            for (i = 1; i <= selected_value; ++i) {
                $("#rating-star-" + i).toggleClass('btn-warning');
                $("#rating-star-" + i).toggleClass('btn-default');
            }

            for (ix = 1; ix <= previous_value; ++ix) {
                $("#rating-star-" + ix).toggleClass('btn-warning');
                $("#rating-star-" + ix).toggleClass('btn-default');
            }

        }));


    });
</script>