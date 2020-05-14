(function (window, $) {
    window.FileHandler = FileHandler;

    var proto = {};

    function extend(target, source) {
        var keys = Object.keys(source);
        var i, len;
        var key;
        for (i = 0, len = keys.length; i < len; i++) {
            key = keys[i];
            target[key] = source[key];
        }
    }

    /**
     * @param {Object} dom 容器
     * @param {String} type 类型 img | file
     * @param {Array} fileurls 存放文件url的容器（外部注入）
     * @param {Object} opts 配置项
     */
    function FileHandler(dom, type, fileurls, opts) {
        var defaults = {
            fileInputSelector: '.file-input',
            root: '.content',
            remote: APP_PATH + '/Home/Tools/uploadImage?nosync=false',
            tipContainSelector: '.page',
            fileURLPropName: 'cdnurl'
        };
        this.handleImg = type === 'img' ? true : false; //img or plain file
        this.urls = fileurls;
        this.contain = dom;
        this.$contain = $(dom);
        extend(defaults, opts || (opts = {}));
        this.options = defaults;
        this.init();
    }

    FileHandler.prototype = proto;

    proto.init = function () {
        this.listenChange();
        this.bindDelete();
        if (this.handleImg) {
            this.imgsLive();
        }
    };

    proto.listenChange = function () {
        var selector = this.options.fileInputSelector;
        var $observed = this.$contain.find(selector), observed = $observed[0];
        var tipContain = $(this.options.tipContainSelector);

        var that = this;

        $observed.change(function (event) {
            uploadFile(observed, that.options.remote, function (data) {
                that.urls.push(data[that.options.fileURLPropName]);
                if (that.handleImg) {
                    createImg(data);
                } else {
                    createFile(data);
                }
            }, function () {
                fileReset($observed);
            }, tipContain);
        });

        function fileReset($input) {
            $input.wrap('<form></form>');
            $input.parent()[0].reset();
            $input.unwrap();
        }

        function createImg(item) {
            var src;
            var label = that.$contain.find('label');
            if (typeof FileReader === 'function') {
                var reader = new FileReader();
                reader.onload = function (event) {
                    src = event.target.result;
                    label.before('<img src="' + src + '" />');
                };
                reader.readAsDataURL(item.origin);
            } else {
                src = item.thumburl;
                label.before('<img src="' + src + '" />');
            }
        }

        function createFile(item) {
            var origin = item.origin;
            var sets = origin.name.split('.');
            var name = sets[0].slice(0, 4), ext = sets[sets.length - 1];
            var label = that.$contain.find('label');
            label.before('<span class="fileItem">' + name + '<br><b style="font-weight:normal;font-size:6px;color:#cc2">' + ext + '</b></span>');
        }
    };

    proto.clearAll = function () {
        var selector = this.handleImg ? 'img' : '.fileItem';
        this.$contain.find(selector).remove();
        this.urls.splice(0, this.urls.length);
    };

    proto.bindDelete = function () {
        if (this.handleImg) {
            this.bindImgDelete();
        } else {
            this.bindFileDelete();
        }
    }

    proto.bindFileDelete = function () {
        var that = this;
        bindTouch(that.$contain, 'span.fileItem', 50, {
            up: function (e) {
                e.target.classList.add('del');
                setTimeout(function () {
                    deleteFile(e.target);
                }, 300);
            }
        }, true);

        function deleteFile(elem) {
            var prev = elem.previousElementSibling, count = 0;
            while (prev) {
                count++;
                prev = prev.previousElementSibling;
            }
            that.urls.splice(count, 1);
            $(elem).remove();
        }
    };

    proto.bindImgDelete = function () {
        var that = this;
        bindTouch(that.$contain, 'img', 50, {
            up: function (e) {
                e.target.classList.add('del');
                setTimeout(function () {
                    deleteImg(e.target);
                }, 300);
            }
        }, true);

        function deleteImg(elem) {
            var prev = elem.previousElementSibling, count = 0;
            while (prev) {
                count++;
                prev = prev.previousElementSibling;
            }
            that.urls.splice(count, 1);
            $(elem).remove();
        }
    };

    proto.imgsLive = function () {

        this.$contain.off('click').on('click', 'img', function (e) {
            var src = e.target.src;
            var box = $('<div class="img-box"></div>');
            var img = $('<img src="' + src + '" />');

            img.css({
                "width": '100%',
            });
            
            box.html(img);
            document.body.appendChild(box[0]);
            window.addEventListener('popstate', popImg);

            history.pushState(null, '萝卜兼职', '#img');

            box.off('click').on('click', function () {
                box.remove();
                window.removeEventListener('popstate', popImg);
                history.back();
            });

            function popImg() {
                var re = /#img/, url = location.url;
                if (!re.test(url)) {
                    box.remove();
                    window.removeEventListener('popstate', popImg);
                }
            }
        });
    };

    function bindTouch(box, item, distance, callbacks, prevent) {
        var startX, startY;
        var RIGHT = 1, LEFT = 2, UP = 3, DOWN = 4, NOD = 0, attrs = ['up', 'down', 'left', 'right'];
        var targetImg;
        distance || (distance = 50);

        attrs.forEach(function (attr) {
            if (!callbacks[attr]) {
                callbacks[attr] = function () {};
            }
        });

        box.off('touchstart').on('touchstart', item, function (e) {
            targetImg = e.target;
            if (prevent) {
                e.preventDefault();
            }

            startX = e.touches[0].pageX;
            startY = e.touches[0].pageY;
        });

        box.off('touchend').on('touchend', item, function (e) {
            var endX = e.changedTouches[0].pageX, endY = e.changedTouches[0].pageY;
            var direction = getDirection(startX, startY, endX, endY);
            switch(direction) {
                case RIGHT: callbacks['right'](e); break;
                case LEFT: callbacks['left'](e); break;
                case UP: callbacks['up'](e); break;
                case DOWN: callbacks['down'](e); break;
            }
        });

        function getDirection(startX, startY, endX, endY) {
            var dX = endX - startX, dY = endY - startY;
            var result = NOD;

            if (Math.abs(dX) < 2 && Math.abs(dY) < 2 && targetImg.nodeName.toLowerCase() === 'img') {
                targetImg.click();
            }

            if (Math.abs(dX) < distance && Math.abs(dY) < distance) {
                return result;
            }

            var angle = getAngle(dX, dY);

            if (angle >= 45 && angle < 135) {
                result = DOWN;
            } else if ((angle >= 135 && angle < 180) || (angle >= -180 && angle < -135)) {
                result = LEFT;
            } else if (angle >= -135 && angle < -45) {
                result = UP;
            } else if ((angle >= -45 && angle < 0) || (angle >= 0 && angle < 45)) {
                result = RIGHT;
            }
            return result;
        }
        function getAngle(x, y) {
            return Math.atan2(y, x) * 180 / Math.PI;
        }
    }

    function uploadFile(input, remote, callback, always, tipContain) {
        var xhr = new XMLHttpRequest();
        xhr.timeout = 30000; //上传时限为30s
        xhr.responseType = 'json';

        var formData = new FormData();
        var file = input.files[0];
        formData.append('file', file);

        xhr.ontimeout = function () {
            removeProgressTip();
            $.toast('上传超时！');
        };
        xhr.upload.onprogress = uploadProgress;
        xhr.onprogress = downloadProgress;
        xhr.onloadstart = function () {
            console.log('up start!');
            createProgressTip(tipContain);
        };
        xhr.onload = function () {
            if((xhr.status >= 200 && xhr.status < 300) || xhr.status == 304){
                var res = xhr.response, src;
                if (res.code === 0) {
                    removeProgressTip();
                } else {
                    res.data.origin = file;
                    removeProgressTip();
                    callback(res.data);
                }
            }
        };
        xhr.onabort = removeProgressTip;
        xhr.onerror = removeProgressTip;

        xhr.open('POST', remote);

        xhr.send(formData);

        function uploadProgress(event) {
            if (event.lengthComputable) {
                var percentComplete = event.loaded / event.total;
                $('.progress-tip').html('上传中: ' + parseInt(percentComplete * 100) + '%');
            }
        }
        function downloadProgress(event) {
            if (event.lengthComputable) {
                var percentComplete = event.loaded / event.total;
                $('.progress-tip').html('图片处理中...');
            }
        }
        function createProgressTip(contain) {
            $(contain).append('<div class="progress-tip"></div>')
        }
        function removeProgressTip() {
            $('.progress-tip').remove();
            always();
        }
    }

}(window, $));