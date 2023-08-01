<div style="max-width: 650px; border-radius: 20px; background: #e6e6e7; color: #5B5B5B; margin: 2em auto;">
    <div class="coupon-form">
        <img src="{{ $webPath }}assets/images/coupon-header@600.png" style="
            width: 100%; 
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        "/>

        <div style="float: right; padding-right: 2em;">{{ $randomCode }}</div>

        <div style="padding: 2em; font-size: 16px; line-height: 28px;">
            <div>
                <div>姓名:<span style="margin-left: 0.5em;">{{ $memberName }}</span></div>
                <div>電話:<span style="margin-left: 0.5em;">{{ $memberTel }}</span></div>
                <div>信箱:<span style="margin-left: 0.5em;">{{ $memberEmail }}</span></div>
            </div>

            {{-- <div style="margin-top: 1em;">體驗會資訊:</div> --}}
            <div style="margin-top: 1em;">
                <div><span style="">課程名稱:</span><span style="margin-left: 0.5em;">{{ $courseName }}</span></div>
                <div>
                    <span style="">日期:</span>
                    <div style="margin-left: 1em;">
                    @foreach($meetingDate as $v)
                        <div>{{ $v }}</div>
                    @endforeach
                    </div>
                </div>
                <div><span style="">時間:</span><span style="margin-left: 0.5em;">{{ $meetingData['4']->value[0]['time'] }}</span></div>
                <div>
                    <span style="">上課地點:</span><span style="margin-left: 0.5em;">{{ $meetingData['5']->value[0]['address'] }}</span>
                    <a href="http://maps.google.com?q={{ $meetingData['5']->value[0]['address'] }}" style="margin-left: 0.5em;">
                        <img src="{{ $webPath }}assets/images/map-icon1.png" alt="生命探索" class="" style="outline: none; width: 32px;">
                    </a>
                </div>
                <div>
                    <span style="">交通資訊:</span>
                    <div style="margin-left: 1em;">{!! str_replace("\n", "<br>", $meetingData['6']->value[0]['traffic_info']) !!}</div>
                </div>
                <div>
                    <span style="">連絡電話:</span>
                    <div style="margin-left: 1em;">
                    @foreach($meetingData['2']->value as $v)
                        <div>
                            <span>{{ $v['name'] }}</span>
                            <span>{{ $v['phone'] }}</span>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>

            <div style="margin-top: 1em;">注意事項:</div>
            <div style="margin-left: 1em;">
                <div>1. 報到時，請出示本優惠券。</div>
                <div>2. 本張優惠券只能用一次。</div>
                <div>3. 優惠券不能合併使用。</div>
            </div>
        </div>

    </div>
</div>

<div style="width: 650px; margin: 2em auto 0;">
    <a href="https://life-explore.com.tw/" style="">
        <img src="{{ $webPath }}assets/images/logo.png" alt="生命探索" class="" style="width: 130px; margin-top: 1em; outline: none;">
    </a>
    <a href="https://www.facebook.com/yunroung" style="">
        <img src="{{ $webPath }}assets/images/FB-Icon.png" alt="生命探索" class="" style="width: 35px; margin: 0 1em; outline: none;">
    </a>

    <div style="margin-top: 1em; color: black; font-size: 14px;">
        <div>本信件由系統自動發送，請勿直接回覆此郵件。</div>
        <div>如果您有問題或建議，歡迎您與我們聯絡。</div>
    </div>
</div>