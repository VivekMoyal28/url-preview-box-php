<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Resume Uploader</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet"> 
    <link href="js/datepicker/datepicker3.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <style>
        #Image img{display: none;}
        .active{display:block!important};
    </style>
</head>
<body>
    
    <form>
        <div class="col-md-6 col-md-offset-3">
            <h2 class="text-center">URL Preview</h2>
    <div class="panel panel-bd lobidisable">
                <div class="panel-heading">
                    <div class="btn-group" id="buttonlist"> <i class="fa fa-list"></i> Add New Published News</div>
                </div>
                <div class="panel-body">
                    <div class="col-md-12 text-center">
    <div class="input-group">
        <input type="text" id="urlbox" class="form-control" placeholder="Search for...">
      <span class="input-group-btn">
          <button class="btn btn-primary" id="extract" name="extract" type="button">Extract</button>
      </span>
    </div>
        <br/>
        <i id="loader" class="fa fa-spin fa-spinner fa-2x"></i>
  </div>
                    <div class="col-md-12">
            <div id="bigbox" class="bigbox">
            <div id="Image"></div>
            <div id="slidemove" class="text-center">
                <span id="left"><i class="fa fa-arrow-circle-left text-muted fa-2x"></i></span>
                <span id="right"><i class="fa fa-arrow-circle-right text-muted fa-2x"></i></span>
            </div>
            <div id="Title"></div>
            <div id="Description"></div>
        </div>
  </div>
                </div>
            </div>
  </div>
    </form>
    
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    
     <script>
    $('#loader').hide();
    $('#extract').click(function(){
        $('#loader').show();
        var Url=$('#urlbox').val();
        $.ajax({
            type: "POST",
            url: "urlDetails.php",
            data:{url:Url},
            success: function(data){
                console.log(data);
                $('#loader').hide();
                var boxdata=$.parseJSON(data);
                $('#Title').html(boxdata.Title);
                $('#Description').html(boxdata.Description);
                $('#Url').html(boxdata.Url);
                $('#TitleText').val(boxdata.Title);
                $('#DescriptionText').val(boxdata.Description);
                $('#UrlText').val(boxdata.Url);
                var imagelist="";
                var a=1;
        $.each(boxdata.Image,function(key,value){
                    if(a===1){
                        imagelist+="<img width='100%' src='"+value+"' class='active'>";
                        $('#ImageUrl').html(value);
                        $('#ImageText').val(value);
                    }
                    else
                    {
                        imagelist+="<img width='100%' src='"+value+"'>";
                    }
                    a++;
                });
                $('#Image').html(imagelist);
            }
            });
    });
    
    $('#left').click(function(e){
        var active = $('#Image img.active');
        var next = active.next('img').length ? active.next() : $('#Image img:first');
        $('#ImageUrl').html(next.attr("src"));
        $('#ImageText').val(next.attr("src"));
        next.css({
        opacity: 0.0
    }).addClass('active').animate({
        opacity: 1.0
    }, 0, function() {
        active.removeClass('active');
        active.css({
            opacity: 0.0
        });
    })
    });
    
    $('#right').click(function(){
           var active = $('#Image img.active');
        var prev = active.prev('img').length ? active.prev() : $('#Image img:last');
        $('#ImageUrl').html(prev.attr("src"));
        $('#ImageText').val(prev.attr("src"));
        prev.css({
        opacity: 0.0
    }).addClass('active').animate({
        opacity: 1.0
    }, 0, function() {
        active.removeClass('active');
        active.css({
            opacity: 0.0
        });
    })
    });
    </script>
</body>
</html>