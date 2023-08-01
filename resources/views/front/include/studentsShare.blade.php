<!-- START SECTION -->
<div class="section ptb_65_130 sharing_bg">
    <div class="container">
        <div class="row member-sharing-article">
            <div class="col-lg-6 col-sm-12"></div>
            <div class="col-lg-6 col-sm-12">
                <div class="">
                    <h2 class="title">學員分享<span class="large-eng">experience sharing</span></h2>
                    <div class="sub-title"></div>
                    <div>
                        <div class="block-container bg-color-ltb">
                            <div class="text">
                                <div class="text-align-left">
                                    <div
                                        class="btnbox-tabs btnbox-tabs-standard ui-tabs ui-widget ui-widget-content ui-corner-all">
                                        <ul class="btnbox-tabs-nav ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all"
                                            role="tablist">
                                            @foreach ($data['studentShareInfo'] as $i => $item)
                                            <?php $i = $i + 1; $bgc = '';
                                            if ($i == 1){ $bgc = '#80abae'; }
                                            if ($i == 2){ $bgc = '#b46e4c'; }
                                            if ($i == 3){ $bgc = '#e6b35d'; }
                                            if ($i == 4){ $bgc = '#80abae'; }
                                            if ($i == 5){ $bgc = '#b46e4c'; }
                                            ?>
                                            <li class="ui-state-default ui-corner-top student-share-style{{$i}}" role="tab" tabindex="0"
                                                aria-controls="tab-{{$i}}" aria-labelledby="ui-id-{{$i}}" aria-selected="true" aria-expanded="true">
                                                <a href="#tab-{{$i}}" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-{{$i}}">
                                                    <span class="tabs-nav-a-text">{{$item->show_name}}</span>
                                                    <span class="btnbox-tabs-nav-a-bckgr" style="background-color: {{$bgc}};"></span>
                                                </a>
                                            </li>
                                            @endforeach
                                        </ul>
                                        @foreach ($data['studentShareInfo'] as $i => $item)
                                        <?php $i = $i + 1; ?>
                                        <div class="btnbox-tab-container ui-tabs-panel ui-wget-content ui-corner-bottom ui-widget-content" id="tab-{{$i}}"
                                            style="display: inline-block;" aria-labelledby="ui-id-{{$i}}" role="tabpanel">
                                            <div class="">
                                                <div class="tab-ht">
                                                    <p>{{$item->introduction}}</p>
                                                </div>
                                                <div class="more-link more-link1" onclick="javascript:location.href='{{$item->href}}';">more</div>
                                            </div>
                                            <div class="article member-sharing-article-img">
                                                <img src="{{ $webPath }}assets/images/article-img-2.png"
                                                    class="article-img">
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p></p>
                        <p></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION -->

<style>
    .student-share-style1{
        border-color: #80abae;
        color: #80abae;
        background-color: #c3d8cf;
    }
    .student-share-style2{
        border-color: #b46e4c;
        color: #b46e4c; 
        background-color: #c3d8cf;
    }
    .student-share-style3{
        border-color: #e6b35d; 
        color: #e6b35d; 
        background-color: #c3d8cf;
    }
    .student-share-style4{
        border-color: #80abae; 
        color: #80abae; 
        background-color: #c3d8cf;
    }
    .student-share-style5{
        border-color: #b46e4c;
         color: #b46e4c; 
         background-color: #c3d8cf;
    }
</style>