<!-- START SECTION -->
<div class="section ptb_20 primary_bg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="title">體驗會日期<span class="square"></span><span class="title-line"></span></h2>
                <div class="row">
                    <div class="col-lg-3 col-sm-12">
                        {!! $meetingData['experience_meeting_date'] !!}
                    </div>
                    <div class="col-lg-9 col-sm-12">
                        <div class="detail">
                            <span class="square-small"></span>
                            時間：{{ $meetingData['4']->value[0]['time'] }}
                        </div>
                        <div class="detail">
                            <span class="square-small"></span>
                            上課地點：{{ $meetingData['5']->value[0]['address'] }}
                        </div>
                        <div class="detail">
                            <span class="square-small"></span>
                            費用：{{ $meetingData['experience_meeting_fee'] }}元 (現場繳費)
                        </div>
                        <div class="detail">
                            <span class="square-small"></span>
                            交通資訊：
                            <ol class="detail traffic">
                                {!! str_replace("\n", "<br>", $meetingData['6']->value[0]['traffic_info']) !!}
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION -->

<style>
    .traffic p{
        color: white;
    }
    .on_open{
        font-size: 20px;
    }
</style>    