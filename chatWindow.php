<?php include ("views/_templates/header.php"); ?>

<section class="container">
    <div class="row">
        <section class="chatWindow">
            <div class="stage">
            </div><!--end of stage-->
            
            <section class="commentBox col-xs-12">
            <div class="comment col-xs-10">
                <input type="text" class="form-control" aria-describedby="basic-addon1" placeholder="write a comment"> 
            </div><!--end of comment-->
            <div class="commentBtn col-xs-2">
                <button type="button" class="btn btn-default sendBtn1">send</button>
            </div>
            <div class="commentText">
            </div><!--end of commentText-->
        </section><!--end of commentBox-->
            
        </section><!--end of chatWindow-->
    </div><!--end of row-->
</section><!--end of section-->

<?php include ("views/_templates/footer.php"); ?>