<?php
    $list_sl=pdo_query("SELECT * FROM slides");
    $arr=[];
    $arr_lk=[];
    $i=0;
    foreach($list_sl as $value){
        $arr[$i]=$value['image'];
        $arr_lk[$i]=$value['link'];
        $i++;
    }
    $arr_slide=implode(',',$arr);
    $arr_lk=implode(',',$arr_lk);
    // print_r($arr_slide);
?>
<script>
    var arr='<?php echo $arr_slide ?>';
    var m_arr=arr.split(',');
    var arr_lk='<?php echo $arr_lk ?>';
    var m_arr_lk=arr_lk.split(',');
    var images = [];
    var soLuongAnh = <?php echo count($list_sl)?>;
    for (var i = 0; i < soLuongAnh; i++) {
        images[i] = new Image();
        images[i].src =m_arr[i];
    }
    var index = -1;
    var anh = document.getElementById("anh");
    var link_img = document.getElementById("link_img");
    function load() {
        index++;
        if (index >= images.length) {
            index = 0;
        }
        console.log(index);
        anh.src = images[index].src;
        link_img.href = m_arr_lk[index];
        setTimeout("load()", 5000);
    }
    load();
    function next() {
        if (index == soLuongAnh - 1) {
            index = -1;
        }
        if (index >= -1) {
            index++;
            document.getElementById('anh').src = images[index].src;
            link_img.href = m_arr_lk[index];
        }
        console.log(index);
    }

    function back() {
        if (index == 0) {
            index = soLuongAnh;
        }
        if (index <= soLuongAnh) {
            index--;
            document.querySelector('#anh').src = images[index].src;
            link_img.href = m_arr_lk[index];
        }
    }
</script>