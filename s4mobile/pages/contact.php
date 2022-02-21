<?php
    if(isset($_POST['btn_submit'])){
        $ten_khach=$_POST['ten_khach'];
        $email_khach=$_POST['email_khach'];
        $subject=$_POST['subject'];
        $noidung=$_POST['noidung'];
        $err=[];
        if(empty($ten_khach)){
            $err['ten_khach']="Bạn chưa nhập tên";
        }
        if(empty($email_khach)){
            $err['email_khach']="Bạn chưa nhập email";
        }
        if(empty($subject)){
            $err['subject']="Bạn chưa nhập tiêu đề";
        }
        if(empty($noidung)){
            $err['content']="Bạn chưa nhập nội dung";
        }
        if(empty($err)){
            //1. Key dưới đây chỉ dùng tạm, khi chạy dịch vụ chính thức bạn cần đăng ký tài khoản của sendgrid.com
            // website nhỏ thì dùng tài khoản miễn phí ok
            // tham khảo cách đăng ký để lấy key https://saophaixoan.net/search-tut?q=sendgrid
            // trong code này chỉ cần lấy key là ok, sau khi gửi thử xong thì verify là ok.
            $SENDGRID_API_KEY='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';

            require 'vendor/autoload.php';
            $email = new \SendGrid\Mail\Mail(); 
            ///------- bạn chỉnh sửa các thông tin dưới đây cho phù hợp với mục đích cá nhân
            // Thông tin người gửi
            $email->setFrom("vietcone@gmail.com", "Thư khách liên hệ trên website s4mobile"); 
            // Tiêu đề thư
            $email->setSubject("Thư mới");
            // Thông tin người nhận
            $email->addTo("vietcone@gmail.com", "s4mobile"); 
            // Soạn nội dung cho thư
            // $email->addContent("text/plain", "Nội dung text thuần không có thẻ html");
            $email->addContent(
                "text/html", "
                Người gửi: {$_POST['ten_khach']}, email: {$_POST['email_khach']} <br>
                Tiêu đề:{$_POST['subject']}<br>
                Nội dung: 
                <span>".$_POST['noidung']."</span>"
            );

            // tiến hành gửi thư
            $sendgrid = new \SendGrid($SENDGRID_API_KEY);
            try {
                $response = $sendgrid->send($email);
                $msg="<h4 style='color:blue;margin:10px;'>Gửi thành công</h4>";
                //--- mấy dòng print này thích in ra thì in.
                // print $response->statusCode() . "\n";
                // print_r($response->headers());
                // print $response->body() . "\n";

            } catch (Exception $e) {
                echo 'Caught exception: '. $e->getMessage() ."\n";
            }
        }
    }
?>
<div class="col-md-9 bor" style="border:none">
    <section class="box-main1">
        <section class="mb-4">
            <h2 style="color: black; margin:5px;">Liên hệ - Góp ý</h2>
            <div class="row">
                <div class="col-md-9 mb-md-0 mb-5" style="margin-left:5px; margin-top:8px;">
                    <form id="contact-form" name="contact-form" action="" method="post">

                        <!--Grid row-->
                        <div class="row"  style="margin-bottom:15px;">

                            <!--Grid column-->
                            <div class="col-md-6">
                                <div class="md-form mb-0">
                                    <label for="name" class="text-primary" style="font-size:16px;">Tên của bạn</label>
                                    <input type="text" id="name" name="ten_khach" class="form-control" value="<?php echo @$ten_khach?>">
                                    <p style="color: red;font-size:16px;"><?php echo @$err['ten_khach']?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="md-form mb-0">
                                    <label for="email" class="text-primary" style="font-size:16px;">Email của bạn</label>
                                    <input type="text" id="email" name="email_khach" class="form-control" value="<?php echo @$email_khach?>">
                                    <p style="color: red;font-size:16px;"><?php echo @$err['email_khach']?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="md-form mb-0">
                                    <label for="subject" class="text-primary" style="font-size:16px;">Tiêu đề</label>
                                    <input type="text" id="subject" name="subject" class="form-control" value="<?php echo @$subject?>">
                                    <p style="color: red;font-size:16px;"><?php echo @$err['subject']?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">

                                <div class="md-form" style="margin-top:8px;">
                                    <label for="message" class="text-primary" style="font-size:16px;">Nội dung</label>
                                    <textarea type="text" id="message" name="noidung" rows="4" class="form-control md-textarea"><?php echo @$noidung?></textarea>
                                </div>
                                <p style="color: red;font-size:16px;"><?php echo @$err['content']?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary" style="width:100px; font-size:18px; margin-left:15px;margin-top:10px;" name="btn_submit">Gửi đi</button>
                                <?php
                                    echo @$msg;
                                 ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </section>
    </section>
</div>