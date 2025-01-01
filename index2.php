<div class="hero">
    <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <?php
            $stmt = $connect->prepare("SELECT * FROM banners ORDER BY id asc LIMIT 1");
            $stmt->execute();
            $banner1_data = $stmt->fetch();
            $banner1_data_id = $banner1_data['id'];
            $stmt = $connect->prepare("SELECT * FROM banners WHERE id !=? ");
            $stmt->execute(array($banner1_data_id));
            $allbanners = $stmt->fetchAll();
            ?>
            <div class="carousel-item carousel-item1 active"
                style="background-image: url('admin/banners/images/<?php echo $banner1_data['image']; ?>');">
                <div class="overlay"></div>
                <div class="carousel-caption">
                    <h5> <?php echo $banner1_data['head_name'] ?> </h5>
                    <p> <?php echo $banner1_data['description'] ?> </p>
                    <a target="_blank" href="https://t.me/mshtly" class="btn"> تواصل مع الخبير </a>
                </div>
            </div>
            <?php
            foreach ($allbanners as $banner) {
                ?>
                <div class="carousel-item carousel-item1"
                    style="background-image: url('admin/banners/images/<?php echo $banner['image']; ?>');">
                    <div class="overlay"></div>
                    <div class="carousel-caption">
                        <h5> <?php echo $banner['head_name']; ?> </h5>
                        <p> <?php echo $banner['description']; ?> </p>
                        <a target="_blank" href="https://t.me/mshtly" class="btn"> تواصل مع الخبير </a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>