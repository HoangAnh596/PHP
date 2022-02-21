<?php
    $list_infor=pdo_query_one("SELECT * FROM information");
    if(isset($_POST['btn_sub'])){
        $err=[];
        extract($_POST);
        if(empty($name_inforweb)){
            $err['name_inforweb']="Bạn chưa nhập tên website";
        }
        if(empty($address)){
            $err['address']="Bạn chưa nhập địa chỉ";
        }
        if(empty($email)){
            $err['email']="Bạn chưa nhập email";
        }
        if(empty($phone)){
            $err['phone']="Bạn chưa nhập số điện thoại";
        }
        if(empty($aboutus)){
            $err['aboutus']="Bạn chưa thông tin về chúng tôi";
        }
        if(empty($err)){
            if(empty($_FILES['file_image']['name'])){
                $url_image=$list_infor['logo'];
            }
            else{
                $anh=$_FILES['file_image'];
                $arr_allow_type=['image/png','image/jpeg'];
                if(in_array($anh['type'],$arr_allow_type)){
                    if($anh['size']<2097152){
                        $file_save='/'.$anh['name'];
                        $file_full_path=APP_PATH.'/../images/slide'.$file_save;
                        if(move_uploaded_file($anh['tmp_name'],$file_full_path)){
                            $url_image=BASE_URL.'/images/slide'.$file_save;
                            echo "Upload ảnh thành công!";
                        }
                    }
                    else{
                        echo "Ảnh quá dung lượng, bạn hãy chọn ảnh <2MB";
                    }
                }
                else{
                    echo "Định dạng ảnh không hợp lệ, bạn hãy chọn kiểu png hoặc jpeg";
                }
            }
            $dataInsert=[
                'name_website'=>$name_inforweb,
                'logo'=>$url_image,
                'address'=>$address,
                'email'=>$email,
                'phone'=>$phone,
                'aboutus'=>$aboutus
            ];
            $sql="UPDATE information SET name_website=:name_website,logo=:logo,address=:address,email=:email,phone=:phone,aboutus=:aboutus";
            pdo_execute($sql,$dataInsert);
            header("Location:?page=infor-web");
        }
    }
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Thay đổi thông tin website</h3>
            <div class="form-group row">
                <label class="col-md-3" for="nameProduct">Tên website</label>
                <div class="col-md-9">
                    <input type="text" id="nameProduct" class="form-control" placeholder="Nhập tên website" name="name_inforweb" value="<?php if(isset($err['name_inforweb'])){ }else {echo $list_infor['name_website'];}?>">
                </div>
                <p style="color: red; margin-left:300px; font-style:italic;">
                    <?php
                        echo @$err['name_inforweb'];
                    ?>
                </p>
            </div>
            <div class="form-group row">
                <label class="col-md-3">Thay đổi ảnh logo</label>
                <div class="col-md-9">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="validatedCustomFile" name="file_image">
                        <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                        <div class="invalid-feedback">Example invalid custom file feedback</div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3" for="disabledTextInput">Địa chỉ</label>
                <div class="col-md-9">
                    <input type="text" id="nameProduct" class="form-control" placeholder="Nhập địa chỉ" name="address" value="<?php if(isset($err['address'])){ }else {echo $list_infor['address'];}?>">
                </div>
                <p style="color: red; margin-left:300px; font-style:italic;">
                    <?php
                        echo @$err['address'];
                    ?>
                </p>
            </div>
            <div class="form-group row">
                <label class="col-md-3" for="disabledTextInput">Số điện thoại</label>
                <div class="col-md-9">
                    <input type="text" id="nameProduct" class="form-control" placeholder="Nhập số điện thoại" name="phone" value="<?php if(isset($err['phone'])){ }else {echo $list_infor['phone'];}?>">
                </div>
                <p style="color: red; margin-left:300px; font-style:italic;">
                    <?php
                        echo @$err['phone'];
                    ?>
                </p>
            </div>
            <div class="form-group row">
                <label class="col-md-3" for="disabledTextInput">Email</label>
                <div class="col-md-9">
                    <input type="text" id="nameProduct" class="form-control" placeholder="Nhập email" name="email" value="<?php if(isset($err['email'])){ }else {echo $list_infor['email'];}?>">
                </div>
                <p style="color: red; margin-left:300px; font-style:italic;">
                    <?php
                        echo @$err['email'];
                    ?>
                </p>
            </div>
            <div class="form-group row">
                <label class="col-md-3" for="disabledTextInput">Về chúng tôi</label>
                <div class="col-md-9">
                    <textarea id="nameProduct" class="form-control" placeholder="Nhập thông tin" name="aboutus"><?php if(isset($err['aboutus'])){ }else {echo $list_infor['aboutus'];}?></textarea>
                </div>
                <p style="color: red; margin-left:300px; font-style:italic;">
                    <?php
                        echo @$err['aboutus'];
                    ?>
                </p>
            </div>
        </div>
        <div class="border-top">
            <div class="card-body">
                <button type="submit" class="btn btn-primary" name="btn_sub">Thay đổi</button>
            </div>
        </div>
    </div>
</form>