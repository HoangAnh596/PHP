<?php
    if(isset($_POST['btn_sub'])){
        extract($_POST);
        $err=[];
        if(empty($name_slide)){
            $err['name_slide']="Bạn chưa nhập tên slide";
        }
        if(empty($_FILES['file_image']['name'])){
            $err['image']="Bạn chưa chọn ảnh";
        }
        if(empty($link)){
            $err['link']="Bạn chưa nhập link của web chứa slide";
        }
        if(empty($err)){
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
            $inserData=[
                'name_slide'=>$name_slide,
                'link'=>$link,
                'image'=>$url_image
            ];
            $sql="INSERT INTO slides(name_slide,image,link) VALUES(:name_slide,:image,:link)";
            pdo_execute($sql,$inserData);
            echo "thêm vào thành công";
            header("Location:?page=slide");
        }
    }
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Thêm slide</h3>
            <div class="form-group row">
                <label class="col-md-3" for="nameProduct">Tên slide</label>
                <div class="col-md-9">
                    <input type="text" id="nameProduct" class="form-control" placeholder="<?php if(isset($_POST['btn_sub'])){echo $_POST['name_slide'];} else{echo "Nhập tên slide";}?>" name="name_slide">
                </div>
                <p style="color: red; margin-left:300px; font-style:italic;">
                    <?php
                        echo @$err['name_slide'];
                    ?>
                </p>
            </div>
            <div class="form-group row">
                <label class="col-md-3">Thêm ảnh</label>
                <div class="col-md-9">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="validatedCustomFile" name="file_image">
                        <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                        <div class="invalid-feedback">Example invalid custom file feedback</div>
                    </div>
                </div>
                <p style="color: red; margin-left:300px; font-style:italic;">
                    <?php
                        echo @$err['image'];
                    ?>
                </p>
            </div>
            <div class="form-group row">
                <label class="col-md-3" for="disabledTextInput">Link của trang web chứa slide</label>
                <div class="col-md-9">
                    <input type="text" id="nameProduct" class="form-control" placeholder="<?php if(isset($_POST['btn_sub'])){echo $_POST['link'];} else{echo "Nhập link";}?>" name="link">
                </div>
                <p style="color: red; margin-left:300px; font-style:italic;">
                    <?php
                        echo @$err['link'];
                    ?>
                </p>
            </div>
        </div>
        <div class="border-top">
            <div class="card-body">
                <button type="submit" class="btn btn-primary" name="btn_sub">Thêm</button>
            </div>
        </div>
    </div>
</form>