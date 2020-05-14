$(function () {
    $(document).on("pageInit", "#map", function(e, id, page) {
        console.log('map');
        var startAddress,endAddress;

        $('.walkWay').click(function(){
            chooseWay(1);
        });
        $('.busWay').click(function(){
            chooseWay(2);
        });
        $('#checkWay').click(function(){
            checkWay();
        });
        function chooseWay(type){
            if(type == 1){
                $('.bus').removeClass('checkedType').attr('src','/Public/images/i_radioUn.png');
                $('.walk').addClass('checkedType').attr('src','/Public/images/i_radio.png');
            }
            if(type == 2){
                $('.walk').removeClass('checkedType').attr('src','/Public/images/i_radioUn.png');
                $('.bus').addClass('checkedType').attr('src','/Public/images/i_radio.png');
            }
        }

        var path = window.location.href;
        path = decodeURI(path);
        endAddress  = path.slice(path.lastIndexOf('?address=')+9);
        endAddress = $.trim(endAddress);
        $('#endAddress').val(endAddress);

        // 创建Map实例
        var map = new BMap.Map("allmap"); 
        $('#allmap').css('height','100%');
        map.enableScrollWheelZoom(true);
        map.enableContinuousZoom(true); 

        var longitude = 122.09395837,
            latitude = 37.52878708,
            address;
        var savePoint = {
            longitude: longitude,
            latitude: latitude
        };
        init();
        function init(){
            serMarker(savePoint);
            getPosition();
        }
        //根据浏览器定位
        function getPosition(){
            var geolocation = new BMap.Geolocation();
            geolocation.getCurrentPosition(function(r){
                if(this.getStatus() == BMAP_STATUS_SUCCESS){
                    //保存当前经纬度
                    savePoint = r.point;
                    longitude = savePoint.lng;
                    latitude = savePoint.lat;
                    console.log(savePoint);
                    
                    getAddress(savePoint);//根据经纬度获取地址

                    setCenterPos(savePoint);//根据经纬度设置地图中心点  
                }else {
                    alert('failed'+this.getStatus());
                }
            },{enableHighAccuracy: true})
        }
        //根据经纬度创建标注
        function serMarker(point){
            var mk = new BMap.Marker(point);
            map.addOverlay(mk);
            map.panTo(point);
        }
        //根据经纬度获取地址
        function getAddress(point){
            var gc = new BMap.Geocoder();
            gc.getLocation(point, function(rs){
                var addComp = rs.addressComponents;
                address = addComp.province +  addComp.city + addComp.district + addComp.street + addComp.streetNumber;
                console.log(address);
                $('#startAddress').val(address);
                startAddress = address;
                goByBus();
            }); 
        }
        //根据经纬度设置地图中心点
        function setCenterPos(point){
            map.clearOverlays(); 
            serMarker(point);
            map.centerAndZoom(point, 14);
        }
        //查询路线
        function checkWay(){
            var goType = $('img.checkedType').data('type');
            startAddress = $('#startAddress').val();
            endAddress = $('#endAddress').val();
            console.log(goType);
            switch(goType){
                case 1:
                    goByWalk();
                    break;
                case 2:
                    goByBus();
                    break;
            }
        }
        function goByWalk(){
            map.clearOverlays(); 
            var walking = new BMap.WalkingRoute(map, {renderOptions:{map: map, autoViewport: true}});
            walking.search(startAddress, endAddress);
        }
        function goByBus(){
            map.clearOverlays(); 
            var transit = new BMap.TransitRoute(map, {
                    renderOptions: {map: map}
                });
            transit.search(startAddress,endAddress);
        }
    });
    $.init();
});