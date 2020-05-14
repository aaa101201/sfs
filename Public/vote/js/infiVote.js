'use strict';

$(function () {

    $(document).on('pageInit', '#infi_rule', function (e, id, page) {
        console.log('inited page::', 'infi_rule');

        var reward = localStorage.getItem('voteReward');
        var rule = localStorage.getItem('voteRule');
        if (reward && reward !== 'null') {
            $('#reward').html(reward.replace(/\n/g, '<br/>'));
            $('.prize').show();
        }
        if (rule && rule !== 'null') {
            $('#rule').html(rule.replace(/\n|\s/g, '<br/>'));  // convert line feed or white space to a <br/> in HTML
            $('.rules').show();
        }
    });

    $(document).on('pageInit', '#infi_detail', function (e, id, page) {
        console.log('inited page::', 'infi_detail');

        var item_id = getParam('item_id', 0);
        var id = getParam('id', 0);

        var share = $('.iconv-share').parent(), heart = $('.iconv-heart').parent();

        $.ajax({
            type: 'POST',
            url: APP_PATH + '/Home/Vote/isVoted',
            dataType: 'json',
            data: {
                id: id
            },
            success: function (res) {
                if (res.code && res.data == 1) {
                    heart.html('已投票');
                }
            }
        });

        $.ajax({
            type: 'POST',
            url: APP_PATH + '/Home/Vote/userDetail',
            dataType: 'json',
            data: {
                voteItemId: item_id
            },
            success: function (res) {
                if (res.code) {
                    var data = res.data;
                    data.intro = data.intro.replace(/\n/g, '<br/>');
                    var html = template('tpl-detail', {item: data});
                    $('.wrap').html(html);
                }
            },
            error: server_error
        });

        heart.off('click').on('click', function () {
            var self = $(this);
            $.ajax({
                type: 'POST',
                url: APP_PATH + '/Home/vote/submit',
                dataType: 'json',
                data: {
                    id: id,
                    type: 1,
                    itemId: item_id
                },
                success: function (res) {
                    if (res.code) {
                        $.toast('投票成功~', 1000);
                        $('.iconv-heart').addClass('heartbit');
                        var c = $('.vote_count').html();
                        $('.vote_count').html(parseInt(c) + 1);
                        setTimeout(function () {
                            location.href = APP_PATH + '/Home/Vote/infi_vote?id=' + id;
                        }, 1000);
                        return;
                    } else {
                        $.toast(res.msg);
                        return;
                    }
                },
                error: server_error
            });
        });

        share.off('click').on('click', function () {
            $.toast('请点击右上角完成分享', 1000);
        });  
    });

    $(document).on('pageInit', '#infi_statistics', function (e, id, page) {
        console.log('inited page::', 'infi_statistics');

        var vote_id = getParam('id', 0);

        //for creating the chart
        var hasloaded = loadChart();
        var ctx = document.getElementById('bar').getContext('2d');
        if (hasloaded) {
            getRank();
        } else {
            window.chart_script.onload = getRank;
        }

        var pageSize = 10,
        currPage = 1,
        loading = false,
        maxItems = 10,
        stored = Object.create(null);

        var lastIndex = 10;

        //clear the list-block
        $('#rank_more').empty();

        //binding infinite scroll event
        $(document).off('infinite').on('infinite', '.infinite-scroll', function () {
            if (loading) return;
            loading = true;
            setTimeout(function () {
                loading = false;
                if (lastIndex >= maxItems) {
                    $.detachInfiniteScroll($('.infinite-scroll'));
                    $('.infinite-scroll-preloader').remove();
                    return;
                }
                addItems();
                lastIndex = $('#rank_more tr').length;
                $.refreshScroller();
            }, 500);
        });


        function getRank() {
            $.ajax({
                type: 'POST',
                url: CON_PATH + '/votedBI',
                datatype: 'json',
                data: { id: vote_id },
                success: function (res) {
                    console.log('votedBI:res', res);
                    if (res.code) {
                        var data = res.data;
                        createBar(ctx, data, ['id', 'total', 'title'], 3); //3指定想要显示的横坐标数
                        stored = data;
                        //init add
                        addItems();

                        //judge is enough or not
                        if (lastIndex >= maxItems) {
                            $.detachInfiniteScroll($('.infinite-scroll'));
                            $('.infinite-scroll-preloader').remove();
                            return;
                        }
                    }
                }
            });
        }

        function addItems() {
            console.log('execute', 'addItems()');
            maxItems = stored.length;
            var start = 3 + (currPage - 1) * pageSize, end = start + pageSize;
            var items = stored.slice(start, end);
            if (items.length) {
                items = items.map(function (item, index) {
                    item.rank = start + index + 1;
                    return item;
                });
            }
            
            if (items.length) {
                $('#rank_more').append(template('tpl-results', { items: items, id: vote_id }));
                currPage++;
            } else {
                $('#rank_more_head').hide();
            }
        }
    });

    $(document).on('pageInit', '#infi_add', function (e, id, page) {
        console.log('inited page::', 'infi_add');
        var vote_id = getParam('id', 0);

        var inject = {};
        $('#photo').off('change').change(function (event) {           
            uploadPhoto(inject);
        });
        $('#submit').off('click').click(function submitOnce(event) {

            $('#submit').off('click', submitOnce);

            var obj = {
                id: vote_id,
                title: $('#title').val(),
                phone: $('#phone').val(),
                image: inject.url,
                thumbImage: inject.thumburl,
                intro: $('#intro').val()
            };
            if (!checkInfo(obj)) return false;
            var xhr = new XMLHttpRequest();
            xhr.timeout = 10000; //上传时限为10s
            xhr.responseType = 'json';
            var formData = new FormData();
            var keys = Object.keys(obj);
            for (var i = 0; i < keys.length; i++) {
                var key = keys[i];
                formData.append(key, obj[key]);
            }
            xhr.open('POST', APP_PATH + '/Home/Vote/addItem');
            xhr.onload = function () {
                if ((xhr.status >= 200 && xhr.status < 300) || xhr.status == 304) {
                    var res = xhr.response;
                    //console.log(res)
                    if (res.code) {
                        $.toast('报名成功~', 1000);
                        setTimeout(function () {
                            $.router.back();
                        }, 1000);
                    }
                    else {
                        $.toast('报名失败！');
                        $('#submit').on('click', submitOnce);
                        return false;
                    }
                }
            };
            xhr.onerror = function () {
                $('#submit').on('click', submitOnce);
            };
            xhr.send(formData);
        });
    });

    var hasLoaded = false, lastIndex = 6, currPage = 1, canVote = true, disStat = false, disJoin = true;

    $(document).on('pageInit', '#infi_vote', function (e, id, page) {

        //console.log('inited page::', 'infi_vote');
        var vote_id = getParam('id', 0), vote_subType = getParam('num', 1);
        var vote_type = 1;  //0:有限 1:无限
        var statUrl = CON_PATH + '/infi_statistics?id=' + vote_id;
        var joinUrl = CON_PATH + '/infi_add?id=' + vote_id;

        var pageSize = 6, loading = false, maxItems = 100, cont = $('#join_list');

        if (!hasLoaded) {
            addItems().then(function () {
                judgeCreate(statUrl, joinUrl);
                handleVote();
            });
            hasLoaded = true;   
        }
        else {
            judgeCreate(statUrl, joinUrl);
            handleVote();
        }

        //获取首页投票统计数据
        $.ajax({
            type: 'POST',
            url: CON_PATH + '/voteStatistics',
            data: { "id": vote_id },
            dataType: 'json',
            success: function (res) {
                console.log('voteStatistics:res', res);
                if (res.code !== 0) {
                    var data = res.data;
                    var join_num = data.joinCount,
                    vote_num = data.votedCount,
                    visit_num = data.accessCount;
                    $('#join_num').html(join_num || 0);
                    $('#vote_num').html(vote_num || 0);
                    $('#visit_num').html(visit_num || 0);
                }
            }
        });

        //binding infinite scroll event
        $(document).off('infinite').on('infinite', '.infinite-scroll', function () {
            if (loading) return;
            loading = true;
            setTimeout(function () {
                loading = false;
                if (lastIndex >= maxItems) {
                    $.detachInfiniteScroll($('.infinite-scroll'));
                    $('.infinite-scroll-preloader').remove();
                    return;
                }
                addItems();
                lastIndex = $('#join_list li').length;
                $.refreshScroller();
            }, 500);
        });

        var prevY, currY, tid, direction, add = $('.addItem');
        $(document).off('touchstart').on('touchstart', '#join_list', function (e) {
            prevY = e.changedTouches[0].screenY;
        });
        $(document).off('touchmove').on('touchmove', '#join_list', function (e) {
            currY = e.changedTouches[0].screenY;
            if (currY > prevY) {
                direction = 1;
            } else {
                direction = 0;
            }
            prevY = currY;
            if (tid) return;
            tid = setTimeout(function () {
                if (direction) {
                    add.removeClass('hiddenBtn');
                } else {
                    add.addClass('hiddenBtn');
                }
                tid = null;
            }, 100);
        });

        function addItems() {

            return new Promise(function (resolve, reject) {
                $.ajax({
                    type: 'POST',
                    url: APP_PATH + '/Home/Vote/detail',
                    dataType: 'json',
                    data: {
                        id: vote_id,
                        type: vote_type,
                        page: currPage,
                        pageSize: pageSize
                    },
                    success: function (res) {
                        if (res.code) {
                            maxItems = res.data.total;
                            //存储
                            localStorage.setItem('voteReward', res.data.reward);
                            localStorage.setItem('voteRule', res.data.info);
                            cont.append(template('tpl-votes', { items: res.data.items, id: vote_id }));
                            currPage++;

                            var endtime = res.data.endtime && res.data.endtime.trim();
                            
                            var d = new Date(endtime);
                            if (/[\D]/.test(d)) {
                                endtime = endtime.replace(/\-/g, '/');
                            }

                            var timeToHandle = new Date(endtime).getTime() - new Date().getTime();
                            
                            var obj = handleTime(timeToHandle);
                            if (parseInt(res.data.status) !== 1) {
                                obj.reset();
                            }
                            $(window).off('pageRemoved').on('pageRemoved', function () {
                                clearInterval(obj.timer);
                            });
                            resolve();

                            if (lastIndex >= maxItems) {
                                $.detachInfiniteScroll($('.infinite-scroll'));
                                $('.infinite-scroll-preloader').remove();
                            }
                        } else {
                            $.detachInfiniteScroll($('.infinite-scroll'));
                            $('.infinite-scroll-preloader').remove();
                            resolve();
                        }
                    },
                    error: server_error
                });
            });
        }

        //判断是否投过票
        function judgeCreate(statUrl, joinUrl) {
            $.ajax({
                type: 'POST',
                url: APP_PATH + '/Home/Vote/isVoted',
                dataType: 'json',
                data: {
                    id: vote_id
                },
                success: function (res) {
                    if (res.code) {
                        if (res.data == 1) {
                            disStat = true;
                        }
                        if (!canVote) {
                            disJoin = false;
                        }
                        createMore(disStat, disJoin, statUrl, joinUrl, APP_PATH + '/Home/Vote/infi_vote?id=' + vote_id + '&t=' + new Date().getTime());
                    }
                }
            });
        }

        //处理用户投票逻辑
        function handleVote() {
            if (canVote) {
                cont.off('click').on('click', 'button', function () {
                    var self = $(this);
                    $.ajax({
                        type: 'POST',
                        url: APP_PATH + '/Home/vote/submit',
                        dataType: 'json',
                        data: {
                            id: vote_id,
                            type: vote_type,
                            itemId: $(this).data('id')
                        },
                        success: function (res) {
                            if (res.code) {
                                $.toast('投票成功~');
                                var temp = self.parent().find('.vote_num');
                                console.warn(temp);
                                temp.html(parseInt(temp.html()) + 1);
                                self.html('已投票');
                                self.find('.iconv-heart').addClass('heartbit');
                                judgeCreate(statUrl, joinUrl);
                                return;
                            } else {
                                $.toast(res.msg);
                                return;
                            }
                        },
                        error: server_error
                    });
                });
            } else {
                cont.off('click').click(function (e) {
                    var target = e.target;
                    if (target.nodeName.toLowerCase() === 'button') {
                        $.toast('该活动已结束~');
                        return false;
                    }
                });
            }
        }
    });

    //初始化
    $.init();

    /*-------------------------------------通用函数库-------------------------------------------------------------------------
    ---------------------------------------供各页面调用------------------------------------------------------------------------*/
    function createBar(ctx, originData, attrs, num) {

        var colors = [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 159, 64, 0.8)'
        ];

        var temp = plunk(originData, attrs);

        if (num) {
            for (var key in temp) {
                temp[key] = temp[key].slice(0, num);
            }
        }

        temp.colors = temp[attrs[0]].map(function (value, index) {
            return colors[index % (num || 6)];
        });

        var labels = null;
        if (labels = temp[attrs[2]]) {
            labels = labels.map(function (label) {
                label = label.replace(/(&nbsp;)+/g, ' ');
                if (label.length < 5) {
                    return label;
                } else {
                    return label.slice(0, 4) + '..';
                }
            });
        }
        temp[attrs[2]] = labels;

        var data = {
            labels: temp[attrs[2] || attrs[0]],
            datasets: [{
                label: '投票统计',
                backgroundColor: temp.colors,
                data: temp[attrs[1]]
            }]
        };
        var options = {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    type: 'linear',
                    ticks: {
                        min: 0
                    }
                }]
            }
        };

        var myBar = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: options
        });
    }

    function plunk(arr, wants) {
        var attrs = (typeof wants === 'string') ? [wants] : wants;
        if (!arr || !attrs || attrs.length === 0) {
            console.log('func plunk: 参数格式不正确\n' + 'arr: ' + arr + '\nattrs: ' + attrs);
            return false;
        }

        if (typeof arr[0] === 'object') {
            var l = attrs.length, i = 0, results = {};
            for (; i < l; i++) {
                results[attrs[i]] = [];
                arr.forEach(function (data) {
                    results[attrs[i]].push(data[attrs[i]]);
                });
            }
            return results;
        }
    }

    function loadChart() {
        var script = document.getElementById('chart_script');
        if (!script) {
            var chart_script = document.createElement('script');
            chart_script.setAttribute('id', 'chart_script');
            document.body.appendChild(chart_script);
            chart_script.setAttribute('src', '/Public/vote/js/Chart.bundle.min.js');

            window.chart_script = chart_script;
            return false;
        } else {
            return true;
        }
    }

    function uploadPhoto(inject) {
        var xhr = new XMLHttpRequest();
        xhr.timeout = 30000; //上传时限为30s
        xhr.responseType = 'json';

        var formData = new FormData();
        var file = $('#photo')[0].files[0];
        formData.append('file', file);

        xhr.ontimeout = function () {
            $.toast('上传超时！');
        };
        xhr.upload.onprogress = uploadProgress;
        xhr.onloadstart = function () {
            console.log('up start!');
            $('#photo_btn').addClass('file_ph');
            var back = document.getElementById('photo_btn');
            back.style.background = 'linear-gradient(to right, rgba(100, 143, 150, 0.3) 0, rgba(100, 143, 150, 0.3) 100%) 0% 0% / 0% 100% no-repeat';
        };

        xhr.onload = function () {
            if((xhr.status >= 200 && xhr.status < 300) || xhr.status == 304){
                var res = xhr.response, src;
                if (res.code !== 0) {
                    $.toast('上传失败了！');
                } else {
                    //console.log('上传成功了！');
                    $('#photo_btn').removeClass('file_ph');
                    //inject.url = res.data.url;
                    inject.url = res.localPath;
                    //inject.thumburl = res.data.thumburl;
                    inject.thumburl = res.localPath;
                    if (typeof FileReader === 'function') {
                        var reader = new FileReader();
                        reader.onload = function (event) {
                            src = event.target.result;
                            $('#photo_btn').css({
                                "background": 'url(' + src + ') no-repeat center center / cover'
                            });
                        };
                        reader.readAsDataURL(file);
                    } else if (res.data.url && res.data.url.length) {
                        src = res.data.url;
                        $('#photo_btn').css({
                            "background": 'url(' + src + ') no-repeat center center / cover'
                        });
                    }
                }
            }
        };

        //xhr.open('POST', APP_PATH + '/Home/Tools/uploadImage?nosync=true');
        xhr.open('POST', APP_PATH + '/Home/File/upload?nosync=true');

        xhr.send(formData);

        return xhr;

        function uploadProgress(event) {
            console.log('up...')
            if (event.lengthComputable) {
                var percentComplete = event.loaded / event.total;
                console.log(percentComplete * 100 + '%');
                var back = document.getElementById('photo_btn');
                back.style.backgroundSize = percentComplete * 100 + '% 100%';
            }
        }
    }

    function checkInfo(obj) {
        //console.log(obj);
        for (var key in obj) {
            obj[key] = obj[key] && obj[key].trim();
            if (!obj[key]) {
                $.toast('信息填写不完整！');
                console.log(obj[key]);
                return false;
            }
        }
        if (!/^1(3|4|5|7|8)\d{9}$/.test(obj.phone)) {
            $.toast('电话号码格式不正确！');
            return false;
        }
        return true;
    }

    function handleTime(time2dead) {
        time2dead = parseInt(time2dead);

        if (time2dead < 0 || time2dead === 0) {
            resetTime();
            return false;
        }
        var DAY = 24 * 3600 * 1000, HOUR = 3600 * 1000, MINUTE = 60 * 1000, SECOND = 1000;

        var d = Math.floor(time2dead / DAY); time2dead %= DAY;
        var h = Math.floor(time2dead / HOUR); time2dead %= HOUR;
        var m = Math.floor(time2dead / MINUTE); time2dead %= MINUTE;
        var s = Math.floor(time2dead / SECOND);

        setTime();

        var time_loop = setInterval(function () {

            s--;
            if (s < 0) {
                m--;
                s = 59;
                if (m < 0) {
                    h--;
                    m = 59;
                    if (h < 0) {
                        d--;
                        h = 23;
                        if (d < 0) {
                            resetTime(); clearInterval(time_loop); return;
                        }
                    }
                }
            }

            setTime();
        }, 1000);
        function setTime() {
            $('#time_d').html(d.toString().length === 1 ? ('0' + d) : d);
            $('#time_h').html(h.toString().length === 1 ? ('0' + h) : h);
            $('#time_m').html(m.toString().length === 1 ? ('0' + m) : m);
        }
        function resetTime() {
            $('#time2dead').html('活动已结束');
            $('#time2dead').addClass('timedead');
            canVote = false;
        }

        return {
            timer: time_loop,
            reset: resetTime
        };
    }

    function getParam(str, deflt) {
        var search = decodeURIComponent(location.search);
        var result = new RegExp('[\\W]' + str + '=([0-9]*)').exec(search);
        result = result ? result[1] : deflt;
        return result; 
    }

    function createMore(disStat, disJoin, statUrl, joinUrl, reloadUrl) {
        console.log('execute', 'createMore()');
        var plus = $('.addItem'), overlay = $('.addOverlay'), join = document.getElementById('Join'), stat = document.getElementById('Stat'),
        reload = document.getElementById('Reload');
        if (disStat) {
            stat.style.display = 'block';
        }
        if (disJoin) {
            join.style.display = 'block';
        }

        plus.click(function () {
            plus.addClass('pending');
            overlay.addClass('pending');
        });
        overlay.click(function (e) {
            plus.removeClass('pending');
            overlay.removeClass('pending');
        });
        stat.firstElementChild.setAttribute('href', statUrl);
        join.firstElementChild.setAttribute('href', joinUrl);
        reload.onclick = function () {
            location.href = reloadUrl;
        };
    }
});
