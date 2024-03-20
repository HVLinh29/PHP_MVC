<div class="header_bottom">
    <div class="header_bottom_left">
        <div class="section group">
            <?php
            $getLastesDell = $product->getLastesDell();
            if($getLastesDell){
                while($resultdell=$getLastesDell->fetch_assoc()){
            
            ?>
            <div class="listview_1_of_2 images_1_of_2">
                <div class="listimg listimg_2_of_1">
                    <a href="details.php"> <img src="admin/uploads/<?php echo $resultdell['hinhanh'] ?>" alt="" /></a>
                </div>
                <div class="text list_2_of_1">
                    <h2>Dell</h2>
                    <p><?php echo $resultdell['productName'] ?></p>
                    <div class="button"><span><a href="details.php?proid=<?php echo $resultdell['productId'] ?>">Add to cart</a></span></div>
                </div>
            </div>
            <?php
            }
        }
            ?>
              <?php
            $getLastesAcer = $product->getLastesAcer();
            if($getLastesAcer){
                while($resultacer=$getLastesAcer->fetch_assoc()){
            
            ?>
            <div class="listview_1_of_2 images_1_of_2">
                <div class="listimg listimg_2_of_1">
                    <a href="details.php"><img src="admin/uploads/<?php echo $resultacer['hinhanh'] ?>" alt="" /></a>
                </div>
                <div class="text list_2_of_1">
                    <h2>Acer</h2>
                    <p><?php echo $resultacer['productName'] ?></p>
                    <div class="button"><span><a href="details.php?proid=<?php echo $resultacer['productId'] ?>">Add to cart</a></span></div>
                </div>
            </div>
        </div>
        <?php
            }
        }
        ?>
        <div class="section group">
        <?php
            $getLastesIphon = $product->getLastesIphon();
            if($getLastesIphon){
                while($resultiphon=$getLastesIphon->fetch_assoc()){
            
            ?>
            <div class="listview_1_of_2 images_1_of_2">
                <div class="listimg listimg_2_of_1">
                    <a href="details.php"> <img src="admin/uploads/<?php echo $resultiphon['hinhanh'] ?>" alt="" /></a>
                </div>
                <div class="text list_2_of_1">
                    <h2>Iphon</h2>
                    <p><?php echo $resultiphon['productName'] ?></p>
                    <div class="button"><span><a href="details.php?proid=<?php echo $resultiphon['productId'] ?>">Add to cart</a></span></div>
                </div>
            </div>
            <?php
            }
        }
            ?>
           <?php
            $getLastesSS = $product->getLastesSS();
            if($getLastesSS){
                while($resultss=$getLastesSS->fetch_assoc()){
            
            ?>
            <div class="listview_1_of_2 images_1_of_2">
                <div class="listimg listimg_2_of_1">
                    <a href="details.php"> <img src="admin/uploads/<?php echo $resultss['hinhanh'] ?>" alt="" /></a>
                </div>
                <div class="text list_2_of_1">
                    <h2>Dell</h2>
                    <p><?php echo $resultss['productName'] ?></p>
                    <div class="button"><span><a href="details.php?proid=<?php echo $resultss['productId'] ?>">Add to cart</a></span></div>
                </div>
            </div>
            <?php
            }
        }
            ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="header_bottom_right_images">
        <!-- FlexSlider -->

        <section class="slider">
            <div class="flexslider">
                <ul class="slides">
                    <?php
                    $get_slider =$product->show_slider();
                    if($get_slider){
                        while($result= $get_slider->fetch_assoc()){
                    
                    ?>
                    <li><img src="admin/uploads/<?php echo $result['sliderimg']?>" alt="<?php echo $result['sliderName']?>" /></li>
                    <?php
                    }
                }
                    ?>
                   
                </ul>
            </div>
        </section>
        <!-- FlexSlider -->
    </div>

    <div class="clear"></div>
</div>