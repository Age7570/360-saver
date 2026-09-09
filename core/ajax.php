<?php
require_once('../config.php');
set_time_limit(60);
if(isset($_POST["url"]) AND $_POST["host"]=="instagram"){
    include("insta.core.php");
    $url = $_POST["url"];
    $insta = new Insta($url);
    if($insta->videoid() == null){
        sleep(1);
        echo getError("<div id='download-error'>Invalid Insta URL</div>");
        exit;
    }
    $media = $insta->get_media();
    if($media==false || count($media['links'])==0) {
        echo getError("<div id='download-error'>Download link not found.</div>");
        exit;
    }
?>

    <div class="row">
        <div class="col-md-12">
            <?php foreach($media['links'] as $link): ?>
                <div class="row story-container mt-4 pb-4 border-bottom">
                    <div class="col-md-8 mx-auto">
                        <div class="image">
                            <img src="<?php echo $link['preview']; ?>" class="img-fluid img-thumbnail" style="height: 350px;">
                        </div>
                        <a href="dl.php?url=<?php echo base64_encode($link['url']); ?>" class="btn btn-red mt-2" download="">
                            <i class="fa fa-download"></i> Download
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php
}else{
    sleep(1);
    echo getError("<div id='download-error'>We do not support downloading from this site.</div>");
    exit;
}
function getError($msg){
    return '<div class="alert alert-danger alert-dismissible fade show">'.$msg.'</div>';
}
?> 