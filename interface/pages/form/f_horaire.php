<div id="horaire-form-box" class="form-popup undisplayed">
    <form id="horaire-form" method="POST" enctype="multipart/form-data">
        <h2>horaire 1</h2>
        <div class="file-input-box">
            <label for="horaire-image1" class="label-file">Choisir une image</label>
            <input id="horaire-image1" class="input-file" type="file" name="horaire[]"/>
            <div class="image-preview"><img width="200px" height="200px" src="../../public/pages/images/horaire/horaire0.jpg?<?php echo time() ?>"></div>
        </div>
        <h2>horaire 2</h2>
        <div class="file-input-box">
            <label for="horaire-image2" class="label-file">Choisir une image</label>
            <input id="horaire-image2" class="input-file" type="file" name="horaire[]"/>
            <div class="image-preview"><img width="200px" height="200px" src="../../public/pages/images/horaire/horaire1.jpg"></div>
        </div>
        <div id='upload-btn' class='update'>UPLOAD</div>
    </form>
</div>