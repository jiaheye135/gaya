var gMyJs = {
    files: {},
    
    doAjax: function (url, data, callback, errorCallback, hasFile, async) {
        async = async ===false ? false : true;

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            async: async, // 預設是true：非同步，false：同步。
        });

        var option = {
            url: url,
            type: "POST",
            dataType: "json",
            data: data,
            success: function (resData) {
                if (typeof callback === "function") callback(data, resData);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr, ajaxOptions, thrownError);
                if (typeof errorCallback === "function") errorCallback(data);
            },
        };
        if (hasFile) {
            option.contentType = false;
            option.processData = false;
        }
        return $.ajax(option);
    },

    sendForm: function (page, formData) {
        var form = document.createElement("form");
        form.style.cssText = "display: none;";

        form.method = "POST";
        form.action = page;

        for (name in formData) {
            var e = document.createElement("input");
            e.name = name;
            e.value = formData[name];
            form.appendChild(e);
        }

        var e = document.createElement("input");
        e.name = "_token";
        e.value = $('meta[name="csrf-token"]').attr("content");
        form.appendChild(e);

        document.body.appendChild(form);
        form.submit();
    },

    // 清除表單錯誤訊息
    chearErrorMsg: function () {
        $(".my-error_msg").text("").hide();
    },

    // 表單錯誤訊息
    showErrorMsg: function (group, errorMsg) {
        if (group) {
            group.find(".my-error_msg").text(errorMsg).show();
        }
    },

    // 表單檢查空值
    checkEmpty: function (value, group, errorMsg, title, type, obj) {
        var canEmpty = false;
        if (title && title.substr(0, 1) != '*') canEmpty = true;

        // 檢查空值
        if (!canEmpty && !value) {
            this.showErrorMsg(group, errorMsg ? errorMsg : "欄位不能為空");
            return { 'error': 1 };
        }
        // 檢查select
        if (type == 'select' && value == 0 && obj.find('option:selected').text() == '請選擇') {
            this.showErrorMsg(group, errorMsg ? errorMsg : "欄位不能為空");
            return { 'error': 1 };
        }

        return { 'value': value };
    },

    // post 參數 encode
    jwtEncode: function (data) {
        return encodeURIComponent(
            btoa(encodeURIComponent(JSON.stringify(data)))
        );
    },

    // 表單用, 預覽圖片主程式
    preview: function (input, inputGroup) {
        if ( !(input.files && input.files.length > 0) ) return;
        // console.log(input.files, input.files.length); // debug
    
        var group = $(input).parents('.' + inputGroup), key = group.find(':file').attr('name'), type = group.find(':file').data('type');
        if(type == 'singlefile'){
            this.setupReader( group, input.files[0], '', key, type );
        }
    
        if(type == 'multiple'){
            for(var i=0; i<input.files.length; i++){
                group.find('.preview').find('tbody:last').append( previewTr(1, key, imgCount) );
                this.setupReader( group, input.files[i], (key + imgCount), key, type );
                imgCount++;
            }
        }
    },

    // 表單用, 預覽圖副程式
    setupReader: function (group, file, imgId, key, type) {
        var reader = new FileReader();
        var img = new Image();

        reader.onload = function(e) {
            img.src = e.target.result;

            if(type === 'multiple'){
                $('#' + imgId + 'radio').val(file.name); 
                $('#' + imgId + 'name').text(file.name); 
                var KB = format_float(e.total / 1024, 2);
                $('#' + imgId + 'size').text(KB);
                $('#' + imgId).attr('src', e.target.result);
            }
        }

        img.onload = function() {
            if(type === 'singlefile'){
                group.find('.my-file_name').text(file.name + ' (' + this.width + 'x' + this.height + ')').show(); 
                group.find('img').attr('src', img.src).show();
            }
        }

        reader.readAsDataURL(file);

        if( !(key in this.files) || type === 'singlefile') this.files[key] = {};    //若為單圖片上傳 只保留一張圖片
        this.files[key][file.name] = file;
    },

    // 表單設值
    setValus: function (asset, data, groupClassName){
        var submitList = {};
        for(var i=0; i<data.length; i++){
            var d = data[i], id = d.id, userVal = d.value;
            if(!userVal && userVal != 0) continue;

            switch(d.type){
                case 'checkbox':
                    $('#' + id).prop('checked', parseInt(userVal));
                    break;
                case 'singlefile':
                    if(userVal){
                        var group = $('#' + id).parents('.' + groupClassName);
                        var name = userVal.split(/\/|\?/).slice(-2, -1)[0];

                        var img = new Image();
                        img.onload = function() {
                            var group = this.myImgGroup, size = this.width + 'x' + this.height;
                            group.find('.my-file_name').text(group.find('.my-file_name').text() + ' (' + size + ')').show(); 
                        };
                        img.src = asset + userVal;
                        img.myImgGroup = group;

                        group.find('.my-file_name').text(name).show(); 
                        group.find('img').attr('src', asset + userVal).show();
                    }
                    break;
                case 'select':
                    if(d.option && Object.keys(d.option).length > 0){
                        var h = '';
                        for(var key in d.option){
                            h += '<option value="' + key + '">' + d.option[key] + '</option>';
                        }
                        $('#' + id).html(h);
                    }
                    $('#' + id).val(userVal);
                    break;
                case 'textarea':
                    userVal = userVal.replace(/<br>/g, "\n");
                case 'video_urls':
                  gMyJs.reviewVideo(userVal);
                default:
                    $('#' + id).val(userVal);
            }

            if(d.canEdit == 1){
                submitList[id] = d;
            } else {
                $('#' + id).prop('disabled', true);
                $('#' + id).css('border', 'none');
            }
        }
        return submitList;
    },

    reviewVideo: function(videoUrl){
      console.log(1);
      var videoUrl = videoUrl ? videoUrl : $('#video_urls').val();
      videoUrl = videoUrl.replace(/width=".*?"/ , 'width="100%"').replace(/height=".*?"/, 'height="300"');
      $('#video_review').html(videoUrl);

      videoUrl = videoUrl.replace(/width=".*?"/ , 'width="100%"').replace(/height=".*?"/, 'height="450"');
      $('#video_urls').val(videoUrl);
    },

    // 資料儲存
    save: function(btnObj, api, submitList, groupClassName, doType, titlePos){
        
        this.chearErrorMsg();

        var err = false, data = {};
        for(var id in submitList){
            var mData = submitList[id], obj = $('#' + id), newVal = '';
            var group = obj.parents('.' + groupClassName);

            var title = group.parents('.card').find('.card-header .title').text();
            if(titlePos == 'group'){
                title = group.find('.title').text();
            }

            switch(mData['type']){
                case 'singlefile':
                    newVal = group.find('.my-file_name').text();
                    break;
                case 'editor':
                    newVal = CKEDITOR.instances[id].getData();
                    break;
                case 'textarea':
                    newVal = obj.val().trim().replace(/\n/g, '<br>');
                    break;
                default:
                    newVal = obj.val().trim();
            }

            var res = this.checkEmpty(newVal, group, null, title, mData['type'], obj);
            if('error' in res){ err = true; }
            if('value' in res){
                data[id] = res.value;
            }
        };

        if(err){ alert('請檢查欄位'); return; }

        var formData = new FormData();
        formData.append('data', this.jwtEncode({'data': data, 'type': doType.type, 'id': doType.id}));

        for(var key in this.files){
            for(var name in this.files[key]){
                formData.append('files[' + key + '][' + name + ']', this.files[key][name]);
            }
        }

        // setLoadingBtn(btnObj, 'open');

        this.doAjax(gBasePath + api, formData, 
            function(data, resData){
                // setLoadingBtn(btnObj, 'close');

                if (resData.success) {
                    alert('儲存成功');
                    // redirect('studentShareMgmt');
                } else {
                    alert('儲存失敗');
                }
            },
            function(){
                // setLoadingBtn(btnObj, 'close');
                
                alert('系統錯誤');
            }, 
            true
        );
    },

    setLoadingBtn: function(btnObj, action){
        if(action == 'open'){
            gCanSave = false;
            $(btnObj).find('span').hide();
            $(btnObj).find('img').show();
        }

        if(action == 'close'){
            gCanSave = true;
            $(btnObj).find('span').show();
            $(btnObj).find('img').hide();
        }
    }
};
