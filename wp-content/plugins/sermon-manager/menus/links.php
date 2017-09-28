<div class="wrap">
    <h1>Links</h1>
    <p>To add a link complete the inputs below and click 'Add Link'.</p>
    <form class="add-new-link" method="POST" enctype="multipart/form-data">
        <input name="link_name" placeholder="Link name" required>
        <input name="link_url" placeholder="Link url" required>
        <input name="logo_image_name" type="file" hidden required>
        <button class="button button-primary upload-image">Upload Image</button>
        <button type="submit" class="button button-primary disabled add-link">Add Link</button>
        <div id="image_preview"><img id="previewing" src="noimage.png" /></div>
    </form>

    <?php echo get_coc_links_for_admin(); ?>
</div>
<style>
    .link-list {
        margin: 2rem auto;
    }

    .link-list input {
        vertical-align: middle;
    }

    input[readonly] {
        border: 0;
        background-color: transparent;
    }

    .link-list label {
        padding: 3px 5px;
        margin: 1px;
        font-weight: bold;
        background-color: #0085BA; 
        color: #FFFFFF;
    }

    .link-list .link-item {
        padding: 1rem;
    }

    .link-list .link-item img {
        vertical-align: middle;
    }

    .link-list .link-item:nth-of-type(odd) {
        background-color: #FFFFFF; 
    }

    .add-new-link {
        padding: 1rem;
        border: 2px dashed #CCCCCC;
        border-radius: 0.2rem;
        text-align: center;
    }

    #image_preview {
        margin-top: 1rem; 
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $('input').each(function(i, input) {
        $(input).attr('size', $(input).val().length);
    });

    $('.upload-image').on('click', function() {
        $('input[type=file][name=logo_image_name]').click();
    });

    $('.add-new-link').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo get_site_url() . '/wp-json/links/create' ?>",
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(res) {
                alert('uploaded link!');
            }
        });
    });

    $('input').on('change', function() {
        if (checkNewLinkHasValues()) {
            $('button.add-link').removeClass('disabled');
        } else {
            $('button.add-link').addClass('disabled');
        }
    });

    function checkNewLinkHasValues() {
        return $('input[name=link_name]').val().length > 0 &&
               $('input[name=link_url]').val().length > 0 &&
               $('input[name=logo_image_name]').val().length > 0;
    }

    $("input[name=logo_image_name]").on('change', function() {
        $("#message").empty(); // To remove the previous error message
        var file = this.files[0];
        var imagefile = file.type;
        var match = ["image/jpeg", "image/png", "image/jpg"];
        if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
            $('#previewing').attr('src', 'noimage.png');
            $("#message").html("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
            return false;
        } else {
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);
        }
    });

    function imageIsLoaded(e) {
        $("#file").css("color", "green");
        $('#image_preview').css("display", "block");
        $('#previewing').attr('src', e.target.result);
    }
</script>
