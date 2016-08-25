@extends("layout.master")
@section("meta")
    @if(isset($siteOptions))
        <meta name="keywords" content="{{!isset($siteOptions['SITE_KEYWORD']) ? '' :$siteOptions['SITE_KEYWORD']}}">
        <meta name="description" content="{{!isset($siteOptions['SITE_DESCRIPTION']) ? '' : $siteOptions['SITE_DESCRIPTION']}}">
        <meta name="copyright" content="{{!isset($siteOptions['SITE_COPYRIGHT']) ? '' : $siteOptions['SITE_COPYRIGHT']}}">
        <meta name="author" content="{{!isset($siteOptions['SITE_AUTHOR']) ? '' : $siteOptions['SITE_AUTHOR']}}">
        <meta name="robots" content="all">
    @endif
@endsection
@section("content")
    <div class="full-width bg-grey">
        <div class="content">
            <div class="artist-filter">
                <ul>
                    <li  class="">
                        <a href="#">All</a>
                    </li>
                    @foreach ($artistFilter as $item)
                        <li class="">
                            <a href="#">{{$item}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="artist-filter-type">
                sort by <span>alphabet</span>
            </div>
        </div>
    </div>
    @include("pages.includes.artists")
@endsection
@section("scripts")
    <script type="text/javascript">

        //POP OVER
        var showPopover=function(event){
            window.clearTimeout(window.showPopoverTimeout);

            var targetEl=$(event.currentTarget);
            if(targetEl==undefined) return false;
            var targetElPosition=targetEl.offset();

            var top=targetElPosition.top;
            var left=targetElPosition.left;
            var height=targetEl.outerHeight();
            var width=targetEl.outerWidth();
            var padding=targetEl.parent().innerHeight()-height;

            var popupMainCss={
                top: top - padding,
                left: left - padding,
            };
            var popupInfoCss={
                top: 0,
                left: 0,
                width: width + 2 * padding,
                padding: padding
            };
            var modelInfoCss={
                marginTop: height + padding
            };
            var popupGridCss={
                top: 0,
                left: 'auto',
                right: 'auto',
                width:  popupInfoCss.width * 1.05,
                paddingTop: padding,
                paddingRight: 0,
                paddingBottom: 0,
                paddingLeft: 0,
                display: 'block'
            };
            var popupGridColumnCss={
                paddingRight: 0,
                paddingLeft: 0,
                marginBottom: padding
            };

            var offsetParent=$('body');
            var offsetParentWidth=offsetParent.innerWidth();

            var shadowCss={};
            if(left < (offsetParent.offset().left+offsetParentWidth/2)){
                // position on right
                popupGridCss.left=popupInfoCss.width;
                popupGridColumnCss.paddingRight=padding;
                $('#model-image-popover').removeClass("model-on-right").addClass("model-on-left").css(shadowCss);
            }
            else{
                // position on left
                popupGridCss.left=-popupGridCss.width;
                popupGridColumnCss.paddingLeft=padding;
                $('#model-image-popover').removeClass("model-on-left").addClass("model-on-right").css(shadowCss);

            }

            // apply css
            $('#model-image-popover').css(popupMainCss);
            $('#model-image-popover-info').css(popupInfoCss);
            $('#model-image-popover-info #model-info').css(modelInfoCss);
            $('#model-image-popover-grid').css(popupGridCss);
            $('#model-image-popover-grid .grid-model-image-popover-column').css(popupGridColumnCss);

            // change layer ordering
            targetEl.closest('.grid-masonry').find(".model").css({'z-index':0});
            targetEl.css({'z-index':29});

            window.showPopoverTimeout=window.setTimeout(function(){$('#model-image-popover').hide().fadeIn(100);}, 250);
        };

        var hidePopover = function(event){
            window.clearTimeout(window.showPopoverTimeout);
            $('#model-image-popover').fadeOut(100);
        };

        var initImagePopover=function(event, model){
            var information_data_1 = model.artist_extra_1;
            var information_data_2 = model.artist_extra_2;
            $('#model-image-popover .model-info-model-name').html(model['artist_full_name']);
            $('#model-image-popover .model-type').html("(" + model['artist_type_name'] + ")");
            var information1Data = '';
            var information2Data = '';
            $('#model-image-popover .model-info-col-1').empty();
            $('#model-image-popover .model-info-col-2').empty();

            $.each(information_data_1 , function(){
                var template = '<div class="model-info-detail">' +
                        '<span class="model-detail-label">' + this.title + '</span>' +
                        '<span class="model-detail-value" >' + this.value + '</span>' +
                        '</div>';
                information1Data += template;
            });
            $.each(information_data_2 , function(){
                var template = '<div class="model-info-detail">' +
                        '<span class="model-detail-label">' + this.title + '</span>' +
                        '<span class="model-detail-value" >' + this.value + '</span>' +
                        '</div>';
                information2Data += template;
            });
            $('#model-image-popover .model-info-col-1').html(information1Data);
            $('#model-image-popover .model-info-col-2').html(information2Data);

            $.ajax({
                url : '/api/image/preview/' + model.artist_slug,
                type:"GET",
                contentType:"application/json; charset=utf-8",
                dataType:"json",
                success: function(data){
                    console.log(data);
                    $('#model-image-popover-grid .grid-model-image-popover .grid-model-image-popover-column').empty();
                    if(data.length > 0){
                        var template  =  '<div class="grid-item"> <img src="/assets/upload/' + data[0].artist_type + '/' + data[0].artist_name + '/' + data[0].file_name + '"></div>';
                        if(data.length > 1) {
                            template += '<div class="grid-item"> <img src="/assets/upload/' +  data[1].artist_type+ '/' + data[1].artist_name + '/' +  data[1].file_name + '"></div>';
                        }
                        $('#model-image-popover-grid .grid-model-image-popover .grid-model-image-popover-column.column-1').html(template);
                        template  = '';
                        if(data.length > 2) {
                            template +=' <div class="grid-item"> <img src="/assets/upload/' + data[2].artist_type + '/' + data[2].artist_name + '/' + data[2].file_name + '"></div>';
                            if(data.length > 3) {
                                template += '<div class="grid-item"> <img src="/assets/upload/' +  data[3].artist_type+ '/' + data[3].artist_name + '/' +  data[3].file_name + '"></div>';
                            }
                        }
                        $('#model-image-popover-grid .grid-model-image-popover .grid-model-image-popover-column.column-2').html(template);
                    }
                }
            });

           //   var requestId = model['artist_slug'] + "_" + Math.random();
//            if(requestId!=$scope.imagePopover.requestId){
//                $scope.imagePopover.images=$scope.defaultImagePopoverImageArray;
//            }
//            $scope.imagePopover.requestId=requestId;
//            $scope.imagePopover.isActive=true;
//            $scope.imagePopover.model=model;
//
//            ImageSet.server().get({imageTypeString:'preview',modelString:model.name},function(data){
//                if(data.$resolved && (!data.data!=undefined) && (requestId==$scope.imagePopover.requestId)){
//                    $scope.imagePopover.images=ImageSet.getImagesFromImageSet(data);
//                }
//            });
        };
        $(function () {
            $('body').toggleClass('artists');
            $('.loader-container').toggleClass("active");
            $('.grid-masonry').toggleClass("active");

            $('.grid-masonry').masonry({
                columnWidth: '.grid-column-size',
                itemSelector: '.masonry-brick',
                percentPosition: true
            });

            $(".grid-item").mouseenter(function(e){
                var $this = $(this);
                var artist = $this.data('artist');
                if(artist) {
                    var words = CryptoJS.enc.Base64.parse(artist);
                    var textString = CryptoJS.enc.Utf8.stringify(words);
                    initImagePopover(e, JSON.parse(textString))
                }
            });

            $(".grid-item").hoverIntent({
                over: showPopover,
                out: hidePopover
            });


        })


    </script>
@endsection